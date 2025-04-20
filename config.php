<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'fmarket');

// Create database connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Set charset to utf8
    $conn->set_charset("utf8");
    
} catch (Exception $e) {
    error_log("Database Connection Error: " . $e->getMessage());
    die("Sorry, there was a problem connecting to our database. Please try again later.");
}

// Function to sanitize input
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Function to handle database queries safely
function safe_query($sql) {
    global $conn;
    try {
        $result = $conn->query($sql);
        if ($result === false) {
            throw new Exception("Query failed: " . $conn->error);
        }
        return $result;
    } catch (Exception $e) {
        error_log("Database Query Error: " . $e->getMessage());
        return false;
    }
}

// Function to handle search queries
function search_query($table, $fields, $search_term) {
    global $conn;
    $search_term = sanitize_input($search_term);
    $where_conditions = [];
    
    foreach ($fields as $field) {
        $where_conditions[] = "$field LIKE '%$search_term%'";
    }
    
    $where_clause = implode(" OR ", $where_conditions);
    $sql = "SELECT * FROM $table WHERE $where_clause";
    
    return safe_query($sql);
}
?> 