<?php

include_once __DIR__. '/../db/database.php';
include_once __DIR__.'/user.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == "POST" && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']);
    UsersDB::getUserByID($user_id);
    UsersDB::deleteUser($user_id);
}
