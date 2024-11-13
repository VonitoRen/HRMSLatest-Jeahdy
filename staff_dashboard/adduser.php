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
$ifirstname = $_POST['staff_firstname'];
$ilastname = $_POST['staff_lastname'];
$iusername = $_POST['staff_username'];
$ipassword = $_POST['staff_password']; // assuming password is provided in the form
$iusertype = $_POST['staff_userlevel'];
$iemail = $_POST['staff_email'];
$iphonenumber = $_POST['staff_phonenumber'];
$istatus = isset($_POST['staff_status']) ? $_POST['staff_status'] : "ACTIVE";
$dt2 = date("Y-m-d H:i:s");

// Generating a new user ID
$sql_max_id = "SELECT MAX(id) AS max_id FROM tbl_user";
$result_max_id = $mySQL->query($sql_max_id);
$row_max_id = $result_max_id->fetch_assoc();
$max_id = $row_max_id['max_id'];
$new_id = $max_id + 1;

// Hashing the password
$hashed_password = password_hash($ipassword, PASSWORD_DEFAULT);

// Inserting into tbl_user
$sql_user = "INSERT INTO `tbl_user` (`id`, `username`, `password`, `userlevel`) VALUES (?, ?, ?, ?)";
if ($stmt_user = $mySQL->prepare($sql_user)) {
    $stmt_user->bind_param("isss", $new_id, $iusername, $hashed_password, $iusertype);
    if ($stmt_user->execute()) {
        echo "User inserted into tbl_user successfully";
        
        // Inserting into tbl_staff
        $sql_staff = "INSERT INTO `tbl_staff` (`staff_id`, `staff_firstname`, `staff_lastname`, `staff_username`, `staff_email`, `staff_phonenumber`, `staff_status`, `staff_joineddate`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        if ($stmt_staff = $mySQL->prepare($sql_staff)) {
            $stmt_staff->bind_param("isssssss", $new_id, $ifirstname, $ilastname, $iusername, $iemail, $iphonenumber, $istatus, $dt2);
            if ($stmt_staff->execute()) {
                echo "Staff member inserted into tbl_staff successfully";
            } else {
                echo "Error inserting into tbl_staff: " . $stmt_staff->error;
            }
            $stmt_staff->close();
        } else {
            echo "Error preparing statement for tbl_staff: " . $mySQL->error;
        }
    } else {
        echo "Error inserting into tbl_user: " . $stmt_user->error;
    }
    $stmt_user->close();
} else {
    echo "Error preparing statement for tbl_user: " . $mySQL->error;
}

$mySQL->close();
?>
