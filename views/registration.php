<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="/public/style.css">
 </head>
<body>
<h1>Register</h1>


<form method="post" class="form">
    <div class="row">
        <label for="nickname"> Nickname: </label>
        <input type="text" id="nickname" name="nickname" placeholder="Nickname" value="<?= isset($_POST['nickname']) ? htmlspecialchars($_POST['nickname']) : '' ?>" required><br>
        <span class="error-message"></span>
    </div>
    <div class="row">
        <label for="first_name"> FirstName: </label>
        <input type="text" id="first_name" name="first_name" placeholder="First Name" value="<?= isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : '' ?>" required><br>
        <span class="error-message"></span>
    </div>
    <div class="row">
        <label for="last_name"> LastName: </label>
        <input type="text" id="last_name" name="last_name" placeholder="Last Name" value="<?= isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '' ?>" required><br>
        <span class="error-message"></span>
    </div>
    <div class="row">
        <label for="password"> Password: </label>
        <input type="password" id="password" name="password" placeholder="Password" required><br>
        <span class="error-message"></span>
    </div>

    <div class="row">
        <label for="password_confirm"> Confirm the password:</label>
        <input type="password" id="password_confirm" name="password_again" placeholder="Password confirm" required><br>
        <span class="error-message"></span>
    </div>
    <button type="submit" name="submit">Register</button>
</form>


<p class="center-text">Already have an account? <a href="loginview.php">Login here</a></>
<script src="/public/registration.js"></script>
</body>
</html>