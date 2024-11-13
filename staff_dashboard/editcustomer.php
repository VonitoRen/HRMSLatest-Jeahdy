<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_hotel';

// Create database connection
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch customer data based on selected customer ID
if (isset($_GET['client_id'])) {
    $clientId = $_GET['client_id'];

    // Prepare and execute SQL query to fetch customer data
    $sql = "SELECT client_id, client_fname, client_lname, client_bdate, client_pnum
            FROM tbl_userclient
            WHERE client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clientId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch and return customer data as JSON response
    if ($result->num_rows > 0) {
        $customerData = $result->fetch_assoc();
        echo json_encode($customerData);
    } else {
        echo json_encode(array('error' => 'Customer not found'));
    }

    // Close prepared statement
    $stmt->close();
} else {
    echo json_encode(array('error' => 'Missing customer ID')); // Handle missing customer ID parameter
}

// Close database connection
$conn->close();
?>