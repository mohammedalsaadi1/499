<?php
session_start();
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password is empty
$dbname = "course_registration"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Check if the course is full
    $sql = "SELECT COUNT(*) as count FROM queue WHERE course_id = $course_id AND status = 'approved'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $count = $row['count'];

    // Assuming a maximum capacity of 30 students for the course
    if ($count < 30) {
        // Register the student directly
        $sql = "INSERT INTO queue (user_id, course_id, status) VALUES ('$user_id', '$course_id', 'approved')";
        if ($conn->query($sql) === TRUE) {
            $message = "Successfully registered for the course!";
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        // Add to queue
        $sql = "INSERT INTO queue (user_id, course_id, status) VALUES ('$user_id', '$course_id', 'pending')";
        if ($conn->query($sql) === TRUE) {
            $message = "Course is full. You have been added to the queue.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Course</title>
</head>
<body>
    <h2>Course Registration</h2>
    <p><?php if (isset($message)) echo $message; ?></p>
    <a href="courses.php">Back to Courses</a>
</body>
</html>