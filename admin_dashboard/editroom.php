<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_hotel';

// Create database connection
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch room data based on selected room ID
if (isset($_GET['room_id'])) {
    $roomId = $_GET['room_id'];

    // Prepare and execute SQL query to fetch room data
    $sql = "SELECT * FROM tbl_room WHERE room_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch and return room data as JSON response
        $roomData = $result->fetch_assoc();
        echo json_encode($roomData);
    } else {
        // No rows found with the given room ID
        echo json_encode(array('error' => 'Room not found'));
    }

    // Close prepared statement
    $stmt->close();
} else {
    // No room ID provided
    echo json_encode(array('error' => 'Missing room ID'));
}

// Close database connection
$conn->close();
?>
