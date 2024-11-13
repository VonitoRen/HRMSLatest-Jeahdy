<?php
// Establish a database connection
$host = 'localhost';
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$database = 'db_hotel'; // Replace with your database name

$mySQL = new mysqli($host, $username, $password, $database);
if ($mySQL->connect_errno) {
    die("Connection failed: " . $mySQL->connect_error);
}

// Check if the client ID is provided via POST request
if (isset($_POST['clientId'])) {
    // Get the client ID from the POST data
    $clientId = $_POST['clientId'];

    // Prepare and execute the SQL query to fetch the client's first name, last name, and phone number based on the provided client ID
    $sql = "SELECT client_fname, client_lname, client_pnum FROM tbl_userclient WHERE client_id = ?";
    $stmt = $mySQL->prepare($sql);
    $stmt->bind_param("s", $clientId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the client's first name, last name, and phone number
        $row = $result->fetch_assoc();
        $firstName = $row['client_fname'];
        $lastName = $row['client_lname'];
        $phoneNumber = $row['client_pnum'];

        // Combine the first name and last name
        $fullName = $firstName . ' ' . $lastName;

        // Create an array to hold the full name and phone number
        $clientData = array(
            'fullName' => $fullName,
            'phoneNumber' => $phoneNumber
        );

        // Return the combined full name and phone number as JSON
        echo json_encode($clientData);
    } else {
        // If no rows were returned, return an empty response or an error message
        echo json_encode(array('error' => 'Client not found'));
    }

    // Close the statement and database connection
    $stmt->close();
} else {
    // If client ID is not provided, return an error message
    echo json_encode(array('error' => 'Client ID not provided'));
}

// Close the database connection
$mySQL->close();
?>
