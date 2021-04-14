<?php


namespace App\Component\WorkAlbum;


use App\Component\WorkAlbum\Entity\WorkAlbum;

class WorkAlbumManager
{
    private $transformers;

    public function __construct()
    {
        $this->transformers = [];
    }

    public function getAlbum($albumId)
    {
        $data = user_albums_peer::instance()->get_item($albumId);

        return (new WorkAlbum())
            ->setId($data['id'])
            ->setPid($data['pid'])
            ->setUserId($data['user_id'])
            ->setType($data['category'])
            ->setName($data['name'])
            ->setDescription($data['description'])
            ->setAdditional($data['_a'])
            ->setImages($data['_i']);
    }
}
