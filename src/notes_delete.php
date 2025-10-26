<?php

include_once __DIR__. '/../db/notesDB.php';
include_once __DIR__.'/note.php';

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == "POST" && isset($_POST['note_id'])) {
    $note_id = intval($_POST['note_id']);
    $note = NotesDB::getNote($note_id);
    $image_path = __DIR__ . '/../' . ltrim($note->getNoteImage(), '/');
    if (file_exists($image_path)) {
        unlink($image_path);
    }
    NotesDB::deleteNote($note_id);

}