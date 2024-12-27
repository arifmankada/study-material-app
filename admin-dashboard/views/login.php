<?php
session_start();
include('../includes/db.php');  // Ensure the DB connection is included

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL query
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param('s', $username);

    if (!$stmt->execute()) {
        die('Query execution failed: ' . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result === false) {
        die('Error getting result: ' . $stmt->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Debugging: Output the hashed password from the database
        echo "Hashed Password: " . $row['password'] . "<br>";
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            session_start();  // Make sure this line is at the very top of the script
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];  // Optional: store user role
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password!";
        }
        
    } else {
        echo "No user found with that username!";
    }

    $stmt->close();
}
?>

<form method="POST" action="login.php">
    <label for="username">Username:</label>
    <input type="text" name="username" required>
    <label for="password">Password:</label>
    <input type="password" name="password" required>
    <button type="submit">Login</button>
</form>
