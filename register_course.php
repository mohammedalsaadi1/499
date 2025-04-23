<?php
session_start();
include('includes/db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Check if courses were selected
if (isset($_POST['courses'])) {
    $selected_courses = $_POST['courses'];
    
    // Prepare to insert each selected course into the registrations table
    foreach ($selected_courses as $course) {
        // Prepare the SQL statement
        $sql = "INSERT INTO schedules (user_id, course_name) VALUES ('" . mysqli_real_escape_string($conn, $_SESSION['user_id']) . "', '" . mysqli_real_escape_string($conn, $course) . "')";
        
        // Execute the query
        if (mysqli_query($conn, $sql)) {
            echo "You have successfully registered for the course: " . htmlspecialchars($course) . "<br>";
        } else {
            // Output error message if the query fails
            echo "Error: " . mysqli_error($conn) . "<br>";
        }
    }
} else {
    echo "No courses selected.";
}

// Close the database connection
mysqli_close($conn);
?>