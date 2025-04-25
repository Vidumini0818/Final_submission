<?php
// includes/db_connection.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Use strong password in production
define('DB_NAME', 'happelow_events');

// Create connection with error handling
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    error_log($e->getMessage());
    // In production, show a generic error message
    die("A database error occurred. Please try again later.");
}

// Helper functions
function sanitize_input($conn, $data) {
    return $conn->real_escape_string(trim($data));
}

function sanitize_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
?>