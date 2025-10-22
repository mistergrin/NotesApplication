<?php

require_once __DIR__ . "/../../db/database.php";

function validation_registration($data)
{
    $errors = [];
    $nickname = trim($data['nickname']);
    $first_name = trim($data['first_name']);
    $last_name = trim($data['last_name']);
    $password = trim($data['password']);

    if (empty($nickname)){
        $errors['nickname'] = "Nickname cannot be empty";
    }
    else{

        $users = UsersDB::allUsers();
        foreach ($users as $user){
            if ($nickname == $user->getNickname()){
                $errors['nickname'] = "This nickname already exists";
                break;
            }
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
