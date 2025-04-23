<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $courses = $_POST['courses'] ?? [];

    foreach ($courses as $course_id) {
        // Insert queue request into the queue_requests table
        $sql = "INSERT INTO queue_requests (user_id, course_id) VALUES ('$user_id', '$course_id')";
        mysqli_query($conn, $sql);
    }

    echo "Your queue request has been submitted.";
    echo '<br><a href="main_page.php">Go back to main page</a>';
}
?>