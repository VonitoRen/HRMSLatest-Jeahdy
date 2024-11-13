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
$client_fname = $_POST['client_fname'];
$client_lname = $_POST['client_lname'];
$client_bdate = $_POST['client_bdate'];
$client_pnum = $_POST['client_pnum'];

// Generating a new client ID
$sql_max_id = "SELECT MAX(client_id) AS max_id FROM tbl_userclient";
$result_max_id = $mySQL->query($sql_max_id);
$row_max_id = $result_max_id->fetch_assoc();
$max_id = $row_max_id['max_id'];
$new_id = $max_id ? ($max_id + 1) : 5240000; // Start from 5240000 if no records exist
$new_client_id = str_pad($new_id, 8, '0', STR_PAD_LEFT); // Pad with zeros to make 8 digits

// Inserting into tbl_userclient
$sql_userclient = "INSERT INTO `tbl_userclient` (`client_id`, `client_fname`, `client_lname`, `client_bdate`, `client_pnum`) VALUES (?, ?, ?, ?, ?)";
if ($stmt_userclient = $mySQL->prepare($sql_userclient)) {
    $stmt_userclient->bind_param("sssss", $new_client_id, $client_fname, $client_lname, $client_bdate, $client_pnum);
    if ($stmt_userclient->execute()) {
        echo "Customer inserted into tbl_userclient successfully";
    } else {
        echo "Error inserting into tbl_userclient: " . $stmt_userclient->error;
    }
    $stmt_userclient->close();
} else {
    echo "Error preparing statement for tbl_userclient: " . $mySQL->error;
}

$mySQL->close();
?>
