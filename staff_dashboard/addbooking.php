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
$client_id = $_POST['client_id'];
$client_fullname = $_POST['client_fullname'];
$total_members = $_POST['total_members'];
$room_type = $_POST['room_type'];
$room_utility = $_POST['ac_non_ac']; // Assuming 'room_utility' corresponds to AC/Non-AC
$room_number = $_POST['room_number'];
$add_pillow = $_POST['additional_pillows'];
$add_blanket = $_POST['additional_blankets'];
$total_cost_per_day = $_POST['total_cost']; // Assuming you are passing the total cost from the form

// Fetching the maximum checkinout_id
$sql_max_id = "SELECT MAX(checkinout_id) AS max_id FROM tbl_reservation";
$result_max_id = $mySQL->query($sql_max_id);
$max_id = ($result_max_id->num_rows > 0) ? $result_max_id->fetch_assoc()['max_id'] : 0;

// If there are no existing records, default checkinout_id to 202400
if ($max_id == 0) {
    $new_checkinout_id = 1;
} else {
    // Incrementing the maximum checkinout_id by 1
    $new_checkinout_id = $max_id + 1;
}

// Inserting into tbl_reservation with auto-incremented checkinout_id
$sql_reservation = "INSERT INTO `tbl_reservation` (`client_id`, `client_fullname`, `total_members`, `room_type`, `room_utility`, `room_number`, `add_pillow`, `add_blanket`, `total_cost_per_day`, `checkinout_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
if ($stmt_reservation = $mySQL->prepare($sql_reservation)) {
    $stmt_reservation->bind_param("ssssssssdi", $client_id, $client_fullname, $total_members, $room_type, $room_utility, $room_number, $add_pillow, $add_blanket, $total_cost_per_day, $new_checkinout_id);
    $stmt_reservation->execute();
    $stmt_reservation->close();

    // Update the room status to "OCCUPIED"
    $sql_update_room_status = "UPDATE tbl_room SET room_status = 'OCCUPIED' WHERE room_id = ?";
    if ($stmt_update_room_status = $mySQL->prepare($sql_update_room_status)) {
        $stmt_update_room_status->bind_param("s", $room_number);
        $stmt_update_room_status->execute();
        $stmt_update_room_status->close();
    } else {
        echo "Error preparing statement for updating room status: " . $mySQL->error;
    }

    echo "Please Select Check-in Date and Check-out Date!";
} else {
    echo "Error preparing statement for tbl_reservation: " . $mySQL->error;
}

$mySQL->close();
?>
