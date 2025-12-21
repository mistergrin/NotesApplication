<?php

require_once __DIR__ . "/../../db/database.php";


/**
 * Validate login form data.
 *
 * Checks that both nickname and password are provided.
 *
 * @param array $data Array containing 'nickname' and 'password'
 *
 * @return array Associative array of errors, empty if validation passes
 *               e.g., ['nickname' => 'Enter a nickname', 'password' => 'Enter a password']
 */
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
