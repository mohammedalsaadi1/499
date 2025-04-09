<?php
session_start(); // Start the session
if (!isset($_SESSION['user_id'])) { // Check if user is logged in
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password is empty
$dbname = "course_registration"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch courses
$sql = "SELECT * FROM courses WHERE status = 'open'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Courses</title>
</head>
<body>
    <h2>Available Courses</h2>
    <nav>
        <a href="index.php">Home</a>
        <a href="my_courses.php">My Courses</a>
        <?php if ($_SESSION['role'] === 'instructor'): ?>
            <a href="instructor_queue.php">Instructor Queue</a>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </nav>
    <table border="1">
        <tr>
            <th>Course Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['course_name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td>
                <form action="register_course.php" method="POST">
                    <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Register</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="index.php">Back to Home</a>
</body>
</html>