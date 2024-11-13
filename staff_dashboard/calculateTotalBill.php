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

    // Calculate the number of days between check-in and check-out dates
    $startDate = strtotime($checkinDate);
    $endDate = strtotime($checkoutDate);
    $daysDifference = ceil(abs($endDate - $startDate) / 86400);

    // Query to retrieve the total cost per day from tbl_reservation
    $query = "SELECT r.total_cost_per_day, c.checkinout_id FROM tbl_reservation r INNER JOIN tbl_checkinout c ON r.checkinout_id = c.checkinout_id WHERE c.checkin_date = ? AND c.checkout_date = ?";
    $statement = $connection->prepare($query);
    $statement->bind_param("ss", $checkinDate, $checkoutDate);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    $totalCostPerDay = $row['total_cost_per_day'];
    $checkinoutId = $row['checkinout_id'];

    // Calculate the total bill
    $totalBill = $totalCostPerDay * $daysDifference;

    // Update the corresponding row in tbl_reservation with the total bill
    $updateQuery = "UPDATE tbl_reservation SET totalBill = ? WHERE checkinout_id = ?";
    $updateStatement = $connection->prepare($updateQuery);
    $updateStatement->bind_param("di", $totalBill, $checkinoutId);
    if ($updateStatement->execute()) {
        // Total bill updated successfully
        echo "Completed!";
    } else {
        // Error occurred while updating total bill
        echo "Error: " . $updateStatement->error;
    }
    $updateStatement->close();
} else {
    // Data not received properly
    echo "Error: Incomplete data received!";
}

// Close connection
$connection->close();
?>
