<?php

require_once __DIR__ . "/../../db/database.php";

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
