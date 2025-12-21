<?php

/**
 * Validate note data and uploaded image.
 *
 * Checks that the note text is not empty, does not exceed 3000 characters,
 * and that the uploaded image (if any) is of an allowed type (JPEG, PNG, GIF, JPG).
 *
 * @param array $data POST data containing 'text'
 * @param array $fileData Uploaded file data (e.g., $_FILES['image'])
 *
 * @return array Associative array of errors.
 *               - Empty array if validation passes (no errors)
 *               - Otherwise, contains keys for invalid fields with error messages
 *               e.g., ['text' => 'Enter a text', 'image' => 'Invalid file type. Allowed types: JPEG, PNG, GIF, JPG']
 */


function notes_validation($data, $fileData){

    $errors = [];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];

    $text = trim($data['text']);
    $image = $fileData['image']['name'];

    if (empty($text)){
        $errors["text"] = "Enter a text";
    } elseif (strlen($text) > 3000){
        $errors["text"] = "The text is too long(3000 characters max)";
    }

    if (!empty($image)) {
        $file_type = mime_content_type($_FILES['image']['tmp_name']);
        if (!in_array($file_type, $allowed_types)) {
            $errors["image"] = "Invalid file type. Allowed types: JPEG, PNG, GIF, JPG ";
        }
    }
    return $errors;
}