<?php
// Your password that you want to hash
$password = 'admin123';

// Hash the password using PASSWORD_DEFAULT
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Output the hashed password
echo "Hashed password: " . $hashed_password;
?>
