<?php
// Database connection for delivery system
// Set your DB name, user, password as needed

$host = "localhost";
$db   = "shop";      // <-- apne database ka naam yahan likho
$user = "root";            // Default XAMPP user
$pass = "";                // Default XAMPP password (change if set)

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
