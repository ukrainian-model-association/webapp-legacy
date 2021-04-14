<?php

/**
 * This file is part of the modelsua/modelsua package.
 */

load::system('http/request');

class imgserve
{
    /**
     * @var array
     */
    private $config;

    /**
     * imgserve constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = $config;
    }


    public function execute()
    {
        $act = request::get('act');

        if ('upload' === $act) {
            if (!$res = $this->$act()) {
                echo 0;
            } else {
                echo $res;
            }

            return true;
        }

        $this->getPhoto();

        return true;
    }

    /**
     * @return false
     * @throws ImagickException
     */
    private function getPhoto()
    {
        $photoId      = request::get_int('pid');
        $x            = request::get_int('x');
        $y            = request::get_int('y');
        $width        = request::get_int('w');
        $height       = request::get_int('h');
        $withCropping = 'crop' === request::get_string('z');
        $imageQuality = (int) $this->config['image_server']['image_quality'];

        // die(var_dump($_SERVER['REQUEST_URI']));

        $tempDir   = sprintf('%s/data/temp', conf::get('project_root'));
        $imagesDir = sprintf('%s/%s', $tempDir, $photoId);
        if (!file_exists($imagesDir) && !mkdir($imagesDir) && !is_dir($imagesDir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $imagesDir));
        }

        $originFilepath = sprintf('%s/%s.jpg', $imagesDir, $photoId);
        $targetFilepath = sprintf(
            '%s/%d-%s.jpg',
            $imagesDir,
            $photoId,
            md5(implode('/', [$x, $y, $width, $height, (int) $withCropping]))
        );

        $image = new Imagick();

        if (file_exists($targetFilepath) && $targetFile = fopen($targetFilepath, 'rb+')) {
            $image->readImageFile($targetFile, $targetFilepath);
            fclose($targetFile);
        } else {
            if (file_exists($originFilepath) && $originFile = fopen($originFilepath, 'rb+')) {
                $image->readImageFile($originFile, $originFilepath);
                fclose($originFile);
            } else {
                $pdo   = $this->getPdo();
                $query = $pdo->prepare('select photo from user_photos where id = :id');
                $query->execute(
                    [
                        'id' => (int) $photoId,
                    ]
                );

                $photo = $query->fetchColumn();
                if (!$photo) {
                    return false;
                }

                // $content = pg_unescape_bytea($photo);
                $image->readImageBlob(stream_get_contents($photo), $originFilepath);
                // $image->setImageCompression(Imagick::COMPRESSION_ZIP);

                if ($f = fopen($originFilepath, 'wb+')) {
                    $image->writeImageFile($f);
                    fclose($f);
                }
            }

            // $image->setImageCompressionQuality($imageQuality);

            if ($withCropping) {
                $image->cropImage($width, $height, $x, $y);
            } elseif (0 !== $width || 0 !== $height) {
                $image->scaleImage($width, $height);
            }

            if ($f = fopen($targetFilepath, 'wb+')) {
                $image->writeImage($targetFilepath);
                fclose($f);
                // copy($targetFilepath, $tempDir.$_SERVER['REQUEST_URI']);
            }
        }

        $imageBlob     = $image->getImageBlob();
        $contentType   = sprintf('image/%s', strtolower($image->getImageFormat()));
        $contentLength = $image->getImageLength();

        $image->clear();

        // if (null === $height) {
        //     if (!$withCropping) {
        //         $percent = ($width * 100) / $imgSize[0];
        //         $height  = ($imgSize[1] * $percent) / 100;
        //     } else {
        //         $height = $imgSize[1];
        //     }
        // } elseif (!$width) {
        //     $percent = ($height * 100) / $imgSize[1];
        //     $width   = ($imgSize[0] * $percent) / 100;
        // }
        //
        // $width  = $width > $imgSize[0] ? $imgSize[0] : $width;
        // $height = $height > $imgSize[1] ? $imgSize[1] : $height;
        //
        // if ($withCropping) {
        //     $image->cropImage($width, $height, $x, $y);
        // } else {
        //     $image->resizeImage($width, $height, Imagick::FILTER_POINT, 1);
        // }

        header(sprintf('Content-Type: %s', $contentType));
        header(sprintf('Content-Length: %s', $contentLength));

        echo $imageBlob;

        exit;
    }

    private function getPdo()
    {
        $cfg = conf::get('databases')['master'];
        $dsn = sprintf(
            '%s:host=%s;port=%s;dbname=%s;user=%s;password=%s',
            $cfg['driver'],
            $cfg['host'],
            $cfg['port'],
            $cfg['dbname'],
            $cfg['user'],
            $cfg['password']
        );

        return new PDO($dsn);
    }

    private function upload()
    {
        $key = request::get('key');
        if (!array_key_exists($key, $_FILES)) {
            return false;
        }

        $filename = $_FILES[$key]['tmp_name'];

        //		$fcontent = file_get_contents($filename);
        $imagesize = getimagesize($filename);

        $w       = $imagesize[0] <= 1024 ? $imagesize[0] : 1024;
        $percent = ($w * 100) / $imagesize[0];
        $h       = ($imagesize[1] * $percent) / 100;

        $image = new Imagick($filename);
        $image->resizeImage($w, $h, Imagick::FILTER_LANCZOS, 1);

        $fcontent = $image->getImageBlob();
        $image->destroy();

        $uid = request::get_int('uid');

        $this->connect();

        $sql = 'INSERT INTO user_photos (user_id, photo, del) 
			VALUES (
				'.$uid.",
				'".pg_escape_bytea($fcontent)."'::bytea,
				".('deleted' === request::get_string('type') ? time() : 0).'
			)';

        if (pg_query($sql)) {
            // header('Content-Type: application/json');
            $res = pg_fetch_result(pg_query('SELECT id FROM user_photos ORDER BY id DESC LIMIT 1'), 'id');

            return $res;
        }

        pg_close();

        return false;
    }

    private function connect()
    {
        $db = conf::get('databases');

        $connection = [
            'host='.$db['master']['host'],
            'port=5432',
            'dbname='.$db['master']['dbname'],
            'user='.$db['master']['user'],
            'password='.$db['master']['password'],
        ];

        return pg_connect(implode(chr(32), $connection));
    }
}
