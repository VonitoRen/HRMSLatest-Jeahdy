<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_hotel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Queries to get the total counts
$totalBookingsQuery = "SELECT COUNT(*) AS total_bookings FROM tbl_reservation";
$totalAvailableRoomsQuery = "SELECT COUNT(*) AS total_available_rooms FROM tbl_room WHERE room_status='AVAILABLE'";
$totalUsersQuery = "SELECT COUNT(*) AS total_users FROM tbl_staff WHERE staff_status='ACTIVE'";
$totalCustomersQuery = "SELECT COUNT(*) AS total_customers FROM tbl_userclient";

// Execute the queries
$totalBookingsResult = $conn->query($totalBookingsQuery);
$totalAvailableRoomsResult = $conn->query($totalAvailableRoomsQuery);
$totalUsersResult = $conn->query($totalUsersQuery);
$totalCustomersResult = $conn->query($totalCustomersQuery);

// Fetch the results
$totalBookings = $totalBookingsResult->fetch_assoc()['total_bookings'];
$totalAvailableRooms = $totalAvailableRoomsResult->fetch_assoc()['total_available_rooms'];
$totalUsers = $totalUsersResult->fetch_assoc()['total_users'];
$totalCustomers = $totalCustomersResult->fetch_assoc()['total_customers'];

// Query to get the count of users booked single and double rooms
$singleRoomQuery = "SELECT COUNT(*) AS single_rooms FROM tbl_room WHERE room_type = 'Single'";
$doubleRoomQuery = "SELECT COUNT(*) AS double_rooms FROM tbl_room WHERE room_type = 'Double'";
$familyRoomQuery = "SELECT COUNT(*) AS family_rooms FROM tbl_room WHERE room_type = 'Family'";

// Execute the queries
$singleRoomResult = $conn->query($singleRoomQuery);
$doubleRoomResult = $conn->query($doubleRoomQuery);
$familyRoomResult = $conn->query($familyRoomQuery);

// Fetch the results
$singleRooms = $singleRoomResult->fetch_assoc()['single_rooms'];
$doubleRooms = $doubleRoomResult->fetch_assoc()['double_rooms'];
$familyRooms = $familyRoomResult->fetch_assoc()['family_rooms'];

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Dashboard</title>
   
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            text-align: center;
        }
        .page-title {
            color: #710827;
            margin-bottom: 5px;
            font-size: 28px;
            font-weight: bold;
        }
        .breadcrumb-item.active {
            color: #710827;
        }
        .card.board1.fill {
            -webkit-text-fill-color: #710827;
        }
        h4 {
            color: #710827;
        }
        .viewbutton {
            font-size: .9rem;
            background: #710827;
            border-color: #710827;
        }
    </style>
</head>
<body>
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12 mt-5">
                    <h3 class="page-title mt-3">Welcome Front Desk Staff!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        
</div>
	
</body>
</html>

					


    <script src="assets/js/chart.morris.js"></script>
</body>
</html>


   