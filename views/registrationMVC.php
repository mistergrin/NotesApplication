<?php
session_start();

require_once __DIR__. "/../src/controllers/userController.php";


$user_controller = new UserController();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $errors = $user_controller->register_user($_POST);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
<h1>Register</h1>

<?php
if (!empty($errors)) {
    foreach ($errors as $field => $error) {
        echo "<p style='color:red;'>$error</p>";
    }
}
?>

<form method="post">
    <input type="text" name="nickname" placeholder="Nickname" required><br>
    <input type="text" name="first_name" placeholder="First Name" required><br>
    <input type="text" name="last_name" placeholder="Last Name" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="submit">Register</button>
</form>

<p>Already have an account? <a href="loginview.php">Login here</a></p>
</body>
</html>