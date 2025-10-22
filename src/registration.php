<?php
session_start();

require_once __DIR__ . "/validations/registr_validation.php";
require_once  __DIR__."/../src/user.php";
require_once __DIR__."/../db/database.php";

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == "POST" && isset($_POST['submit'])){
    $errors = validation_registration($_POST);

    if (empty($errors)){
        $data = $_POST;
        $hash_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user = new User(null, $data["nickname"], $data["first_name"], $data["last_name"], $hash_password);
        UsersDB::addUser($user);
        header("Location: login.php");
        exit;
    }
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

<form method="POST">
    <input type="text" name="nickname" placeholder="Nickname" required><br>
    <input type="text" name="first_name" placeholder="First Name" required><br>
    <input type="text" name="last_name" placeholder="Last Name" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="submit">Register</button>
</form>

<p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>