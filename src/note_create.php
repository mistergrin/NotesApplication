<?php
session_start();

require_once __DIR__. "/../db/notesDB.php";
require_once __DIR__. "/validations/note_validation.php";
require_once  __DIR__."/../src/note.php";

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == "POST" && isset($_POST["submit"])) {
    $errors = notes_validation($_POST);

    if (empty($errors)) {
        $upload_dir = __DIR__. "/../storage/uploads/";
        $data = $_POST;
        $image_link = null;
        if (!empty($_FILES['image'])){
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $file_name = uniqid("image_").".".$ext;
            $file_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
                $image_link = "/storage/uploads/" . $file_name;
            }
        }

        $note = new Note(null, $_SESSION["nickname"], $data["text"], $image_link, date("Y-m-d H:i"));
        NotesDB::addNote($note);
        header("Location: /index.php");
        exit();
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Create a note</legend>

        <label for="text">Text:</label><br>
        <input type="text" id="text" name="text" value="<?= htmlspecialchars($_POST['text'] ?? '') ?>"><br>
        <?php if (!empty($errors['empty_text'])): ?>
            <span style="color:red;"><?= $errors['empty_text'] ?></span><br>
        <?php endif; ?>

        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image"><br>
        <?php if (!empty($errors['invalid_image'])): ?>
            <span style="color:red;"><?= $errors['invalid_image'] ?></span><br>
        <?php endif; ?>

        <input type="submit" name="submit">
    </fieldset>
</form>



