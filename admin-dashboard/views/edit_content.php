<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch content data
    $query = "SELECT * FROM content WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $content = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $topic_id = $_POST['topic_id'];

    // Update content
    $stmt = $conn->prepare("UPDATE content SET title = ?, description = ?, topic_id = ? WHERE id = ?");
    $stmt->bind_param("ssii", $title, $description, $topic_id, $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Content</title>
</head>
<body>
    <h1>Edit Content</h1>
    <a href="dashboard.php">Back to Dashboard</a>

    <form action="edit_content.php?id=<?php echo $id; ?>" method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($content['title']); ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($content['description']); ?></textarea>

        <label for="topic_id">Topic:</label>
        <select name="topic_id" required>
            <option value="2" <?php if ($content['topic_id'] == 2) echo 'selected'; ?>>Salah</option>
            <!-- Add other topics dynamically if necessary -->
        </select>

        <button type="submit">Update Content</button>
    </form>
</body>
</html>
