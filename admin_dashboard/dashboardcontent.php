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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
                    <h3 class="page-title mt-3">Welcome Administrator!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card board1 fill">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <div>
                                <h3 class="card_widget_header"><?php echo $totalBookings; ?></h3>
                                <h6 class="text-muted">Total Bookings</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#710827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="8.5" cy="7" r="4"></circle>
                                        <line x1="20" y1="8" x2="20" y2="14"></line>
                                        <line x1="23" y1="11" x2="17" y2="11"></line>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card board1 fill">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <div>
                                <h3 class="card_widget_header"><?php echo $totalAvailableRooms; ?></h3>
                                <h6 class="text-muted">Available Rooms</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#710827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
                                        <line x1="12" y1="1" x2="12" y2="23"></line>
                                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card board1 fill">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <div>
                                <h3 class="card_widget_header"><?php echo $totalUsers; ?></h3>
                                <h6 class="text-muted">Total Users</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#710827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users">
                                        <path d="M17 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M9 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        <path d="M8 3.13a4 4 0 0 0 0 7.75"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card board1 fill">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <div>
                                <h3 class="card_widget_header"><?php echo $totalCustomers; ?></h3>
                                <h6 class="text-muted">Total Customers</h6>
                            </div>
                            <div class="ml-auto mt-md-3 mt-lg-0">
                                <span class="opacity-7 text-muted">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#710827" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="8.5" cy="7" r="4"></circle>
                                        <polyline points="17 11 19 13 23 9"></polyline>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
					<div class="col-md-12 col-lg-6">
						<div class="card card-chart">
							<div class="card-header">
								<h4 class="card-title">VISITORS</h4> </div>
							<div class="card-body">
								<div id="line-chart"></div>
							</div>
						</div>
					</div>

	<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms Chart</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
		.container{
			max-width: 500px;
		}
    </style>
</head>
<body>
<div class="container">
    <h2 class="mt-4 mb-4" style="text-align: center; font-weight: bold;">Rooms</h2>
    <!-- Adjust width and height of canvas to make the graph smaller -->
    <canvas id="pie-chart" width="150" height="150"></canvas>
</div>
<script>
     var ctx = document.getElementById('pie-chart').getContext('2d');
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Single Rooms', 'Double Rooms', 'Family Rooms'],
                datasets: [{
                    label: 'Number of Rooms',
                    data: [<?php echo $singleRooms; ?>, <?php echo $doubleRooms; ?>, <?php echo $familyRooms; ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)', // Red
                        'rgb(160, 50, 50)', // Maroon
                        'rgba(128, 0, 0, 0.5)'  // Green
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)', // Red
                        'rgba(54, 162, 235, 1)', // Blue
                        'rgba(75, 192, 192, 1)'  // Green
                    ],
                    borderWidth: 1
                }]
            },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

</div>
	</div>
</body>
</html>

					


    <script src="assets/js/chart.morris.js"></script>
</body>
</html>


   