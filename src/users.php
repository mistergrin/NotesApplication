<?php
header("Content-Type: application/json");
include("src\user.php");
require_once __DIR__ . "/../db/database.php";

$method = $_SERVER["REQUEST_METHOD"];

switch ($method) {
    case "GET":
        if (isset($_GET['nickname'])){
            $user = UsersDB::getUser($_GET['nickname']);
            if ($user){
                echo json_encode($user);
            }
            else{
                echo json_encode('error');
            }
        }
        break;
    case "POST":
        if (isset($_POST)){
            $data = $_POST;
            $user = new User(null, $data['nickname'], $data['firstname'], $data['lastname'], $data['password']);
            UsersDB::addUser($user);
            echo "saved";
        }
        break;
    case "DELETE":
        if (isset($_GET['nickname'])){

        }



}