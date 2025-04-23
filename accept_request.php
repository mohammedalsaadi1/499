<?php
session_start();
include('includes/db.php');



// Check if request_id is set
if (isset($_POST['request_id'])) {
    $request_id = intval($_POST['request_id']);

    // Fetch the request details
    $query = "SELECT user_id, course_id FROM queue_requests WHERE id = $request_id";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $request = mysqli_fetch_assoc($result);
        $user_id = $request['user_id'];
        $course_id = $request['course_id'];

        // Add the course to the student's schedule
        $insert_query = "INSERT INTO schedules (user_id) VALUES ($user_id)";
        if (mysqli_query($conn, $insert_query)) {
            // Optionally, delete the request after acceptance
            mysqli_query($conn, "DELETE FROM queue_requests WHERE id = $request_id");
            header("Location: admin_dashboard.php?success=Course accepted successfully.");
        } else {
            die("Error adding course: " . mysqli_error($conn));
        }
    } else {
        die("Request not found.");
    }
} else {
    die("Invalid request.");
}
?>