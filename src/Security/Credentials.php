<?php


namespace App\Security;

class Credentials
{
    private $username;
    private $password;

    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public static function create($username = null, $password = null)
    {
        return new self($username, $password);
    }

    /**
     * @return string|null
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string|null $username
     *
     * @return Credentials
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     *
     * @return Credentials
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}
