<?php

require_once __DIR__. "/../../db/database.php";
require_once __DIR__. "/../validations/login_validation.php";
require_once __DIR__. "/../validations/registr_validation.php";
require_once __DIR__. "/../user.php";
require_once __DIR__. "/../validations/updating_user_validation.php";

class UserController{

    private UsersDB $usersDB;
    private User $user;

    public function __construct(){
        $this->usersDB = new UsersDB();
        $this->user = new User(null, null, null, null, null);
    }

    public function get_user_by_id($user_id){

        $user_id = intval($user_id);
        return $this->usersDB->getUserByID($user_id);

    }

    public function get_user_by_nickname($nickname){

        $nickname = trim($nickname);
        return $this->usersDB->getUserByNickname($nickname);

    }

    public function get_all_users(){

        return $this->usersDB->allUsers();

    }

    public function register_user($postData){

        $errors = validation_registration($postData);
        if (!empty($errors)) {
            return $errors;
        }

        $this->usersDB->addUser($this->user->create($postData));
        return [];
    }

    public function login_user($postData){
        $errors = login_validation($postData);
        $errors_login = [];

        if (empty($errors)){
            $found_user = $this->usersDB->getUserByNickname(trim($postData['nickname']));

            if (!empty($found_user)){
                if (password_verify($postData['password'], $found_user->getPassword())){
                    $_SESSION['user_id'] = $found_user->getID();
                    $_SESSION['nickname'] = $found_user->getNickname();
                    $_SESSION['first_name'] = $found_user->getFirstname();
                    $_SESSION['last_name'] = $found_user->getLastname();
                }
                else {
                    $errors_login['password'] = 'Wrong password';
                }
            }
            else {
                $errors_login['nickname'] = 'User not found';
            }
            $errors = array_merge($errors, $errors_login);
        }
        return $errors;
    }

    public function logout_user(){

        unset($_SESSION['user_id']);
        unset($_SESSION['nickname']);
        session_destroy();
        header("Location: /views/loginview.php");
        exit;

    }

    public function edit_user($postData){
        $user = $this->usersDB->getUserByID($_SESSION['user_id']);
        $errors = update_user_validate($postData);
        if (empty($errors)){

            $user->setNickName(trim($postData['nickname']));
            $user->setFirstName(trim($postData['first_name']));
            $user->setLastName(trim($postData['last_name']));

            $this->usersDB->updateUser($user);

            $_SESSION['nickname'] = $user->getNickname();
            $_SESSION['first_name'] = $user->getFirstname();
            $_SESSION['last_name'] = $user->getLastname();

        }
        else {
            return $errors;
        }

        return [];

    }
    public function delete_user($user_id){

        $user_id = intval($user_id);
        $this->usersDB->deleteUser($user_id);
        return null;
    }
}
