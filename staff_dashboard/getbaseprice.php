<?php
// Database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "db_hotel";

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, show error message
    die("Connection failed: " . $e->getMessage());
}

// Check if room_type and ac_non_ac parameters are set
if (isset($_POST['room_type']) && isset($_POST['ac_non_ac'])) {
    // Sanitize input
    $roomType = $_POST['room_type'];
    $acNonAc = $_POST['ac_non_ac'];

    try {
        // Prepare and execute query to fetch base price from tbl_room
        $query = "SELECT room_price FROM tbl_room WHERE room_type = ? AND ac_non_ac = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$roomType, $acNonAc]);

        // Fetch base price from database
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        // Check if result is not empty
        if ($result) {
            // Return base price as JSON
            echo json_encode(['success' => true, 'base_price' => $result['room_price']]);
        } else {
            // If no result found, return error message
            echo json_encode(['success' => false, 'message' => 'Base price not found']);
        }
    } catch (PDOException $e) {
        // If an error occurs during database query, return error message
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // If room_type and ac_non_ac parameters are not set, return error message
    echo json_encode(['success' => false, 'message' => 'Room type and AC/Non-AC parameters are required']);
}
?>
