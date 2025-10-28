<?php
session_start();

require_once __DIR__ . "/../src/controllers/userController.php";

$request_method = $_SERVER["REQUEST_METHOD"];
$user_controller = new UserController();


if ($request_method == "POST" && isset($_POST['submit'])) {
    $errors = $user_controller->login_user($_POST);
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h1>Login</h1>

<?php
if (!empty($errors)) {
    foreach ($errors as $field => $error) {
        echo "<p style='color:red;'>$error</p>";
    }
}
?>

<form method="POST">
    <input type="text" name="nickname" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="submit">Login</button>
</form>

<p>Don't have an account? <a href="registrationMVC.php">Register here</a></p>
</body>
</html>