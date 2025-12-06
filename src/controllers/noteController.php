<?php

require_once __DIR__ .'/../../db/notesDB.php';
require_once __DIR__ .'/../validations/note_validation.php';
require_once __DIR__ .'/../note.php';

class NoteController{

    private NotesDB $notesDB;
    private Note $note;

    public function __construct(){
        $this->notesDB = new NotesDB();
        $this->note = new Note(null, null, null, null, null);
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

    public function create_note($postData, $fileData){
        $errors = notes_validation($postData, $fileData);
        $author = $_SESSION['nickname'];

        if (!empty($errors)) {
            return $errors;
        }

        $this->notesDB->addNote($this->note->create($postData, $fileData, $author));
        return [];
    }

    public function delete_note($id){

        $id = intval($id);
        $this->notesDB->deleteNote($id);
        return null;

    }

    public function update_note($postData){
        $note = $this->notesDB->getNoteById($postData['id']);
        $errors = notes_validation($postData);

        if (empty($errors)){

            $note->setNoteText($postData['note_text']);
            $note->setNoteImage($postData['note_image']);
            $note->setNoteDate(date('Y-m-d H:i'));

            $this->notesDB->updateNote($note);

            return [];
        }
        else{
            return $errors;
        }
    }

}

