<?php

/**
 * Class Note
 *
 * Represents a single note entity with optional image, creation date, and update date.
 */

class Note{

    /**
     * @var int|null Note ID
     */
    private $id;

    /**
     * @var int Author ID
     */
    private $author_id;
    /**
     * @var string Note text content
     */

    private $text;
    /**
     * @var string|null Path to the note image
     */
    private $image;

    /**
     * @var string Creation date in format "d-m-Y H:i:s"
     */
    private $date;
    /**
     * @var string|null Date of last update in format "d-m-Y H:i:s"
     */
    private $updated_at_date;

    /**
     * Note constructor.
     *
     * @param int|null $id Note ID
     * @param int $author_id Author ID
     * @param string $text Note text
     * @param string|null $image Path to image
     * @param string $date Creation date
     * @param string|null $updated_at_date Update date
     */

    public function __construct($id, $author_id, $text, $image, $date, $updated_at_date = null){
        $this->id = $id;
        $this->author_id = $author_id;
        $this->text = $text;
        $this->image = $image;
        $this->date = $date;
        $this->updated_at_date = $updated_at_date;
    }


    /**
     * Convert note to an associative array suitable for JSON storage.
     *
     * @return array
     */
    public function createArrayNote()
    {
        return [
            'id' => $this->id,
            'author_id' => $this->author_id,
            'text' => $this->text,
            'image' => $this->image,
            'date' => $this->date,
            'updated_at' => $this->updated_at_date
        ];
    }

    /**
     * Factory method to create a Note from post data and uploaded file.
     *
     * @param array $postData POST data (must contain 'text')
     * @param array $fileData Uploaded file data
     * @param int $author Author ID
     *
     * @return Note
     */

    public static function create($postData, $fileData, $author){
        $imageLink = null;
        $text = trim($postData['text']);

        if (!empty($fileData['image']['tmp_name'])) {
            $uploadDir = __DIR__ . "/../storage/uploads/";
            $ext = strtolower(pathinfo($fileData['image']['name'], PATHINFO_EXTENSION));
            $fileName = uniqid("image_") . "." . $ext;
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($fileData['image']['tmp_name'], $filePath)) {
                $imageLink = "/~hryshiva/site/storage/uploads/" . $fileName;
            }
        }

        $date = date("d-m-Y H:i:s ");

        return new self(null, $author, $text, $imageLink, $date);
    }

    /**
     * Get note ID.
     *
     * @return int|null
     */
    public function getNoteId(){
        return $this->id;
    }
    
    /**
     * Set note ID.
     *
     * @param int $id
     */
    public function setNoteId($id){
        $this->id = $id;
    }
    /**
     * Get author ID.
     *
     * @return int
     */
    public function getNoteAuthorId(){
        return $this->author_id;
    }
    /**
     * Get note text.
     *
     * @return string
     */
    public function getNoteText(){
        return $this->text;
    }
    /**
     * Get note image path.
     *
     * @return string|null
     */
    public function getNoteImage(){
        return $this->image;
    }
    /**
     * Get creation date.
     *
     * @return string
     */
    public function getNoteDate(){
        return $this->date;
    }
    /**
     * Get last updated date.
     *
     * @return string|null
     */
    public function getNoteUpdatedDate(){
        return $this->updated_at_date;
    }
    /**
     * Set note text.
     *
     * @param string $text
     */
    public function setNoteText($text){
        return $this->text = $text;
    }
    /**
     * Set note image path.
     *
     * @param string $image
     */
    public function setNoteImage($image){
        return $this->image = $image;
    }
    /**
     * Set creation date.
     *
     * @param string $date
     */
    public function setNoteDate($date){
        return $this->date = $date;
    }
    /**
     * Set last updated date.
     *
     * @param string $updated_at_date
     */
    public function setNoteUpdatedDate($updated_at_date){
        return $this->updated_at_date = $updated_at_date;
    }

}
