<?php


class User
{

    private $id;
    private $nickname;
    private $firstName;
    private $lastName;
    private $password;

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

    public static function create($postData)
    {
        $nickname = $postData['nickname'];
        $firstName = $postData['first_name'];
        $lastName = $postData['last_name'];
        $password = $postData['password'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return new self(null ,$nickname, $firstName, $lastName, $hashed_password);

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
