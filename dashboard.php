<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect to login if not logged in
    header("Location: /admin-dashboard/views/login.php");
    exit();
}

echo "Welcome to the Dashboard, " . htmlspecialchars($_SESSION['username']) . "!";
?>

include 'includes/db.php';

// Fetch all content
$query = "SELECT * FROM content ORDER BY id ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h1>
    <a href="logout.php">Logout</a>

    <h2>Manage Content</h2>
    <a href="add_content.php">Add New Content</a>

    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    echo "<td>
                        <a href='edit_content.php?id=" . $row['id'] . "'>Edit</a> | 
                        <a href='delete_content.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No content available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
