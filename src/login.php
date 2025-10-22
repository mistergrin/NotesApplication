<?php

require __DIR__.'/session.php';


require_once __DIR__ . "/validations/login_validation.php";
require_once __DIR__ ."/../db/database.php";
require_once __DIR__ ."/session.php";

$request_method = $_SERVER["REQUEST_METHOD"];

$errors_login = [];

if ($request_method == "POST" && isset($_POST['submit'])){
    $errors_validation = login_validation($_POST);

    if (empty($errors_validation)){
        $data = $_POST;
        $user_found = null;
        $all_users = UsersDB::allUsers();

        foreach ($all_users as $user){
            if ($data["nickname"] == $user->getNickname()){
                $user_found = $user;
                break;
            }
        }
        if ($user_found){
            if (password_verify($data['password'], $user_found->getPassword())){
                $_SESSION['nickname'] = $user_found->getNickname();
                $_SESSION['user_id'] = $user_found->getId();
                header('Location: ../index.php');
                exit;
            } else {
                $errors_login['invalid_password'] = "Incorrect password";
            }
        }
        else {
            $errors_login['invalid_username'] = "User not found";
        }
        $errors_login = array_merge($errors_login, $errors_validation);
    }
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
    if (!empty($errors_login)) {
        foreach ($errors_login as $field => $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
    ?>

    <form method="POST">
        <input type="text" name="nickname" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="registration.php">Register here</a></p>
</body>
</html>