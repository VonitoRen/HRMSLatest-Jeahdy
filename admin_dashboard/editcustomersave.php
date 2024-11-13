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
$client_fname = $_POST['client_fname'];
$client_lname = $_POST['client_lname'];
$client_bdate = $_POST['client_bdate'];
$client_pnum = $_POST['client_pnum'];

// Update tbl_userclient
$sql = "UPDATE tbl_userclient 
        SET client_fname=?, client_lname=?, client_bdate=?, client_pnum=?
        WHERE client_id=?";
if ($stmt = $mySQL->prepare($sql)) {
    $stmt->bind_param("ssssi", $client_fname, $client_lname, $client_bdate, $client_pnum, $client_id);
    if ($stmt->execute()) {
        echo "Customer updated successfully";
    } else {
        echo "Error updating customer: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error preparing statement for updating customer: " . $mySQL->error;
}

$mySQL->close();
?>
