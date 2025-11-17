<?php

require_once __DIR__ .'/../../db/notesDB.php';
require_once __DIR__ .'/../validations/note_validation.php';

class NoteController{

    private NotesDB $notesDB;

    public function __construct(){
        $this->notesDB = new NotesDB();
    }

    public function get_all_notes(){

       return $this->notesDB->allNotes();

    }

    public function get_note_by_id($id){

        $id = intval($id);
        return $this->notesDB->getNoteById($id);

    }

    public function get_notes_by_author($author){

        $author = trim($author);
        return $this->notesDB->getNotesByAuthor($author);

    }

    public function create_note($postData){
        $errors = notes_validation($postData);

        if (empty($errors)){

            $note = Note::create($postData, $_FILES, $_SESSION['nickname']);
            $this->notesDB->addNote($note);
            header("Location: /index.php");
            exit;
        }
        else {
            return $errors;
        }

    }

    public function delete_note($id){

        $id = intval($id);
        $this->notesDB->deleteNote($id);
        return null;

    }
}

