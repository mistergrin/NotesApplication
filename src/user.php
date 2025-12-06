<?php


class User
{

    private $id;
    private $nickname;
    private $firstName;
    private $lastName;
    private $password;
    private $role;

    public function __construct($id, $nickname, $firstName, $lastName, $password, $role)
    {
        $this->id = $id;
        $this->nickname = $nickname;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->role = $role;
    }

    public function createArray(){
        return [
            'id' => $this->id,
            'nickname' => $this->nickname,
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'password' => $this->password,
            'role' => $this->role];
    }

    public function create($postData)
    {
        $nickname = trim($postData['nickname']);
        $firstName = trim($postData['first_name']);
        $lastName = trim($postData['last_name']);
        $password = $postData['password'];
        $role = "USER";

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return new self(null ,$nickname, $firstName, $lastName, $hashed_password, $role);

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

    public function getRole(){
        return $this->role;
    }

    public function setUserId($id){
        $this->id = $id;
    }
    public function setNickName($nickname){
        $this->nickname = $nickname;
    }

    public function setFirstName($firstName){
        $this->firstName = $firstName;
    }
    public function setLastName($lastName){
        $this->lastName = $lastName;
    }
    public function setRole($role){
        $this->role = $role;
    }
}
