<?php


class User
{

    public $id;
    public $nickname;
    public $firstName;
    public $lastName;
    public $password;

    public function __construct($id, $nickname, $firstName, $lastName, $password)
    {
        $this->id = $id;
        $this->nickname = $nickname;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
    }

    public function createArray(){
        return [
            'id' => $this->id,
            'nickname' => $this->nickname,
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'password' => $this->password];
    }
    public function getID()
    {
        return $this->id;
    }
    public function getNickname()
    {
        return $this->nickname;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastname()
    {
        return $this->lastName;
    }

    public function getPassword(){
        return $this->password;
    }

}
