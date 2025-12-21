<?php

/**
 * Simple API router for user and note actions.
 *
 * Supports actions like:
 * - get_all_users
 * - get_notes_by_user
 *
 * Responds with JSON data.
 */


date_default_timezone_set('Europe/Prague');
session_start();
include_once __DIR__. "/../../src/controllers/userController.php";
include_once __DIR__. "/../../src/controllers/noteController.php";

/**
 * @var string $action Action to perform, passed via GET parameter
 */
$action = $_GET['action'];

/**
 * Set response type as JSON
 */
header( 'Content-type: application/json');

/**
 * @var UserController $user_controller
 * @var NoteController $note_controller
 */
$user_controller = new UserController();
$note_controller = new NoteController();
/**
 * @var array $response Array to store API response
 */
$response = [];

switch ($action) {
    case 'get_all_users':

        $page = $_GET['page'];
        // Get paginated users
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
        // Get paginated notes for the logged-in user
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

/**
 * Output JSON response
 */

echo json_encode($response);
