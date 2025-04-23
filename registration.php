<?php
session_start();
include('includes/db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch available courses from the database (optional)
$courses = [];
$sql = "SELECT course_name FROM courses"; // Assuming you have a 'courses' table
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $courses[] = $row['course_name'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registration</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional: Link to your CSS file -->
</head>
<body>
    <h1>Register for a Course</h1>
    <form action="register_course.php" method="POST">
        <div id="course-list">
            <?php
            // Populate the list with available courses as checkboxes
            foreach ($courses as $course) {
                echo "<label><input type=\"checkbox\" name=\"courses[]\" value=\"" . htmlspecialchars($course) . "\"> " . htmlspecialchars($course) . "</label><br>";
            }
            ?>
        </select>
        <div id="registration-buttons">
            <input type="submit" value="Register">
            <button type="button" onclick="viewQueue()"> Queue</button>
        </div>
    </form>
    <br>
    <a href="main_page.php">Back to Main Page</a> <!-- Link back to the main page -->

    <script>
        function viewQueue() {
            window.location.href = 'queue_requests.php'; // Replace with your actual queue page URL
        }
    </script>
</body>
</html>