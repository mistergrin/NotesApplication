<?php

require_once __DIR__. "/../../db/database.php";
require_once __DIR__. "/../validations/login_validation.php";
require_once __DIR__. "/../validations/registr_validation.php";
require_once __DIR__. "/../user.php";
require_once __DIR__. "/../validations/updating_user_validation.php";



/**
 * Class UserController
 *
 * Handles user-related operations such as registration, login, logout,
 * profile editing, deletion, and role management. Acts as a controller
 * between requests and the UsersDB storage layer.
 */


class UserController{


    /**
     * @var UsersDB Instance of UsersDB for database operations
     */
    private UsersDB $usersDB;

    /**
     * @var User User model instance
     */
    private User $user;

    /**
     * UserController constructor.
     *
     * Initializes the UsersDB and User instances.
     */

    public function __construct(){
        $this->usersDB = new UsersDB();
        $this->user = new User(null, null, null, null, null, null);
    }

    
    /**
     * Get a user by ID.
     *
     * @param int|string $user_id User ID
     *
     * @return User|null User object if found, null otherwise
     */


    public function get_user_by_id($user_id){

        $user_id = intval($user_id);
        return $this->usersDB->getUserByID($user_id);

    }

    /**
     * Get a user by nickname.
     *
     * @param string $nickname User nickname
     *
     * @return User|null User object if found, null otherwise
     */

    public function get_user_by_nickname($nickname){

        $nickname = trim($nickname);
        return $this->usersDB->getUserByNickname($nickname);

    }

    /**
     * Get all users with pagination.
     *
     * @param int $page Page number (default 1)
     * @param int $limit Number of users per page (default 5)
     *
     * @return array Paginated list of users
     */

    public function get_all_users($page = 1, $limit = 5){

        return $this->usersDB->get_all_users_paginated($page, $limit);

    }

    /**
     * Register a new user.
     *
     * @param array $postData POST data from registration form
     *
     * @return array Empty array if successful, or array of validation errors
     */

    public function register_user($postData){

        $errors = validation_registration($postData);
        if (!empty($errors)) {
            return $errors;
        }

        $this->usersDB->addUser($this->user->create($postData));
        return [];
    }

    /**
     * Login a user.
     *
     * @param array $postData POST data from login form
     *
     * @return array Array of validation errors or empty array if login is successful
     */


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
                    $_SESSION['role'] = $found_user->getRole();
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


    /**
     * Logout the current user.
     *
     * Destroys session and clears cookies.
     *
     * @return void
     */

    
    public function logout_user(){

        $_SESSION = [];
        setcookie('PHPSESSID', '', time() - 1, '/', '', true, true);

        session_destroy();
        header("Location: /~hryshiva/site/views/loginview.php");
        exit;

    }

    /**
     * Edit the currently logged-in user's profile.
     *
     * @param array $postData POST data from profile form
     *
     * @return array Empty array if successful, or array of validation errors
     */


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

    /**
     * Delete a user by ID.
     *
     * @param int|string $user_id User ID
     *
     * @return array Empty array if successful, or array with error messages
     */


    public function delete_user($user_id){
        $user_id = intval($user_id);
        $user = $this->usersDB->getUserByID($user_id);
        $errors = [];

        if ($user->getRole() == "ADMIN"){
            $errors[] = "You can't delete an admin user";
            return $errors;
        }

        $this->usersDB->deleteUser($user_id);
        return [];
    }


    /**
     * Upgrade a user's role to ADMIN.
     *
     * @param int|string $user_id User ID
     *
     * @return array Empty array if successful, or array with error messages
     */

    public function upgrade_user_role($user_id){
        $user_id = intval($user_id);
        $user = $this->usersDB->getUserByID($user_id);
        $errors = [];

        if ($user->GetRole() == "ADMIN"){
            $errors[] = "You can't upgrade an admin user";
            return $errors;
        }

        $this->usersDB->upgradeUserRole($user_id);
        return [];
    }
}
