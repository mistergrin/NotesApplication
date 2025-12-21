<?php

require_once __DIR__ .'/../../db/notesDB.php';
require_once __DIR__ .'/../validations/note_validation.php';
require_once __DIR__ .'/../note.php';


/**
 * Class NoteController
 *
 * Handles note-related operations such as creating, updating,
 * deleting notes and their images. Acts as a controller between
 * requests and the NotesDB storage layer.
 */


class NoteController{

    /**
     * @var NotesDB Instance of NotesDB for database operations
     */

    private NotesDB $notesDB;

    /**
     * @var Note Note model instance
     */

    private Note $note;


    /**
     * NoteController constructor.
     *
     * Initializes the NotesDB and Note instances.
     */

    public function __construct(){
        $this->notesDB = new NotesDB();
        $this->note = new Note(null, null, null, null, null);
    }


    /**
     * Retrieve all notes.
     *
     * @return Note[] Array of all Note objects
     */

    public function get_all_notes(){

       return $this->notesDB->allNotes();

    }


    /**
     * Get a note by its ID.
     *
     * @param int|string $id Note ID
     *
     * @return Note|null Note object if found, null otherwise
     */

    public function get_note_by_id($id){

        $id = intval($id);
        return $this->notesDB->getNoteById($id);

    }

    /**
     * Get notes by author ID with pagination.
     *
     * @param int|string $id Author ID
     * @param int $page Page number (default 1)
     * @param int $limit Number of notes per page (default 6)
     *
     * @return array{
     *     notes: Note[],
     *     total: int,
     *     page: int,
     *     pages: int
     * }
     */


    public function get_notes_by_authorId($id, $page = 1, $limit = 6){

        $id = intval($id);
        return $this->notesDB->getNotesByAuthorId($id, $page, $limit);

    }


    /**
     * Create a new note.
     *
     * @param array $postData POST data from the request
     * @param array $fileData Uploaded file data
     *
     * @return array Empty array if successful, or array of validation errors
     */


    public function create_note($postData, $fileData){
        $errors = notes_validation($postData, $fileData);
        $author = $_SESSION['user_id'];

        if (!empty($errors)) {
            return $errors;
        }

        $this->notesDB->addNote($this->note->create($postData, $fileData, $author));
        return [];
    }


    /**
     * Delete a note by ID.
     *
     * @param int|string $id Note ID
     *
     * @return array Empty array
     */


    public function delete_note($id){

        $id = intval($id);
        $this->notesDB->deleteNote($id);
        return [];

    }

    
    /**
     * Delete the image of a specific note by ID.
     *
     * @param int|string $id Note ID
     *
     * @return array Empty array
     */


    public function delete_note_image($id){

        $id = intval($id);
        $this->notesDB->deleteNoteImage($id);
        return [];

    }

    /**
     * Update an existing note.
     *
     * Updates text and optionally replaces the note image.
     *
     * @param array $postData POST data containing note info
     * @param array $file Uploaded file data
     *
     * @return array Array containing either updated_at/new_image_path,
     *               errors, or no_changes flag
     */

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
                    $note->setNoteImage('/~hryshiva/site/storage/uploads/' . $newFileName);
                    $newImageLink = '/~hryshiva/site/storage/uploads/' . $newFileName;
                    $noteChanged = true;
                }
            }

            if ($noteChanged) {
                $updated_at = date('d-m-Y H:i:s');
                $note->setNoteUpdatedDate($updated_at);
                $this->notesDB->updateNote($note);

                return ['updated_at' => $updated_at, 'new_image_path' => $newImageLink];
            }}
        else{
            return ['errors' => $errors];
        }
        return ['no_changes' => true];
    }

    /**
     * Delete all notes by a specific author ID.
     *
     * @param int|string $id Author ID
     *
     * @return array Empty array
     */


    public function delete_notes_by_author_id($id){
        $id = intval($id);
        $this->notesDB->delete_notes_by_author_id($id);

        return [];
    }

    /**
     * Delete all images associated with notes of a specific author.
     *
     * @param int|string $id Author ID
     *
     * @return array Empty array
     */


    public function delete_all_images_by_note_id($id){
        $id = intval($id);
        $this->notesDB->deleteAllImagesByAuthorId($id);

        return [];
    }

}

