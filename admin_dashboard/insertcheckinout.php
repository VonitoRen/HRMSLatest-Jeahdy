<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "db_hotel";

// Create connection
$connection = new mysqli($host, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Check if the required data is received
if(isset($_GET['checkin']) && isset($_GET['checkout'])) {
    // Get the data from the request
    $checkinDate = $_GET['checkin'];
    $checkoutDate = $_GET['checkout'];

    // Get the maximum checkinout_id from the table
    $maxIdQuery = "SELECT MAX(checkinout_id) AS max_id FROM tbl_checkinout";
    $maxIdResult = $connection->query($maxIdQuery);
    if ($maxIdResult && $maxIdResult->num_rows > 0) {
        $row = $maxIdResult->fetch_assoc();
        $nextId = $row['max_id'] + 1;
    } else {
        // If there are no existing records, start with 1
        $nextId = 2024001;
    }

    // Insert the data into the database table tbl_checkinout
    $insertQuery = "INSERT INTO tbl_checkinout (checkinout_id, checkin_date, checkout_date) VALUES (?, ?, ?)";
    $statement = $connection->prepare($insertQuery);
    // Bind parameters to the query
    $statement->bind_param("iss", $nextId, $checkinDate, $checkoutDate);
    // Execute the query
    if ($statement->execute()) {
        // Data inserted successfully
        echo "Check-in and Check-out details saved successfully! checkinout_id: " . $nextId;
    } else {
        // Error occurred while inserting data
        echo "Error: " . $statement->error;
    }
} else {
    // Data not received properly
    echo "Error: Incomplete data received!";
}

// Close connection
$connection->close();
?>
