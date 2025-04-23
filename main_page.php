<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main Page</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Welcome to the Course Management System</h1>
    <nav>
        <ul>
            <li><a href="registration.php">Registration</a></li>
            <li><a href="schedule_page.php">My schedule</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>