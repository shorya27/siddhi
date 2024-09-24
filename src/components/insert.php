<?php
// Database configuration
require_once 'config.php';

// Allow from any origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Check for preflight (OPTIONS) request and handle it
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize input
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
    $notes = filter_input(INPUT_POST, 'notes', FILTER_SANITIZE_STRING);

    // Validate required fields
    if (!$name || !$address || !$phone || $age === false) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing or invalid required fields']);
        exit();
    }

    try {
        // Create a connection to the MySQL database
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Check if the connection was successful
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }

        // Prepare an SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO siddhi (name, address, phone, age, notes) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", $name, $address, $phone, $age, $notes);

        // Execute the query
        if (!$stmt->execute()) {
            throw new Exception("Error executing query: " . $stmt->error);
        }

        // Close the statement and the connection
        $stmt->close();
        $conn->close();

        // Send success response
        http_response_code(200);
        echo json_encode(['message' => 'Data inserted successfully']);
    } catch (Exception $e) {
        // Log the error (in a production environment, use proper logging)
        error_log($e->getMessage());

        // Send error response
        http_response_code(500);
        echo json_encode(['error' => 'An error occurred while processing your request']);
    }
} else {
    // Method not allowed
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>