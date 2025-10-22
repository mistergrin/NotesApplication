<?php

class Note{

    public $id;
    public $author;
    public $text;
    public $image;
    public $date;

    public function __construct($id, $author, $text, $image, $date){
        $this->id = $id;
        $this->author = $author;
        $this->text = $text;
        $this->image = $image;
        $this->date = $date;
    }
    public function createArrayNote()
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'text' => $this->text,
            'image' => $this->image,
            'date' => $this->date
        ];
    }
    public function getNoteId(){
        return $this->id;
    }

    public function getNoteAuthor(){
        return $this->author;
    }

    public function getNoteText(){
        return $this->text;
    }

    public function getNoteImage(){
        return $this->image;
    }

    public function getNoteDate(){
        return $this->date;
    }
}
