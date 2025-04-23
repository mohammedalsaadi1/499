<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch courses
$courses = mysqli_query($conn, "SELECT * FROM courses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Queue Requests</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Queue Requests</h1>
    <form action="submit_queue_request.php" method="POST">
        <h2>Select Course to Queue</h2>
        <?php while ($course = mysqli_fetch_assoc($courses)): ?>
            <div>
                <input type="checkbox" name="courses[]" value="<?php echo $course['id']; ?>">
                <label><?php echo $course['course_name']; ?></label>
            </div>
        <?php endwhile; ?>
        <button type="submit">Submit Queue Request</button>
    </form>
</body>
</html>