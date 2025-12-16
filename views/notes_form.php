<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("/views/loginview.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="/public/style.css">
</head>
<body>
<header>
    <div class="header-container">
        <h1 class="app-title">NotesApplication</h1>
        <nav class="nav-buttons">
            <?php if ($_SESSION['role'] == "ADMIN"): ?>
                <a href="/views/all_users.php" class="nav-btn">Admin Panel</a>
            <?php endif; ?>
            <a href="/index.php" class="nav-btn">Main</a>
            <a href="profile.php" class="nav-btn">Your Profile</a>
        </nav>
    </div>
</header>


<h1>Create a Note</h1>

<form method="post" enctype="multipart/form-data">

    <div class="row">
        <label for="text">Note text:</label>
        <textarea id="text" name="text" class="create-note-text " required></textarea>
        <span class="error-message"></span>
    </div>
    <div class="row">
        <label for="image">Image:</label>
        <input type="file" id="image" name="image">
        <span class="error-message"></span>
    </div>

    <button class="create-note" type="submit">Add note</button>

</form>

<script src="/public/note.js"></script>
</body>
</html>