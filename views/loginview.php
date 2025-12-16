<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/public/style.css">
</head>
<body>
<h1>Login</h1>


<form method="post">
    <div class="row">
        <label for="nickname"> Nickname: </label>
        <input type="text" id="nickname" name="nickname" placeholder="Nickname" value="<?= isset($_POST['nickname']) ? htmlspecialchars($_POST['nickname']) : '' ?>" required><br>
        <span class="error-message"></span>
    </div>
    <div class="row">
        <label for="password"> Password: </label>
        <input type="password" id="password" name="password" placeholder="Password" required><br>
        <span class="error-message"></span>
    </div>
    <button type="submit" class="login-user" name="submit">Login</button>
</form>

<script src="/public/login.js"></script>
<p class="center-text">Don't have an account? <a href="registration.php">Register here</a></p>
</body>
</html>