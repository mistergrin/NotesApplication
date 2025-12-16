<?php

require_once __DIR__.'/../src/note.php';

class NotesDB{
    private static $file = __DIR__."/../storage/notes.json";

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
    public function deleteNoteImage($id){
        $note = self::getNoteById($id);
        $imagePath = $note->getNoteImage();

        if ($imagePath) {
            $image_link = __DIR__ . '/../' . ltrim($note->getNoteImage(), '/');
            if (file_exists($image_link)) {
                unlink($image_link);
            }
        }
        return null;
    }

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
}

