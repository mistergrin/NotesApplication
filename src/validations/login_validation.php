<?php

require_once __DIR__ . "/../../db/database.php";

function login_validation($data) {
    $errors = [];
    $nickname = trim($data["nickname"]);
    $password = $data["password"];

    if (empty($nickname)) {
        $errors['nickname'] = "Enter a nickname";
    }
    if (empty($password)) {
        $errors['password'] = "Enter a password";
    }

    return $errors;
}
