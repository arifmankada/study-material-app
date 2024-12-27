<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $topic_id = $_POST['topic_id'];

    // Validate inputs (to avoid malicious data)
    if (!empty($title) && !empty($description) && !empty($topic_id)) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO content (title, description, topic_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $description, $topic_id);
        $stmt->execute();

        // Redirect or provide success message
        echo "Content added successfully.";
    } else {
        echo "All fields are required.";
    }
}
?>
