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

// Query to fetch all customer IDs from tbl_userclient
$sql = "SELECT client_id FROM tbl_userclient";
$result = $mysqli->query($sql);

// Check if query executed successfully
if ($result) {
    $customerIds = array();
    // Fetch each customer ID and add it to the array
    while ($row = $result->fetch_assoc()) {
        $customerIds[] = $row['client_id'];
    }
    // Convert array to JSON format and output
    echo json_encode($customerIds);
} else {
    echo "Error: " . $mysqli->error;
}

// Close database connection
$mysqli->close();
?>
