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

// Fetch user data based on selected user ID
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Prepare and execute SQL query to fetch user data
    $sql = "SELECT s.staff_id, s.staff_firstname, s.staff_lastname, s.staff_username, s.staff_email, s.staff_phonenumber, s.staff_status, s.staff_joineddate, u.userlevel
            FROM tbl_staff s
            INNER JOIN tbl_user u ON s.staff_id = u.id
            WHERE s.staff_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch and return user data as JSON response
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        echo json_encode($userData);
    } else {
        echo json_encode(array()); // Return empty array if user not found
    }

    // Close prepared statement
    $stmt->close();
} else {
    echo json_encode(array('error' => 'Missing user ID')); // Handle missing user ID parameter
}

// Close database connection
$conn->close();
?>
