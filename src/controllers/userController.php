<?php

require_once __DIR__. "/../../db/database.php";
require_once __DIR__. "/../validations/login_validation.php";
require_once __DIR__. "/../validations/registr_validation.php";
require_once __DIR__. "/../user.php";

class UserController{

    private UsersDB $usersDB;

    public function __construct(){
        $this->usersDB = new UsersDB();
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
        $user = User::create($postData);
        $this->usersDB->addUser($user);
        header("Location: /index.php");
        exit;
    }

    public function login_user($postData){
        $errors = login_validation($postData);
        $errors_login = [];

        if (empty($errors)){
            $found_user = $this->usersDB->getUserByNickname($postData['nickname']);

            if (!empty($found_user)){
                if (password_verify($postData['password'], $found_user->getPassword())){
                    $_SESSION['user_id'] = $found_user->getID();
                    $_SESSION['nickname'] = $found_user->getNickname();
                    header("Location: /public/index.php");
                    exit;
                }
                else {
                    $errors_login['invalid_password'] = 'Wrong password';
                }
            }
            else {
                $errors_login['invalid_user'] = 'User not found';
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

    public function delete_user($user_id){

        $user_id = intval($user_id);
        $this->usersDB->deleteUser($user_id);
        return null;
    }
}
