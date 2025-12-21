<?php


/**
 * API router for handling POST requests for user and note operations.
 *
 * Supported actions:
 * - register       : Register a new user
 * - login          : User login
 * - edit           : Edit user information
 * - delete_user    : Delete a user and their notes/images
 * - create_note    : Create a new note
 * - upgrade_role   : Upgrade user role to ADMIN
 * - delete_note    : Delete a note and its image
 * - edit_note      : Update a note and optionally its image
 *
 * Responds with JSON data.
 */


date_default_timezone_set('Europe/Prague');
session_start();
include_once __DIR__. "/../../src/controllers/userController.php";
include_once __DIR__. "/../../src/controllers/noteController.php";

/** @var string $action Action to perform, passed via POST parameter */
$action = $_POST['action'];

/** Set response type as JSON */
header('Content-Type: application/json');

/** @var UserController $user_controller */
$user_controller = new UserController();
/** @var NoteController $note_controller */
$note_controller = new NoteController();
/** @var array $response Array to store API response */
$response = [];


switch ($action){

    case 'register':
        $errors = $user_controller->register_user($_POST);
        if (empty($errors)){
            $response['success'] = true;
            $response['redirect'] = '/~hryshiva/site/index.php';
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
            $response['redirect'] = '/~hryshiva/site/index.php';
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
            $note_controller->delete_all_images_by_note_id($_POST['id']);
            $note_controller->delete_notes_by_author_id($_POST['id']);
        } else {
            $response['success'] = false;
            $response['errors'] = $errors;
        }
        break;

    case 'create_note':
        $errors = $note_controller->create_note($_POST, $_FILES);
        if (empty($errors)){
            $response['success'] = true;
            $response['redirect'] = '/~hryshiva/site/index.php';
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

    case 'delete_note':
        $note_controller->delete_note_image($_POST['id']);
        $note_controller->delete_note($_POST['id']);

        $response['success'] = true;
        break;

    case 'edit_note':
        $result = $note_controller->update_note($_POST, $_FILES);

        if (is_array($result) && isset($result['updated_at'])) {
            $response['success'] = true;
            $response['new_image_path'] = $result['new_image_path'] ?? null;
            $response['updated_at'] = $result['updated_at'];
        }
        else if (is_array($result) && !empty($result)) {
            $response['success'] = false;
            $response['errors'] = $result['errors'];
        }
        else {
            $response['success'] = false;
        }
        break;
}

/** Output JSON response */
echo json_encode($response);
