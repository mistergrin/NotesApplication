<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="/public/style.css">
</head>
<body>
<h1>Create a Note</h1>

<form method="post" enctype="multipart/form-data">

    <div class="row">
        <label for="text">Note text:</label>
        <textarea id="text" name="text" required></textarea>
        <span class="error-message"></span>
    </div>
    <div class="row">
        <label for="image">Image:</label>
        <input type="file" id="image" name="image">
        <span class="error-message"></span>
    </div>

    <button type="submit">Add note</button>

</form>

<script src="/public/note.js"></script>
</body>
</html>