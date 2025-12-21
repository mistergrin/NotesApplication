<?php

require_once __DIR__.'/../src/note.php';

/**
 * Class NotesDB
 *
 * Provides file-based storage and management for Note entities.
 * Notes are stored in a JSON file and loaded into Note objects.
 */

class NotesDB{

    /**
     * Path to the JSON file where notes are stored.
     *
     * @var string
     */
    private static $file = __DIR__."/../storage/notes.json";

    /**
     * Retrieve all notes from storage.
     *
     * @return Note[] List of all notes
     */

    public function allNotes(){
        if (!empty(self::$file)){
            $notes = [];
            $data = json_decode(file_get_contents(self::$file), true);
            foreach($data as $note){
                $notes[] = new Note($note['id'], $note['author_id'], $note['text'], $note['image'], $note['date'], $note['updated_at'] ?? null);
            }
            return $notes;
        }
        else{
            return [];
        }
    }

    /**
     * Add a new note to storage.
     *
     * Automatically assigns a unique note ID.
     *
     * @param Note $note Note object to add
     *
     * @return void
     */

    public function addNote(Note $note){
        $notes = self::allNotes();
        if (count($notes) > 0) {
            $all_id = array_map(function ($id) {
                return $id->getNoteId();
            }, $notes);
            $note->setNoteId(max($all_id) + 1);
        } else {
            $note->setNoteId(1);
        }
        $notes[] = $note;
        $data = array_map(function ($note) {
            return $note->createArrayNote();
        }, $notes);
        file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));
    }

    /**
     * Get a note by its ID.
     *
     * @param int $id Note ID
     *
     * @return Note|null Note object if found, null otherwise
     */

    public function getNoteById($id)
    {
        $notes = self::allNotes();
        foreach($notes as $note){
            if ($note->getNoteId() == $id){
                return $note;
            }
        }
        return null;
    }


    /**
     * Get notes by author ID with pagination.
     *
     * Notes are sorted by updated date (or creation date if not updated),
     * newest first.
     *
     * @param int $id    Author ID
     * @param int $page  Page number (starting from 1)
     * @param int $limit Number of notes per page
     *
     * @return array{
     *     notes: Note[],
     *     total: int,
     *     page: int,
     *     pages: int
     * }
     */

    public function getNotesByAuthorId($id, $page, $limit){

        $notes = self::allNotes();
        $found_notes = [];

        $page = intval($page);
        $limit = intval($limit);

        foreach($notes as $note){
            if ($note->getNoteAuthorId() == $id){
                $found_notes[] = $note;

            }
        }
        usort($found_notes, function($a, $b){
            if ($a->getNoteUpdatedDate() !== null) {
                $dateA = $a->getNoteUpdatedDate();
            } else {
                $dateA = $a->getNoteDate();
            }

            if ($b->getNoteUpdatedDate() !== null) {
                $dateB = $b->getNoteUpdatedDate();
            } else {
                $dateB = $b->getNoteDate();
            }

            return strtotime($dateB) - strtotime($dateA);
        });

        $start = ($page - 1) * $limit;
        $paginated_notes = array_slice($found_notes, $start, $limit);
        $total = count($found_notes);

        return  ['notes' => $paginated_notes, 'total' => $total, 'page' => $page, 'pages' => ceil($total / $limit)];
    }



    /**
     * Delete a note by ID.
     *
     * @param int $id Note ID
     *
     * @return void
     */

    public function deleteNote($id){
        $notes = self::allNotes();
        foreach($notes as $index=> $note){
            if ($note->getNoteId() == $id){
                unset($notes[$index]);
                break;
            }
        }
        $data = array_map(function($note) {
            return $note->createArrayNote();
        }, $notes);

        file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));

    }

    /**
     * Delete the image associated with a note.
     *
     * @param int $id Note ID
     *
     * @return null
     */

    public function deleteNoteImage($id){
        $note = self::getNoteById($id);
        $imagePath = $note->getNoteImage();

        if ($imagePath) {
            $image_link = '/home/hryshiva/www/site/storage/uploads/' . basename($imagePath);
            if (file_exists($image_link)) {
                unlink($image_link);
            }
        }
        return null;
    }


    /**
     * Update an existing note.
     *
     * @param Note $updated_note Updated note object
     *
     * @return void
     */

    public function updateNote($updated_note){
        $notes = self::allNotes();
        foreach ($notes as $index=> $note){
            if ($note->getNoteId() == $updated_note->getNoteId()){
                $notes[$index] = $updated_note;
                break;
            }
        }
        $data = array_map(function($note) {
            return $note->createArrayNote();
        }, $notes);
        file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));
    }

    
    /**
     * Delete all notes by a specific author ID.
     *
     * @param int $author_id Author ID
     *
     * @return void
     */

    public function delete_notes_by_author_id($author_id){
        $notes = self::allNotes();
        foreach($notes as $index=> $note){
            if ($note->getNoteAuthorId() == $author_id){
                unset($notes[$index]);
            }
        }
        $data = array_map(function($note) {
            return $note->createArrayNote();    
        }, $notes);
        file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));
    }


    /**
     * Delete all images associated with notes of a specific author.
     *
     * @param int $author_id Author ID
     *
     * @return void
     */


    public function deleteAllImagesByAuthorId($author_id) {
        $notes = self::allNotes();
        foreach ($notes as $note) {
            if ($note->getNoteAuthorId() == $author_id) {
                $imagePath = $note->getNoteImage();
                if ($imagePath) {
                    $image_link = '/home/hryshiva/www/site/storage/uploads/' . basename($imagePath);
                    if (file_exists($image_link)) {
                        unlink($image_link);
                    }
                }
            }
        }
    }

}

