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
    <meta charset="UTF-8">
    <title>Your Profile</title>
    <link rel="stylesheet" href="/public/style.css">
</head>

<body>
<header>
    <div class="header-container">
        <h1 class="app-title">NotesApplication</h1>
        <nav class="nav-buttons">
            <a href="/index.php" class="nav-btn">Main</a>
            <a href="about.php" class="nav-btn">About Application</a>
            <a href="profile.php" class="nav-btn">Your Profile</a>
            <a href="how_to.php" class="nav-btn">How to Create a Note</a>
        </nav>
    </div>
</header>

<main>
    <section class="profile-section">
        <h2>Your Profile</h2>
        <div class="profile-info">
            <p><strong>Nickname:</strong> <span id="newNickName"><?php echo htmlspecialchars($_SESSION['nickname']); ?></span></p>
            <p><strong>First Name:</strong> <span id="newFirstName"><?php echo htmlspecialchars($_SESSION['first_name']); ?></span></p>
            <p><strong>Last Name:</strong> <span id="newLastName"><?php echo htmlspecialchars($_SESSION['last_name']); ?></span></p>
            <button id="editBtn">Edit Profile</button>
        </div>
        <div id="profileFormContainer" class="hidden">
            <form method="post" class="form" id="profileForm">
                <div class="row">
                    <label for="nickname">Nickname:</label>
                    <input type="text" id="nickname" name="nickname" value="<?= htmlspecialchars($_SESSION['nickname']) ?>" required>
                    <span class="error-message"</span>
                </div>

                <div class="row">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($_SESSION['first_name']) ?>" required>
                    <span class="error-message"</span>
                </div>

                <div class="row">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($_SESSION['last_name']) ?>" required>
                    <span class="error-message"</span>
                </div>
                <button type="submit" name="save">Save Changes</button>
                <button type="button" id="cancelButton">Cancel</button>
            </form>
        </div>


    </section>


</main>
<script src="/public/editUser.js"></script>
</body>
</html>
