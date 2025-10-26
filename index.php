<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /src/login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>page</title>
</head>

<body>
<header>
    <h1>Page</h1>
</header>

<h1> <?php echo "Welcome, " . $_SESSION['nickname']; ?> </h1>

Now you can create a note <a href="src/note_create.php">right here </a>

<form action="/src/note_create.php" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Create a note</legend>
        <label for="text">text:</label><br>
        <input type="text" id="text" name="text"><br>
        <label for="image">image:</label><br>
        <input type="file" id="image" name="image"><br>
        <?php if(isset($errors['image'])): ?>
            <p style="color:red"><?= $errors['image'] ?></p>
        <?php endif; ?>
        <input type="submit" name="submit">
    </fieldset>
</form>



<footer>
    <p>Good bye!</p>
</footer>

</body>
</html>