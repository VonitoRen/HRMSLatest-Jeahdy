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
$userid = $_POST['user_id'];
$ifirstname = $_POST['staff_firstname'];
$ilastname = $_POST['staff_lastname'];
$iusername = $_POST['staff_username'];
$iemail = $_POST['staff_email'];
$iphonenumber = $_POST['staff_phonenumber'];
$istatus = isset($_POST['staff_status']) ? $_POST['staff_status'] : "ACTIVE";
$iusertype = $_POST['staff_userlevel']; // Assuming you want to update userlevel

// Update tbl_staff
$sql_staff = "UPDATE tbl_staff SET staff_firstname=?, staff_lastname=?, staff_username=?, staff_email=?, staff_phonenumber=?, staff_status=? WHERE staff_id=?";
if ($stmt_staff = $mySQL->prepare($sql_staff)) {
    $stmt_staff->bind_param("ssssssi", $ifirstname, $ilastname, $iusername, $iemail, $iphonenumber, $istatus, $userid);
    if ($stmt_staff->execute()) {
        echo "Staff member updated in tbl_staff successfully";
        
        // Update tbl_user for userlevel
        $sql_userlevel = "UPDATE tbl_user SET userlevel=? WHERE id=?";
        if ($stmt_userlevel = $mySQL->prepare($sql_userlevel)) {
            $stmt_userlevel->bind_param("si", $iusertype, $userid);
            if ($stmt_userlevel->execute()) {
                echo "User level updated in tbl_user successfully";
                
                // Update username in tbl_user
                $sql_username = "UPDATE tbl_user SET username=? WHERE id=?";
                if ($stmt_username = $mySQL->prepare($sql_username)) {
                    $stmt_username->bind_param("si", $iusername, $userid);
                    if ($stmt_username->execute()) {
                        echo "Username updated in tbl_user successfully";
                    } else {
                        echo "Error updating username in tbl_user: " . $stmt_username->error;
                    }
                    $stmt_username->close();
                } else {
                    echo "Error preparing statement for updating username in tbl_user: " . $mySQL->error;
                }
            } else {
                echo "Error updating user level in tbl_user: " . $stmt_userlevel->error;
            }
            $stmt_userlevel->close();
        } else {
            echo "Error preparing statement for updating user level in tbl_user: " . $mySQL->error;
        }
    } else {
        echo "Error updating staff member in tbl_staff: " . $stmt_staff->error;
    }
    $stmt_staff->close();
} else {
    echo "Error preparing statement for tbl_staff: " . $mySQL->error;
}

$mySQL->close();
?>
