<?php
namespace App\Model;

class User {
    /** @var int */
    private $id;
    /** @var string */
    private $username;
    /** @var string */
    private $password;

    public function getID () : ?int
    {
        return $this->id;
    }

    public function setID(string $id)  : self
    {
        $this->id = $id;
        return $this;
    }

    public function getUsername() : ?string
    {
        return $this->username;
    }

    public function setUsername(string $username)  : self
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword()  : ?string
    {
        return $this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;
        return $this;
    }

}
?>