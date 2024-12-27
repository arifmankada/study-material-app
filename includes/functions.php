<?php

// Database connection
include_once 'db.php'; // Use include_once to avoid multiple inclusions

// Utility function to sanitize user input
if (!function_exists('sanitizeInput')) {
    function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}

// Function to hash passwords
if (!function_exists('hashPassword')) {
    function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}

// Function to verify passwords
if (!function_exists('verifyPassword')) {
    function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
}

// Function to check if a user is logged in
if (!function_exists('isLoggedIn')) {
    function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}

// Function to redirect to a specified page
if (!function_exists('redirectTo')) {
    function redirectTo($url) {
        header("Location: $url");
        exit();
    }
}

// Function to escape input data for SQL queries
if (!function_exists('escapeInput')) {
    function escapeInput($data) {
        global $conn;
        return mysqli_real_escape_string($conn, $data);
    }
}
?>
