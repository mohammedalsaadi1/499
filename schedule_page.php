<?php
session_start();
include('includes/db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Query to get the schedule for the logged-in user
$sql = "SELECT course_name, day_of_week, start_time, end_time FROM schedules WHERE user_id = $user_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Schedule</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Link to your CSS file -->
</head>
<body>
    <h1>Your Schedule</h1>
    <table border="1">
        <tr>
            <th>Course Name</th>
            <th>Day of Week</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['course_name']}</td>
                        <td>{$row['day_of_week']}</td>
                        <td>{$row['start_time']}</td>
                        <td>{$row['end_time']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No schedule found.</td></tr>";
        }
        ?>
    </table>
    <br>
    <a href="main_page.php">Back to Main Page</a> <!-- Link back to the main page -->
</body>
</html>