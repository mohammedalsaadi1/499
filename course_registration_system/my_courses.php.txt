<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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

// Fetch courses and queue status for the logged-in user
$user_id = $_SESSION['user_id'];
$sql = "SELECT c.course_name, q.status 
        FROM queue q 
        JOIN courses c ON q.course_id = c.id 
        WHERE q.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Courses</title>
</head>
<body>
    <h2>My Courses</h2>
    <nav>
        <a href="index.php">Home</a>
        <a href="courses.php">View Courses</a>
        <a href="logout.php">Logout</a>
    </nav>
    <table border="1">
        <tr>
            <th>Course Name</th>
            <th>Status</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['course_name']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">You are not registered for any courses.</td>
            </tr>
        <?php endif; ?>
    </table>
    <a href="courses.php">Back to Courses</a>
</body>
</html>