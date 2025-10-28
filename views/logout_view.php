<?php
session_start();

require_once __DIR__ . "/../src/controllers/userController.php";

$user_controller = new UserController();

$user_controller->logout_user();



