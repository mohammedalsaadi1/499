<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration System</title>
    <link rel="stylesheet" href="style.css"> <!-- Optional: Link to your CSS file -->
</head>
<body>
    <h1>Welcome to the Course Registration System</h1>
    <nav>
        <a href="index.php">Home</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="courses.php">View Courses</a>
            <?php if ($_SESSION['role'] === 'instructor'): ?>
                <a href="instructor_queue.php">Instructor Queue</a>
            <?php endif; ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="register.php">Register</a>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</body>
</html>