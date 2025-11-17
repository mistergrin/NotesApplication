<?php


session_start();
require_once __DIR__ . '/../src/controllers/noteController.php';

$noteController = new NoteController();
$errors = $noteController->create_note($_POST);

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
}
