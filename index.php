<?php
session_start();
if (!isset($_SESSION['nickname'])) {
    header("Location: /~hryshiva/site/views/loginview.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Notes Application</title>
    <link rel="stylesheet" href="/~hryshiva/site/public/style.css">
</head>

<body>
<header>
    <div class="header-container">
        <h1 class="app-title">NotesApplication</h1>
        <nav class="nav-buttons">
            <?php if ($_SESSION['role'] == "ADMIN"): ?>
            <a href="/~hryshiva/site/views/all_users.php" class="nav-btn">Admin Panel</a>
            <?php endif; ?>
            <a href="/~hryshiva/site/views/notes_form.php" class="nav-btn">Create a note</a>
            <a href="/~hryshiva/site/views/logout_view.php" class="nav-btn">Logout</a>
            <a href="/~hryshiva/site/views/profile.php" class="nav-btn">Your Profile</a>
        </nav>
    </div>
</header>

<main>
    <section class="welcome">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['nickname']) ?>!</h1>
    </section>


    <section class="notes-container"></section>
    <div class="modal-background" id="modal">
        <div class="modal-content">
            <span class="modal-close" id="modal-close">&times;</span>
            <div class="modal-text"></div>
            <div class="modal-image"></div>
            <div class="modal-date"></div>

            <div class="modal-actions">
                <button class="modal-edit">Edit</button>
                <button class="modal-delete">Delete</button>
            </div>
            <div class="hidden" id="modal-edit-block">
                <form method="post" class="modal-edit-form">

                    <div class="row">
                        <label for="text">Edit text:</label>
                        <textarea id="text" class="modal-edit-text" name="text"></textarea>
                        <span class="error-message"></span>
                    </div>

                    <div class="row">
                        <label for="image">Change image (optional):</label>
                        <input id="image" type="file" class="modal-edit-image" name="image">
                        <span class="error-message"></span>
                    </div>

                    <button type="submit" class="modal-save">Save changes</button>
                </form>
            </div>
        </div>
    </div>
    <div class="pagination-wrapper">
        <div class="pagination"></div>
    </div>
</main>
<script src="/~hryshiva/site/public/main.js"></script>
</body>
</html>