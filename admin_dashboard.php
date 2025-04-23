<?php
session_start();
include('includes/db.php');




// Fetch queue requests
$requests = mysqli_query($conn, "SELECT qr.id, u.username, c.course_name, qr.request_date 
                                  FROM queue_requests qr 
                                  JOIN users u ON qr.user_id = u.id 
                                  JOIN courses c ON qr.course_id = c.id");

if (!$requests) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/css1.css">
</head>
<body>
    <h1>Queue Requests</h1>
    <table>
        <tr>
            <th>Request ID</th>
            <th>Username</th>
            <th>Course Name</th>
            <th>Request Date</th>
            <th>Action</th>
        </tr>
        <?php while ($request = mysqli_fetch_assoc($requests)): ?>
            <tr>
                <td><?php echo htmlspecialchars($request['id']); ?></td>
                <td><?php echo htmlspecialchars($request['username']); ?></td>
                <td><?php echo htmlspecialchars($request['course_name']); ?></td>
                <td><?php echo htmlspecialchars($request['request_date']); ?></td>
                <td>
                    <form action="accept_request.php" method="POST">
                        <input type="hidden" name="request_id" value="<?php echo $request['id']; ?>">
                        <input type="submit" value="Accept">
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="logout.php">Logout</a>
</body>
</html>