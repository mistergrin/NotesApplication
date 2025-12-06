<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Users - Admin Panel</title>
    <link rel="stylesheet" href="../public/style.css">

</head>
<body>
<header>
    <div class="header-container">
        <h1 class="app-title">Admin Panel - Users</h1>
        <nav class="nav-buttons">
            <a href="/index.php" class="nav-btn">Home</a>
            <a href="/views/profile.php" class="nav-btn">Your Profile</a>
        </nav>
    </div>
</header>

<h1>All users</h1>

<div class="table-section">
<table class="users-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nickname</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody id="users-table">

    </tbody>
</table>
</div>

<script src="/public/allUsers.js"></script>
</body>
</html>
