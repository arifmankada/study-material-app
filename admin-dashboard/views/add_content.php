<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $topic_id = $_POST['topic_id'];

    // Validate inputs
    if (!empty($title) && !empty($description)) {
        $stmt = $conn->prepare("INSERT INTO content (title, description, topic_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $description, $topic_id);
        $stmt->execute();
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Content</title>
</head>
<body>
    <h1>Add New Content</h1>
    <a href="dashboard.php">Back to Dashboard</a>

    <form action="add_content.php" method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" required>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea>

        <label for="topic_id">Topic:</label>
        <select name="topic_id" required>
            <option value="2">Salah</option>
            <!-- Add other topics dynamically if necessary -->
        </select>

        <button type="submit">Add Content</button>
    </form>
</body>
</html>
