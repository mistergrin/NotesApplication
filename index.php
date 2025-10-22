<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /src/login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>page</title>
</head>

<body>
<header>
    <h1>Page</h1>
</header>

<h1> <?php echo "Welcome, " . $_SESSION['nickname']; ?> </h1>

<article>
    <form action="/src/users.php" method="post">
        <label for="nickname">nickname:</label><br>
        <input type="text" id="nickname" name="nickname"><br>
        <input type="hidden" name="_method" value="DELETE">
        <input type="submit" value="Delete">
    </form>
</article>


<article>
    <form action="/src/users.php" method="post">
        <label for="nickname">nickname:</label><br>
        <input type="text" id="nickname" name="nickname"><br>
        <label for="firstname">firstname:</label><br>
        <input type="text" id="firstname" name="firstname"><br>
        <label for="lastname">lastname:</label><br>
        <input type="text" id="lastname" name="lastname"><br>
        <label for="password">password:</label><br>
        <input type="text" id="password" name="password"><br>
        <input type="submit" value="Submit">
    </form>
</article>


<footer>
    <p>Good bye!</p>
</footer>

</body>
</html>