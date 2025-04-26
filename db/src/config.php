<?php
// Database configuration
$host = 'mysql'; // Use the service name defined in docker-compose
$username = 'root';
$password = 'root';
$database = 'agency_x_users';

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set character set to UTF-8
mysqli_set_charset($conn, 'utf8mb4');

// echo "✅ Connected to MySQL successfully!";
?>