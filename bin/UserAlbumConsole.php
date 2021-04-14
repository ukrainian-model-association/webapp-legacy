#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Common\Utils\StringUtils;
use PhpCollection\Sequence;

$db = new PDO('pgsql:host=modelsua-db;port=5432;dbname=modelsua;user=modelsua;password=123');

class UserAlbumConsole
{
    /** @var PDO */
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function __invoke()
    {
        $albums = $this
            ->getAlbumIds()
            ->map(
                function ($album) {
                    var_dump($album);
                    $imageIds = [];
                    foreach ($album['images'] as $imageId) {
                        if ((int) $imageId > 0) {
                            $imageIds[] = $this->addImage($imageId, $album['user_id'], $album['id']);
                        }
                    }

                    $album['images'] = $imageIds;

                    return $album;
                }
            );

    }

    private function getAlbumIds()
    {
        $collection = new Sequence();
        $sql        = 'select id from user_albums where images != :images';
        $query      = $this->db->prepare($sql);
        $query->bindValue('images', 'a:0:{}');
        $query->execute();

        while ($albumId = $query->fetchColumn()) {
            $collection->add($this->getAlbum($albumId));
        }

        return $collection;
    }

    private function addImage($imageId, $userId, $albumId = null)
    {
        $sql   = 'insert into user_album_image (user_id, album_id, image_id) values (:userId, :albumId, :imageId)';
        $query = $this->db->prepare($sql);
        $query->bindParam('imageId', $imageId);
        $query->bindParam('albumId', $albumId);
        $query->bindParam('userId', $userId);

        if (!$query->execute()) {
            echo $query->errorCode() . StringUtils::EOL;
            var_dump($query->errorInfo());
            die;
            // throw new PDOException($query->errorInfo(), $query->errorCode());
        }

        return (int) $this->db->lastInsertId('user_album_image_id_seq');
    }

    private function getAlbum($albumId)
    {
        $sql   = 'select * from user_albums where id = :albumId';
        $query = $this->db->prepare($sql);
        $query->bindParam('albumId', $albumId);
        $query->execute();

        $album               = $query->fetch(PDO::FETCH_ASSOC);
        $album['additional'] = unserialize($album['additional']);
        $album['images']     = unserialize($album['images']);
        if (!is_array($album['images'])) {
            $album['images'] = [];
        }

        return $album;
    }

    private function getImagesByAlbum($album)
    {
        $sql   = 'select uai.* from user_album_image uai where uai.album_id = :album_id';
        $query = $this->db->prepare($sql);
        $query->execute(['album_id' => $album['id']]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}


$console = new UserAlbumConsole($db);
$console();
