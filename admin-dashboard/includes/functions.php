<?php

// Database connection (already included in db.php, but can be added here if needed)
include_once 'db.php';

// Utility function to sanitize user input
function sanitizeInput($data) {
    // Trim whitespace, remove slashes, and convert special characters to HTML entities
    return htmlspecialchars(stripslashes(trim($data)));
}

function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

// Function to hash passwords
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Function to verify passwords
function verifyPassword($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}

// Function to check if a user is logged in (based on session)
function isLoggedIn() {
    // Check if session is active and user is logged in
    return isset($_SESSION['user_id']);
}

// Function to redirect to a specified page
function redirectTo($url) {
    header("Location: $url");
    exit();
}

// Function to sanitize output for HTML display (prevents XSS attacks)
function sanitizeOutput($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Function to display errors (to be used in development mode)
function displayError($error) {
    echo "<div class='error'>$error</div>";
}

// Function to handle form validation (checks if all required fields are filled)
function validateForm($formData, $requiredFields) {
    $errors = [];
    foreach ($requiredFields as $field) {
        if (empty($formData[$field])) {
            $errors[] = "The field $field is required.";
        }
    }
    return $errors;
}

// Function to log activity (e.g., user actions like adding/editing content)
function logActivity($userId, $action) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO activity_logs (user_id, action, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $userId, $action);
    $stmt->execute();
    $stmt->close();
}

// Function to send email notifications (for admin alerts or user notifications)
function sendEmail($to, $subject, $message, $headers) {
    if(mail($to, $subject, $message, $headers)) {
        return true;
    }
    return false;
}

// Function to check if user has a specific role (for role-based access control)
function hasRole($role) {
    // Check user role in the session
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
}

// Function to upload files (with validation for allowed types and size)
function uploadFile($file, $targetDirectory, $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'], $maxSize = 5000000) {
    $errors = [];
    
    // Check if file is valid
    if ($file['size'] > $maxSize) {
        $errors[] = "File size exceeds the maximum limit of $maxSize bytes.";
    }
    
    if (!in_array($file['type'], $allowedTypes)) {
        $errors[] = "Invalid file type. Allowed types: " . implode(", ", $allowedTypes);
    }
    
    if (empty($errors)) {
        $targetFile = $targetDirectory . basename($file['name']);
        
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $targetFile;
        } else {
            $errors[] = "Failed to upload file.";
        }
    }
    
    return $errors;
}

// Function to escape input data for SQL queries (prevents SQL Injection)
function escapeInput($data) {
    global $conn;
    return mysqli_real_escape_string($conn, $data);
}

?>
