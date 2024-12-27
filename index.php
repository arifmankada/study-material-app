<?php
// Start the session
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: admin-dashboard/views/login.php");
    exit();
}

// Include necessary files
require_once 'admin-dashboard/includes/db.php';
require_once 'admin-dashboard/includes/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome to Admin Dashboard</h1>
    <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <ul>
        <li><a href="admin-dashboard/views/dashboard.php">Go to Dashboard</a></li>
        <li><a href="admin-dashboard/views/add_content.php">Add New Content</a></li>
        <li><a href="admin-dashboard/views/edit_content.php">Edit Content</a></li>
        <li><a href="admin-dashboard/views/delete_content.php">Delete Content</a></li>
        <li><a href="admin-dashboard/logout.php">Logout</a></li>
    </ul>
    <footer>
        <p>&copy; 2024 Your Company Name. All rights reserved.</p>
    </footer>
</body>
</html>
