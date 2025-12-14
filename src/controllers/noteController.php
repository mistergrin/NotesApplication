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

    public function get_notes_by_author($author, $page = 1, $limit = 6){

        $author = trim($author);
        return $this->notesDB->getNotesByAuthor($author, $page, $limit);

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
        return [];

    }

    public function delete_note_image($id){

        $id = intval($id);
        $this->notesDB->deleteNoteImage($id);
        return [];

    }

    public function update_note($postData, $file){
        $note = $this->notesDB->getNoteById($postData['id']);
        $errors = notes_validation($postData, $file);
        $newImageLink = null;
        $noteChanged = false;

        if (empty($errors)){


            if ($note->getNoteText() !== $postData['text']) {
                $note->setNoteText($postData['text']);
                $noteChanged = true;
            }


            if (!empty($file['image']['name'])) {
                $ext = pathinfo($file['image']['name'], PATHINFO_EXTENSION);
                $newFileName = uniqid('image_') . '.' . $ext;
                $uploadDir = __DIR__ . '/../../storage/uploads/';
                $uploadPath = $uploadDir . $newFileName;

                $this->notesDB->deleteNoteImage($note->getNoteId());
                if (move_uploaded_file($file['image']['tmp_name'], $uploadPath)) {
                    $note->setNoteImage('/storage/uploads/' . $newFileName);
                    $newImageLink = '/storage/uploads/' . $newFileName;
                    $noteChanged = true;
                }
            }

            if ($noteChanged) {
                $updated_at = date('Y-m-d H:i:s');
                $note->setNoteUpdatedDate($updated_at);
                $this->notesDB->updateNote($note);

                return ['updated_at' => $updated_at, 'new_image_path' => $newImageLink];
            }}
        else{
            return ['errors' => $errors];
        }
        return ['no_changes' => true];
    }

}

