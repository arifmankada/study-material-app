<?php
include 'includes/db.php';

// Prepare and execute query
$stmt = $conn->prepare('SELECT * FROM content WHERE id = ?');
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$result = $stmt->get_result();

// Fetch and display data
if ($row = $result->fetch_assoc()) {
    echo '<div style="font-family: Arial, sans-serif; margin: 20px;">';
    echo '<h1 style="color: #2c3e50;">' . htmlspecialchars($row['title']) . '</h1>';
    echo '<p style="font-size: 18px; color: #34495e;">' . htmlspecialchars($row['description']) . '</p>';
    echo '<div style="background-color: #ecf0f1; padding: 15px; border-radius: 5px;">' . htmlspecialchars($row['details']) . '</div>';
    echo '</div>';
} else {
    echo '<p style="color: red;">Content not found.</p>';
}
echo '<a href="index.php" style="display: inline-block; margin-top: 20px; text-decoration: none; color: white; background: #3498db; padding: 10px 15px; border-radius: 5px;">Back to Topics</a>';

$relatedStmt = $conn->prepare('SELECT id, title FROM content WHERE id != ? LIMIT 5');
$relatedStmt->bind_param('i', $_GET['id']);
$relatedStmt->execute();
$relatedResult = $relatedStmt->get_result();

echo '<h2>Related Topics</h2><ul>';
while ($related = $relatedResult->fetch_assoc()) {
    echo '<li><a href="topic.php?id=' . $related['id'] . '">' . htmlspecialchars($related['title']) . '</a></li>';
}
echo '</ul>';


?>
