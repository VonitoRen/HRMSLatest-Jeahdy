<?php
// Database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "db_hotel";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the selected room type and AC/Non-AC option from the POST data
$roomType = $_POST['room_type'];
$acNonAc = $_POST['ac_non_ac'];

// Initialize the SQL query
$sql = "";

// Check if the selected room type is Single or Double and AC/Non-AC option is provided
if (($roomType == "Single" || $roomType == "Double" || $roomType == "Family") && ($acNonAc == "AC" || $acNonAc == "Non-AC")) {
    // Construct the SQL query to fetch available rooms of the selected type and AC/Non-AC option
    $sql = "SELECT room_id, room_number FROM tbl_room WHERE room_type = '$roomType' AND ac_non_ac = '$acNonAc' AND room_status = 'AVAILABLE'";
} else {
    // If the selected room type is not Single or Double, or AC/Non-AC option is not provided, indicate that the room is unavailable
    echo json_encode(array('error' => 'Room Unavailable'));
    exit; // Stop further execution
}

// Execute the SQL query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rooms = array();
    // Fetch room details and store in an array
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
    // Return JSON response containing available rooms
    echo json_encode($rooms);
} else {
    // No available rooms found
    echo json_encode(array());
}

// Close connection
$conn->close();
?>
