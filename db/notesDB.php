<?php
require_once __DIR__.'/../src/note.php';

class NotesDB{
    private static $file = __DIR__."/storage/notes.json";

    private static function allNotes(){
        if (file_exists(self::$file)){
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
    private static function addNote(Note $note){
        $notes = self::allNotes();
        if (count($notes) > 0) {
            $all_id = array_map(function ($id) {
                return $id->getID();
            }, $notes);
            $note->id = max($all_id) + 1;
        } else {
            $note->id = 1;
        }
        $notes[] = $note;
        $data = array_map(function ($note) {
            return $note->createArray();
        }, $notes);
        file_put_contents(self::$file, json_encode($data));
    }
    private static function getNote($id)
    {
        $notes = self::allNotes();
        foreach($notes as $note){
            if ($note->id == $id){
                return $note;
            }
        }
        return null;
    }
    private static function deleteNote($id){
        $notes = self::allNotes();
        foreach($notes as $note){
            if ($note->id == $id){
                unset($note);
            }
        }
    }
}
