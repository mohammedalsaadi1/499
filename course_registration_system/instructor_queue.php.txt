<?php
session_start(); // Start the session
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'instructor') { // Check if user is logged in and is an instructor
    header("Location: login.php"); // Redirect to login page if not logged in or not an instructor
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

// Fetch pending queue entries
$sql = "SELECT q.id, u.username, c.course_name, u.current_credits, u.finished_credits 
        FROM queue q 
        JOIN users u ON q.user_id = u.id 
        JOIN courses c ON q.course_id = c.id 
        WHERE q.status = 'pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Instructor Queue</title>
</head>
<body>
    <h2>Course Queue</h2>
    <nav>
        <a href="index.php">Home</a>
        <a href="my_courses.php">My Courses</a>
        <a href="logout.php">Logout</a>
    </nav>
    <table border="1">
        <tr>
            <th>Student</th>
            <th>Course</th>
            <th>Current Credits</th>
            <th>Finished Credits</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['course_name']; ?></td>
            <td><?php echo $row['current_credits']; ?></td>
            <td><?php echo $row['finished_credits']; ?></td>
            <td>
                <form action="process_queue.php" method="POST">
                    <input type="hidden" name="queue_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="action" value="approve">Approve</button>
                    <button type="submit" name="action" value="reject">Reject</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="index.php">Back to Home</a>
</body>
</html>