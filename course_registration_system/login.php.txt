php
Run
Copy code
<?php
session_start(); // Start the session
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password is empty
$dbname = "course_registration"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Initialize message variable
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if form is submitted
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute SQL query to find user by email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Fetch user data
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on user role
            if ($row['role'] === 'instructor') {
                header("Location: instructor_queue.php"); // Redirect to instructor queue
            } else {
                header("Location: courses.php"); // Redirect to courses page
            }
            exit(); // Exit to prevent further execution
        } else {
            $message = "Invalid password."; // Invalid password message
        }
    } else {
        $message = "No user found with that email."; // No user found message
    }
}
$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
</head>
<body>
    <h2>User Login</h2>
    <form action="login.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <p><?php if (isset($message)) echo $message; ?></p> <!-- Display error messages -->
</body>
</html>
