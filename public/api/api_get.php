<?php

date_default_timezone_set('Europe/Prague');
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

        $page = $_GET['page'];
        $data = $user_controller->get_all_users($page);

        $response['success'] = true;
        $data = $user_controller->get_all_users($page);
        $response['users'] = array_map(function($user){
            return $user->createArray();
        }, $data['users']);

        $response['total'] = $data['total'];
        $response['page'] = $data['page'];
        $response['pages'] = $data['pages'];
        break;

    case 'get_notes_by_user':

        $page = $_GET['page'];
        $data = $note_controller->get_notes_by_authorId($_SESSION['user_id'], $page);

        $response['success'] = true;
        $response['notes'] = array_map(function($note){
            return $note->createArrayNote();
        }, $data['notes']);


        $response['total'] = $data['total'];
        $response['page'] = $data['page'];
        $response['pages'] = $data['pages'];
        break;
}


echo json_encode($response);
