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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $queue_id = $_POST['queue_id'];
    $action = $_POST['action'];

    if ($action == 'approve') {
        // Update queue status to approved
        $sql = "UPDATE queue SET status = 'approved' WHERE id = $queue_id";
        if ($conn->query($sql) === TRUE) {
            // Logic to register the student for the course
            $sql = "SELECT user_id, course_id FROM queue WHERE id = $queue_id";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user_id = $row['user_id'];
                $course_id = $row['course_id'];

                // Insert the student into the courses table
                $sql = "INSERT INTO queue (user_id, course_id, status) VALUES ('$user_id', '$course_id', 'approved')";
                $conn->query($sql);
            }
        }
    } elseif ($action == 'reject') {
        // Update queue status to rejected
        $sql = "UPDATE queue SET status = 'rejected' WHERE id = $queue_id";
        $conn->query($sql);
    }
}

$conn->close();
header("Location: instructor_queue.php");
exit();