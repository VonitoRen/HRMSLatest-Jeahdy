<?php
function fetchReservationDetails() {
    $servername = "localhost";
    $username = "root"; // Replace with your database username
    $password = ""; // Replace with your database password
    $dbname = "db_hotel"; // Replace with your database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM tbl_reservation ORDER BY reservation_id DESC";
    $result = $conn->query($sql);
    $reservations = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }
    }

    $conn->close();
    return $reservations;
}

// Debugging
$reservationDetails = fetchReservationDetails();
var_dump($reservationDetails); // Output fetched data for debugging
?>
