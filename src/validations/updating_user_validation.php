<?php

require_once __DIR__ . "/../../db/database.php";


/**
 * Validate user update form data.
 *
 * Checks that nickname, first name, and last name are provided,
 * validates the format of names, and ensures that the new nickname
 * is unique (excluding the current user).
 *
 * @param array $postData POST data containing 'nickname', 'first_name', 'last_name'
 *
 * @return array Associative array of errors.
 *               - Empty array if validation passes (no errors)
 *               - Otherwise, contains keys for invalid fields with error messages
 *               e.g., [
 *                       'nickname' => 'This nickname already exists',
 *                       'first_name' => 'First name can only contain letters and white spaces'
 *                     ]
 */



function update_user_validate($postData){
    $errors = [];
    $nickname = trim($postData['nickname']);
    $first_name = trim($postData['first_name']);
    $last_name = trim($postData['last_name']);
    $usersDB = new UsersDB();

    if (empty($nickname)){
        $errors['nickname'] = "Nickname cannot be empty";
    }
    else{

        $user = $usersDB->getUserByNickname($nickname);
        if ($user != null and $user->getID() != $_SESSION['user_id']){
            $errors['nickname'] = "This nickname already exists";
        }
    }

    if (empty($first_name)){
        $errors['first_name'] = "First name cannot be empty";
    }
    else{
        if (!preg_match("/^[a-zA-Z ]*$/",$first_name)){
            $errors['first_name'] = "First name can only contain letters and white spaces";
        }
    }

    if (empty($last_name)){
        $errors['last_name'] = "Last name cannot be empty";
    }
    else{
        if (!preg_match("/^[a-zA-Z ]*$/",$last_name)){
            $errors['last_name'] = "Last name can only contain letters and white spaces";
        }
    }

    return $errors;
}
