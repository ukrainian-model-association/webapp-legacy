<?php

namespace App\Component\WorkAlbum\Controller;

use App\Component\WorkAlbum\Entity\WorkAlbum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use user_albums_peer;
use user_photos_peer;

class WorkController
{
    /** @var Request */
    private $request;

    /** @var array */
    private $formHandlers;

    public function __construct(Request $request)
    {
        $this->request      = $request;
        $this->formHandlers = [
            WorkAlbum::TYPE_DEFAULT => static function ($data, WorkAlbum $album) {
                $albumId = (int) $data['id'];
                $imageId = $data['image']['id'];

                if ($albumId > 0) {
                    $album->setId($albumId);
                }

                return $album
                    ->setName($data['name'])
                    ->setDescription($data['description'])
                    ->setPid($imageId)
                    ->setImages([$imageId])
                    ->setAdditional($data);
            },
            WorkAlbum::TYPE_COVERS  => function ($data, WorkAlbum $album) {
                $handleRequest = $this->getFormHandler(WorkAlbum::TYPE_DEFAULT);

                return $handleRequest($data, $album);
            },
            WorkAlbum::TYPE_DEFILE  => function ($data, WorkAlbum $album) {
                $handleRequest = $this->getFormHandler(WorkAlbum::TYPE_DEFAULT);

                return $handleRequest($data, $album);
            },
            WorkAlbum::TYPE_ADV     => function ($data, WorkAlbum $album) {
                $handleRequest = $this->getFormHandler(WorkAlbum::TYPE_DEFAULT);

                return $handleRequest($data, $album);
            },
            WorkAlbum::TYPE_CONTEST => function ($data, WorkAlbum $album) {
                $handleRequest = $this->getFormHandler(WorkAlbum::TYPE_DEFAULT);

                return $handleRequest($data, $album);
            },
        ];
    }

    private function getFormHandler($albumType = WorkAlbum::TYPE_DEFAULT)
    {
        if (!array_key_exists($albumType, $this->formHandlers)) {
            $albumType = WorkAlbum::TYPE_DEFAULT;
        }

        return $this->formHandlers[$albumType];
    }

    public function getWorkAlbum($profileId, $albumId)
    {
        $album = WorkAlbum::get($albumId);

        switch ($album->getType()) {
            case WorkAlbum::TYPE_ADV:
                return JsonResponse::create($album);

            default:
                return JsonResponse::create(null);
        }
    }

    /**
     * @param int $profileId
     * @param string $albumType
     *
     * @return mixed
     */
    public function createOrEditAlbum($profileId, $albumType)
    {
        $album = (new WorkAlbum())
            ->setUserId($profileId)
            ->setCategory($albumType);

        $data          = $this->request->get($albumType);
        $handleRequest = $this->getFormHandler($albumType);
        $album         = $handleRequest($data, $album);

        return $this->persist($album);

        // switch ($albumType) {
        //     case WorkAlbum::TYPE_COVERS:
        //         $album
        //             ->setName($fd['journal']['name']);
        //         break;
        //     case WorkAlbum::TYPE_FASHION:
        //         break;
        //     case WorkAlbum::TYPE_DEFILE:
        //         break;
        //     case WorkAlbum::TYPE_ADVERTISEMENT:
        //         break;
        //     case WorkAlbum::TYPE_CONTEST:
        //
        //         break;
        //
        //     case WorkAlbum::TYPE_CATALOGS:
        //         $album->setName($fd['name']);
        //         $period = $fd['period'];
        //
        //         if ($period['month'] > 0 && $period['year'] > 0) {
        //             $album->setName(
        //                 sprintf(
        //                     '%s, %s %s',
        //                     $album->getName(),
        //                     mb_strtolower(date_peer::instance()->get_month($period['month'])),
        //                     $period['year']
        //                 )
        //             );
        //         }
        //
        //         $album->setAdditional(
        //             [
        //                 'name'         => stripslashes($fd['name']),
        //                 'brand'        => stripslashes($fd['brand']),
        //                 'company'      => stripslashes($fd['company']),
        //                 'period_month' => $fd['period']['month'],
        //                 'period_year'  => $fd['period']['year'],
        //                 'visagist'     => stripslashes($fd['makeupArtist']),
        //                 'stylist'      => stripslashes($fd['stylist']),
        //                 'photographer' => stripslashes($fd['photographer']),
        //                 'designer'     => stripslashes($fd['designer']),
        //             ]
        //         );
        //         break;
        //
        //     default:
        //         $album
        //             ->setName($fd['name'])
        //             ->setDescription($fd['description']);
        //
        //         break;
        // }
    }

    private function persist(WorkAlbum $album)
    {
        $data = [
            'user_id'     => $album->getUserId(),
            'name'        => $album->getName(),
            'description' => $album->getDescription(),
            'category'    => $album->getCategory(),
            'additional'  => serialize($album->getAdditional()),
            'images'      => serialize($album->getImages()),
            'pid'         => $album->getPid(),
        ];

        if ($album->getId() > 0) {
            user_albums_peer::instance()->update(array_merge($data, ['id' => $album->getId()]));

            return $album;
        }

        return $album->setId(user_albums_peer::instance()->insert($data));
    }

    public function deleteAlbum($profileId, $albumId)
    {
        $album = user_albums_peer::instance()->get_item($albumId);

        if (!$album) {
            return false;
        }

        $album['images'] = unserialize($album['images']);

        foreach ($album['images'] as $imageId) {
            user_photos_peer::instance()->delete_item($imageId);
        }

        user_albums_peer::instance()->delete_item($albumId);

        return true;
    }
}
