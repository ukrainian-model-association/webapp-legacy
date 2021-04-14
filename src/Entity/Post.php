<?php


namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Exception;

/**
 * Class Post
 */
class Post
{
    const MAP_OF_FIELDS = [
        'id' => 'setId',
    ];

    const TYPE_NEWS         = 1;
    const TYPE_PUBLICATION  = 2;
    const TYPE_ANNOUNCEMENT = 3;
    const MAP_OF_TYPES      = [
        self::TYPE_NEWS         => 'Новости',
        self::TYPE_PUBLICATION  => 'Публикации',
        self::TYPE_ANNOUNCEMENT => 'Анонсы',
    ];

    const HREF_TEMPLATE = '/news/view?id=%d';

    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $content;

    /** @var string */
    private $announcement;

    /** @var */
    private $models;

    /** @var DateTimeInterface */
    private $createdAt;

    /** @var string */
    private $salt;

    public function getHref()
    {
        return sprintf(self::HREF_TEMPLATE, $this->getId());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnnouncement()
    {
        return $this->announcement;
    }

    /**
     * @param mixed $announcement
     *
     * @return $this
     */
    public function setAnnouncement($announcement)
    {
        $this->announcement = $announcement;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getModels()
    {
        return $this->models;
    }

    /**
     * @param mixed $models
     *
     * @return $this
     */
    public function setModels($models)
    {
        $this->models = $models;

        return $this;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface|string $createdAt
     *
     * @return $this
     * @throws Exception
     */
    public function setCreatedAt($createdAt)
    {
        if (is_string($createdAt)) {
            $createdAt = new DateTime($createdAt);
        }

        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     *
     * @return $this
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }
}
