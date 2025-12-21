<?php


/**
 * Class User
 *
 * Represents a user entity with properties like nickname, password, and role.
 */


class User
{
    /**
     * @var int|null User ID
     */
    private $id;
    
    /**
     * @var string User nickname
     */
    private $nickname;
    /**
     * @var string User first name
     */
    private $firstName;
    /**
     * @var string User last name
     */
    private $lastName;
    /**
     * @var string Hashed password
     */
    private $password;
    /**
     * @var string User role (e.g., "USER" or "ADMIN")
     */
    private $role;

    /**
     * User constructor.
     *
     * @param int|null $id
     * @param string $nickname
     * @param string $firstName
     * @param string $lastName
     * @param string $password Hashed password
     * @param string $role
     */
    public function __construct($id, $nickname, $firstName, $lastName, $password, $role)
    {
        $this->id = $id;
        $this->nickname = $nickname;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * Convert the User object to an associative array for storage.
     *
     * @return array
     */

    public function createArray(){
        return [
            'id' => $this->id,
            'nickname' => $this->nickname,
            'firstname' => $this->firstName,
            'lastname' => $this->lastName,
            'password' => $this->password,
            'role' => $this->role];
    }
    /**
     * Factory method to create a new User from POST data.
     *
     * @param array $postData POST data with keys 'nickname', 'first_name', 'last_name', 'password'
     *
     * @return User
     */
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
    /**
     * Get the user ID.
     *
     * @return int|null
     */
    public function getID()
    {
        return $this->id;
    }
    /**
     * Get the nickname.
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }
    /**
     * Get the first name.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    /**
     * Get the last name.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastName;
    }
    /**
     * Get the hashed password.
     *
     * @return string
     */
    public function getPassword(){
        return $this->password;
    }
    /**
     * Get the user role.
     *
     * @return string
     */
    public function getRole(){
        return $this->role;
    }
    /**
     * Set the user ID.
     *
     * @param int $id
     */
    public function setUserId($id){
        $this->id = $id;
    }
    
    /**
     * Set the nickname.
     *
     * @param string $nickname
     */
    public function setNickName($nickname){
        $this->nickname = $nickname;
    }
    /**
     * Set the first name.
     *
     * @param string $firstName
     */
    public function setFirstName($firstName){
        $this->firstName = $firstName;
    }
    /**
     * Set the last name.
     *
     * @param string $lastName
     */
    public function setLastName($lastName){
        $this->lastName = $lastName;
    }
    /**
     * Set the user role.
     *
     * @param string $role
     */
    public function setRole($role){
        $this->role = $role;
    }
}
