<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_hotel';

// Establishing a connection to the database
$mySQL = new mysqli($host, $username, $password, $database);
if ($mySQL->connect_errno) {
    die("Connection failed: " . $mySQL->connect_error);
}

// Fetching form data
$room_id = $_POST['room_id'];
$room_type = $_POST['room_type'];
$ac_non_ac = $_POST['ac_non_ac'];
$room_capacity = $_POST['room_capacity'];
$room_price = $_POST['room_price'];

// Update tbl_room
$sql = "UPDATE tbl_room 
        SET room_type=?, ac_non_ac=?, room_capacity=?, room_price=?
        WHERE room_id=?";
if ($stmt = $mySQL->prepare($sql)) {
    $stmt->bind_param("sssdi", $room_type, $ac_non_ac, $room_capacity, $room_price, $room_id);
    if ($stmt->execute()) {
        echo "Room updated successfully";
    } else {
        echo "Error updating room: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error preparing statement for updating room: " . $mySQL->error;
}

// Closing database connection
$mySQL->close();
?>
