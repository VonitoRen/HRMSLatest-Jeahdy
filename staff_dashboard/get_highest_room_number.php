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

// SQL query to get the highest room number from tbl_room
$sql = "SELECT MAX(room_id) AS highest_room_number FROM tbl_room";

// Execute the query
$result = $mysqli->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Get the highest room number
    $highestRoomNumber = $row['highest_room_number'];

    // Check if there are no records in the table
    if ($highestRoomNumber === null) {
        // If there are no records, set the room number to '001'
        $highestRoomNumber = '000';
    }

    // Output the highest room number
    echo $highestRoomNumber;
} else {
    // If the query fails, output an error message
    echo "Error: " . $mysqli->error;
}

// Close the connection
$mysqli->close();
?>
