<?php
// Database connection parameters
$hostname_bid = "localhost"; // e.g., "localhost"
$database_bid = "oouth_bid"; // e.g., "your_database_name"
$username_bid = "root"; // e.g., "root"
$password_bid = "Oluwaseyi"; // e.g., "your_password"

// Establish connection
$bid = new mysqli($hostname_bid, $username_bid, $password_bid, $database_bid);

// Check connection
if ($bid->connect_error) {
    die("Connection failed: " . $bid->connect_error);
}
?>

