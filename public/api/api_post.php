<?php

session_start();
include_once __DIR__. "/../../src/controllers/userController.php";
include_once __DIR__. "/../../src/controllers/noteController.php";

$action = $_POST['action'];
header('Content-Type: application/json');
$user_controller = new UserController();
$note_controller = new NoteController();
$response = [];


switch ($action){

    case 'register':
        $errors = $user_controller->register_user($_POST);
        if (empty($errors)){
            $response['success'] = true;
            $response['redirect'] = '/index.php';
        }
        else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
        break;

    case 'login':
        $errors = $user_controller->login_user($_POST);
        if (empty($errors)){
            $response['success'] = true;
            $response['redirect'] = '/index.php';
        }
        else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
        break;

    case 'edit':
        $errors = $user_controller->edit_user($_POST);
        if (empty($errors)) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
        break;

    case 'delete_user':
        $errors = $user_controller->delete_user($_POST['id']);
        if (empty($errors)){
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
        break;

    case 'create_note':
        $errors = $note_controller->create_note($_POST, $_FILES);
        if (empty($errors)){
            $response['success'] = true;
            $response['redirect'] = '/index.php';
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
        break;

    case 'upgrade_role':
        $errors = $user_controller->upgrade_user_role($_POST['id']);
        if (empty($errors)){
            $response['success'] = true;
        }
        else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
        break;
}

echo json_encode($response);
