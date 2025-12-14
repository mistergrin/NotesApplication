<?php

class Note{

    private $id;
    private $author;
    private $text;
    private $image;
    private $date;
    private $updated_at_date;

    public function __construct($id, $author, $text, $image, $date, $updated_at_date = null){
        $this->id = $id;
        $this->author = $author;
        $this->text = $text;
        $this->image = $image;
        $this->date = $date;
        $this->updated_at_date = $updated_at_date;
    }
    public function createArrayNote()
    {
        return [
            'id' => $this->id,
            'author' => $this->author,
            'text' => $this->text,
            'image' => $this->image,
            'date' => $this->date,
            'updated_at' => $this->updated_at_date
        ];
    }

    public static function create($postData, $fileData, $author){
        $imageLink = null;
        $text = trim($postData['text']);

        if (!empty($fileData['image']['tmp_name'])) {
            $uploadDir = __DIR__ . "/../storage/uploads/";
            $ext = strtolower(pathinfo($fileData['image']['name'], PATHINFO_EXTENSION));
            $fileName = uniqid("image_") . "." . $ext;
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($fileData['image']['tmp_name'], $filePath)) {
                $imageLink = "/storage/uploads/" . $fileName;
            }
        }

        $date = date("d-m-Y H:i:s ");

        return new self(null, $author, $text, $imageLink, $date);
    }


    public function getNoteId(){
        return $this->id;
    }

    public function setNoteId($id){
        $this->id = $id;
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

    public function getNoteUpdatedDate(){
        return $this->updated_at_date;
    }

    public function setNoteText($text){
        return $this->text = $text;
    }

    public function setNoteImage($image){
        return $this->image = $image;
    }

    public function setNoteDate($date){
        return $this->date = $date;
    }

    public function setNoteUpdatedDate($updated_at_date){
        return $this->updated_at_date = $updated_at_date;
    }

}
