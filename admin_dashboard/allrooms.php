<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "db_hotel";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to execute a query
function executeQuery($sql)
{
    global $conn;
    $result = $conn->query($sql);
    return $result;
}

// Fetch and display data
$sql = "SELECT * FROM tbl_room";
$result = executeQuery($sql);
?>