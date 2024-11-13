<?php
session_start();

// Include the database connection file
include 'admin_dashboard/connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to fetch user from the database
    $sql = "SELECT * FROM tbl_user WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Check if user exists
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Authentication successful, set session variables
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_level'] = $row['userlevel']; // Assuming this is user's level
                // Send success response based on user level
                if($_SESSION['user_level'] == 'Admin') {
                    echo 'success_admin'; // For admin
                    exit(); // Stop further execution
                } elseif($_SESSION['user_level'] == 'Front Desk Staff') {
                    echo 'success_staff'; // For staff
                    exit(); // Stop further execution
                }
            } else {
                // Incorrect password
                echo 'error'; // Send error response
                exit(); // Stop further execution
            }
        } else {
            // User not found
            echo 'error'; // Send error response
            exit(); // Stop further execution
        }
    } else {
        // Query error
        echo 'error'; // Send error response
        exit(); // Stop further execution
    }
}
?>