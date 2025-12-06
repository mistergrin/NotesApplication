<?php

session_start();
include_once __DIR__. "/../../src/controllers/userController.php";
include_once __DIR__. "/../../src/controllers/noteController.php";

$action = $_GET['action'];
header( 'Content-type: application/json');
$user_controller = new UserController();
$note_controller = new NoteController();
$response = [];

switch ($action) {
    case 'get_all_users':

        $response['success'] = true;
        $users = $user_controller->get_all_users();
        $response['users'] = array_map(function($user){
            return $user->createArray();
        }, $users);
        break;

    case 'get_notes_by_user':

        $response['success'] = true;
        $notes = $note_controller->get_notes_by_author($_SESSION['nickname']);
        $response['notes'] = array_map(function($note){
            return $note->createArrayNote();
        }, $notes);
        break;
}

echo json_encode($response);