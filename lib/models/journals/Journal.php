<?php

class Journal implements JsonSerializable
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $description;

    /** @var bool */
    private $public;

    /** @var int */
    private $country;

    /** @var int */
    private $region;

    /** @var int */
    private $city;

    /** @var string */
    private $anotherCity;

    /** @var string */
    private $about;

    /** @var string */
    private $contacts;

    /**
     * @return int
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
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * @param bool $public
     *
     * @return $this
     */
    public function setPublic($public)
    {
        $this->public = $public;

        return $this;
    }

    /**
     * @return int
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param int $country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return int
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param int $region
     *
     * @return $this
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return int
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param int $city
     *
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getAnotherCity()
    {
        return $this->anotherCity;
    }

    /**
     * @param string $anotherCity
     *
     * @return $this
     */
    public function setAnotherCity($anotherCity)
    {
        $this->anotherCity = $anotherCity;

        return $this;
    }

    /**
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @param string $about
     *
     * @return $this
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * @return string
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param string $contacts
     *
     * @return $this
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * @inheritDoc
     * @throws ReflectionException
     */
    public function jsonSerialize()
    {
        $class = new ReflectionClass($this);

        $context = [];
        foreach ($class->getProperties() as $property) {
            $property->setAccessible(true);
            $context[$property->getName()] = $property->getValue($this);
            $property->setAccessible(false);
        }

        return $context;
    }
}