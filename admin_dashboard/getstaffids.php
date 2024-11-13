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

// Query to fetch all staff IDs from tbl_staff
$sql = "SELECT staff_id FROM tbl_staff";
$result = $mysqli->query($sql);

// Check if query executed successfully
if ($result) {
    $staffIds = array();
    // Fetch each staff ID and add it to the array
    while ($row = $result->fetch_assoc()) {
        $staffIds[] = $row['staff_id'];
    }
    // Convert array to JSON format and output
    echo json_encode($staffIds);
} else {
    echo "Error: " . $mysqli->error;
}

// Close database connection
$mysqli->close();
?>
