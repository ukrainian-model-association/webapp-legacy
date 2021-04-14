<?php


namespace App\Security;

class User
{
    const FIELDS = [
        'id',
        'username',
        'password',
        'activated' => 'active',
        'credentials',
    ];

    private $id;
    private $username;
    private $password;
    private $activated;
    private $credentials;

    public function __construct($data = [])
    {
        foreach (self::FIELDS as $property => $value) {
            if (is_int($property) && $property > 0) {
                $property = $value;
            }

            if (isset($data[$value])) {
                $this->{$property} = $data[$value];
            }
        }
    }

    public static function create($user = [])
    {
        return new self($user);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function isActivated()
    {
        return $this->activated;
    }

    /**
     * @param mixed $activated
     *
     * @return User
     */
    public function setActivated($activated)
    {
        $this->activated = $activated;

        return $this;
    }

    /**
     * @return array
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * @param array $credentials
     *
     * @return User
     */
    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;

        return $this;
}
}
