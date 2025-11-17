<?php
require_once __DIR__.'/../src/note.php';

class NotesDB{
    private static $file = __DIR__."/../storage/notes.json";

    public static function allNotes(){
        if (!empty(self::$file)){
            $notes = [];
            $data = json_decode(file_get_contents(self::$file), true);
            foreach($data as $note){
                $notes[] = new Note($note['id'], $note['author'], $note['text'], $note['image'], $note['date']);
            }
            return $notes;
        }
        else{
            return [];
        }
    }
    public static function addNote(Note $note){
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
    public static function getNoteById($id)
    {
        $notes = self::allNotes();
        foreach($notes as $note){
            if ($note->getNoteId() == $id){
                return $note;
            }
        }
        return null;
    }

    public static function getNotesByAuthor($author){

        $notes = self::allNotes();
        $found_notes = [];

        foreach($notes as $note){
            if ($note->getNoteAuthor() == $author){
                $found_notes[] = $note;

            }
        }
        return $found_notes;
    }


    public static function deleteNote($id){
        $notes = self::allNotes();
        foreach($notes as $note){
            if ($note->getNoteId() == $id){
                unset($note);
            }
        }
        return null;
    }
    public static function delete_note_image($id){
        $note = self::getNoteById($id);
        $image_link =  __DIR__ . '/../' . ltrim($note->getNoteImage(), '/');
        if (file_exists($image_link)){
            unlink($image_link);
        }
        return null;
    }
}

