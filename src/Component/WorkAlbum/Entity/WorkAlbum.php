<?php

namespace App\Component\WorkAlbum\Entity;

use DateTime;
use JsonSerializable;
use Serializable;
use user_albums_peer;

/**
 * Class WorkAlbum.
 */
class WorkAlbum implements JsonSerializable, Serializable
{
    const IMAGE_URL_TEMPLATE = '/imgserve?pid=%d';

    const TYPE_DEFAULT       = 'default';
    const TYPE_COVERS        = 'covers';
    const TYPE_FASHION       = 'fashion';
    const TYPE_DEFILE        = 'defile';
    const TYPE_ADV           = 'adv';
    const TYPE_ADVERTISEMENT = 'advertisement';
    const TYPE_CONTEST       = 'contest';
    const TYPE_CATALOGS      = 'catalogs';
    const TYPE_PORTFOLIO     = 'portfolio';

    const TYPES = [
        self::TYPE_COVERS        => 'Обложки',
        self::TYPE_FASHION       => 'Fashion stories',
        self::TYPE_DEFILE        => 'Показы',
        self::TYPE_ADV           => 'Реклама',
        self::TYPE_ADVERTISEMENT => 'Печатная реклама',
        self::TYPE_CONTEST       => 'Конкурсы',
        self::TYPE_CATALOGS      => 'Календари, каталоги',
        self::TYPE_PORTFOLIO     => 'Портфолио',
    ];

    const EXCLUDED_TYPES = [
        self::TYPE_ADVERTISEMENT,
        self::TYPE_PORTFOLIO,
    ];

    /** @var int */
    private $id;

    /** @var int */
    private $pid;

    /** @var int */
    private $userId;

    /** @var string */
    private $type = self::TYPE_DEFAULT;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var string */
    private $category;

    /** @var string|array */
    private $additional;

    /** @var array */
    private $images;

    /** @var DateTime */
    private $createdAt;

    /** @var DateTime */
    private $updatedAt;

    public function __construct()
    {
        $this->additional = [];
        $this->images     = [];
        $this->createdAt  = new DateTime();
        $this->updatedAt  = clone $this->createdAt;
    }

    public static function get($id)
    {

    }

    public static function getTypes()
    {
        return array_filter(
            self::TYPES,
            static function ($type) {
                return !in_array($type, self::EXCLUDED_TYPES);
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public static function getTypeValue($type)
    {
        if (!array_key_exists($type, self::TYPES)) {
            return null;
        }

        return self::TYPES[$type];
    }

    public function jsonSerialize()
    {
        return [
            '@id'         => $this->getId(),
            'user'        => [
                '@id' => $this->getUserId(),
            ],
            '@type'       => $this->getType(),
            'type'        => t(self::TYPES[$this->getType()]),
            'image'       => $this->getImage(),
            'images'      => $this->getImages(),
            'name'        => $this->getName(),
            'description' => $this->getDescription(),
            'additional'  => $this->getAdditional(),
            'createdAt'   => $this->getCreatedAt()->format('d.m.Y H:i:s'),
            'updatedAt'   => $this->getUpdatedAt()->format('d.m.Y H:i:s'),
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return WorkAlbum
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getImage()
    {
        return [
            '@id' => $this->getPid(),
            'url' => sprintf(self::IMAGE_URL_TEMPLATE, $this->getPid()),
        ];
    }

    /**
     * @return array
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param array $images
     * @return WorkAlbum
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getAdditional()
    {
        return $this->additional;
    }

    public function setAdditional($additional)
    {
        $this->additional = $additional;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     * @return WorkAlbum
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return WorkAlbum
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getPid()
    {
        return (int) $this->pid;
    }

    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    public function serialize()
    {
        return json_encode($this);
    }

    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }

    private function prepareImage($imageId)
    {
        return [
            '@id' => $imageId,
            'url' => sprintf(self::IMAGE_URL_TEMPLATE, $imageId),
        ];
    }
}
