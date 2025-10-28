<?php

function notes_validation($data){

    $errors = [];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];

    $text = trim($data['text']);
    $image = $_FILES['image']['name'];

    if (empty($text)){
        $errors["empty_text"] = "Enter a text";
    } elseif (strlen($text) > 1000){
        $errors["too_long"] = "The text is too long(1000 characters max)";
    }

    if (!empty($image)) {
        $file_type = mime_content_type($_FILES['image']['tmp_name']);
        if (!in_array($file_type, $allowed_types)) {
            $errors["invalid_image"] = "Invalid image format";
        }
    }
    return $errors;
}