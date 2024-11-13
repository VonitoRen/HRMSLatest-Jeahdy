<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>List of Bookings</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <div class="mt-5">
                        <h4 class="card-title float-left mt-2">All Bookings</h4>
                        <a href="#" onclick="loadAddBookingForm()" class="btn btn-primary float-right veiwbutton">Add Booking</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form>
                    <div class="row formtype">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Booking ID</label>
                                <input class="form-control" type="text" id="bookingIdInput" oninput="filterBookings()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Customer Name</label>
                                <input class="form-control" type="text" id="customerNameInput" oninput="filterBookings()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Search</label>
                                <a href="#" class="btn btn-success btn-block mt-0 search_button"> Search </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card card-table">
                    <div class="card-body booking_card">
                        <div class="table-responsive">
                            <table class="datatable table table-stripped table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Customer Name</th>
                                        <th>Room Type</th>
                                        <th>Total Members</th>
										<th>Room Utility</th>
										<th>Room Number</th>
										<th>Additiona Pillow</th>
										<th>Additiona Blanket</th>
										<th>Total Cost Per Day</th>
                                        <th>Total Bill</th>
                                        <th>Actions</th> 
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <?php
                                   include ("allbooking.php");
                                    // Assuming you have a $conn variable representing the database connection

                                    // Fetch booking data from the database
                                    $sql = "SELECT * FROM tbl_reservation";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>{$row['reservation_id']}</td>";
                                            echo "<td>{$row['client_fullname']}</td>";
                                            echo "<td>{$row['room_type']}</td>";
                                            echo "<td>{$row['total_members']}</td>";
                                            echo "<td>{$row['room_utility']}</td>";
                                            echo "<td>{$row['room_number']}</td>";
                                            echo "<td>{$row['add_pillow']}</td>";
                                            echo "<td>{$row['add_blanket']}</td>";
                                            echo "<td>{$row['total_cost_per_day']}</td>";
                                            echo "<td>{$row['totalBill']}</td>";
                                            echo "<td class='text-right'>";
											echo "<div class='dropdown dropdown-action'> <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='fas fa-ellipsis-v ellipse_color'></i></a>";
											echo "<div class='dropdown-menu dropdown-menu-right'> <a class='dropdown-item' href='#' onclick='loadEditBookingForm({$row['client_id']})'><i class='fas fa-pencil-alt m-r-5'></i> Edit</a> <a class='dropdown-item' href='#' onclick='deleteCustomer({$row['client_id']})'><i class='fas fa-trash-alt m-r-5'></i> Delete</a> </div>";
											echo "</div>";
											echo "</td>";
											echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7'>No bookings found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div id="noRecords" style="display: none; text-align: center; margin-top: 10px;">No records found</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Function to handle dynamic filtering based on input values
    function filterBookings() {
        var bookingId = $('#bookingIdInput').val().toLowerCase();
        var customerName = $('#customerNameInput').val().toLowerCase();

        // Filter table rows based on input values
        var found = false;
        $('#tableBody tr').each(function() {
            var row = $(this);
            var id = row.find('td:eq(0)').text().toLowerCase(); // Assuming Booking ID is the first column
            var name = row.find('td:eq(1)').text().toLowerCase(); // Assuming Customer Name is the second column

            var idMatch = id.includes(bookingId);
            var nameMatch = name.includes(customerName);

            // Show row only if all filters match
            var rowVisible = idMatch && nameMatch;
            row.toggle(rowVisible);
            if (rowVisible) {
                found = true;
            }
        });

        // Show no records found message if no matches found
        $('#noRecords').toggle(!found);
    }
</script>
</body>
</html>
