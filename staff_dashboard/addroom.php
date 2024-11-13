<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_hotel';

$mySQL = new mysqli($host, $username, $password, $database);
if ($mySQL->connect_errno) {
    die("Connection failed: " . $mySQL->connect_error);
}

// Fetching form data
$room_type = $_POST['room_type'];
$ac_non_ac = $_POST['ac_non_ac'];
$bed_count = $_POST['bed_count'];
$price = $_POST['room_price']; // Corrected the field name here
$status = 'AVAILABLE'; // Assuming all newly added rooms are available

// Get the count of existing rooms
$sql_count = "SELECT COUNT(*) as room_count FROM `tbl_room`";
$result_count = $mySQL->query($sql_count);
if ($result_count && $row_count = $result_count->fetch_assoc()) {
    $room_id = $row_count['room_count'] + 1; // Increment the room ID
    $room_number = sprintf('%03d', $room_id); // Format room number as 001, 002, etc.
    
    // Inserting into tbl_room
    $sql_room = "INSERT INTO `tbl_room` (`room_id`, `room_number`, `room_type`, `ac_non_ac`, `room_capacity`, `room_price`, `room_status`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
    if ($stmt_room = $mySQL->prepare($sql_room)) {
        $stmt_room->bind_param("sssiis", $room_number, $room_type, $ac_non_ac, $bed_count, $price, $status);
        if ($stmt_room->execute()) {
            // Display success message
            echo json_encode(array("status" => "success", "message" => "Room added successfully."));
        } else {
            // Display error message
            echo json_encode(array("status" => "error", "message" => "Error adding room: " . $stmt_room->error));
        }
        $stmt_room->close();
    } else {
        // Display error message
        echo json_encode(array("status" => "error", "message" => "Error preparing statement for tbl_room: " . $mySQL->error));
    }
} else {
    // Display error message if unable to fetch room count
    echo json_encode(array("status" => "error", "message" => "Error fetching room count."));
}

$mySQL->close();
?>
