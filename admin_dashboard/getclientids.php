<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_hotel';

// Establish database connection
$mysqli = new mysqli($host, $username, $password, $database);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query to fetch all client IDs from tbl_userclient that are not already booked
$sql = "SELECT u.client_id FROM tbl_userclient u LEFT JOIN tbl_reservation r ON u.client_id = r.client_id WHERE r.client_id IS NULL";
$result = $mysqli->query($sql);

// Check if query executed successfully
if ($result) {
    $clientIds = array();
    // Fetch each client ID and add it to the array
    while ($row = $result->fetch_assoc()) {
        $clientIds[] = $row['client_id'];
    }
    // Convert array to JSON format and output
    echo json_encode($clientIds);
} else {
    echo "Error: " . $mysqli->error;
}

// Close database connection
$mysqli->close();
?>
