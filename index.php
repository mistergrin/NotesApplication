<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /views/loginview.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Notes Application</title>
    <link rel="stylesheet" href="public/style.css">
</head>

<body>
<header>
    <div class="header-container">
        <h1 class="app-title">NotesApplication</h1>
        <nav class="nav-buttons">
            <a href="about.php" class="nav-btn">About Application</a>
            <a href="/views/profile.php" class="nav-btn">Your Profile</a>
            <a href="how_to.php" class="nav-btn">How to Create a Note</a>
        </nav>
    </div>
</header>

<main>
    <section class="welcome">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['nickname']) ?>!</h1>
        <p>Now you can create a note <a href="views/notes_form.php">right here</a>.</p>
        <p>You can logout <a href="views/logout_view.php">here</a>.</p>
    </section>

</main>

<footer>
    <p>Good bye!</p>
</footer>

</body>
</html>