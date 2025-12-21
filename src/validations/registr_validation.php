<?php

require_once __DIR__ . "/../../db/database.php";


/**
 * Validate registration form data.
 *
 * Checks that nickname, first name, last name, and password are provided,
 * validates the format of names, ensures password length, and checks
 * for unique nickname.
 *
 * @param array $data POST data containing 'nickname', 'first_name', 'last_name', 'password'
 *
 * @return array Associative array of errors.
 *               - Empty array if validation passes (no errors)
 *               - Otherwise, contains keys for invalid fields with error messages
 *               e.g., [
 *                       'nickname' => 'This nickname already exists',
 *                       'first_name' => 'First name can only contain letters and white spaces',
 *                       'password' => 'Password cannot be less than 5 characters'
 *                     ]
 */


function validation_registration($data)
{
    $errors = [];
    $nickname = trim($data['nickname']);
    $first_name = trim($data['first_name']);
    $last_name = trim($data['last_name']);
    $password = trim($data['password']);
    $usersDB = new UsersDB();

    if (empty($nickname)){
        $errors['nickname'] = "Nickname cannot be empty";
    }
    else{

        $user_nickname = $usersDB->getUserByNickname($nickname);
        if ($user_nickname !== null){
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

    if (empty($password)){
        $errors['password'] = "Password cannot be empty";
    }
    else{
        if(strlen($password) < 5){
            $errors['password'] = "Password cannot be less than 5 characters";
        }
    }

    return $errors;
}
