<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>All Room</title>
</head>

<body>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="mt-5">
                            <h4 class="card-title float-left mt-2">All Rooms</h4>
                            <a href="#" onclick="loadAddUserForm()" class="btn btn-primary float-right veiwbutton">Add Room</a>
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
                                    <label>Room Number</label>
                                    <input class="form-control" type="text" id="roomNumberInput" oninput="filterRooms()">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Room Type</label>
                                    <select class="form-control" id="roomTypeInput" onchange="filterRooms()">
                                        <option value="">Select</option>
                                        <option value="Single">Single</option>
                                        <option value="Double">Double</option>
                                        <option value="Double">Family</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Room Status</label>
                                    <select class="form-control" id="roomStatusInput" onchange="filterRooms()">
                                        <option value="">Select</option>
                                        <option value="Occupied">Occupied</option>
                                        <option value="Vacant">Available</option>
                                    </select>
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
                                            <th>Room Number</th>
                                            <th>Room Type</th>
                                            <th>Room Utility</th>
                                            <th>Room Capacity</th>
                                            <th>Room Price</th>
                                            <th>Room Status</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <?php
                                        include("allrooms.php");
                                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                            // Handle form submission and apply filters
                                            $sql = handleFormSubmission();
                                        } else {
                                            // If the form is not submitted, retrieve all records from tbl_room
                                            $sql = "SELECT * FROM tbl_room";
                                        }
                                        // Execute the query and return the result set
                                        $result = executeQuery($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                // Output table rows for rooms
                                                echo "<tr>";
                                                echo "<td>{$row['room_id']}</td>";
                                                echo "<td>{$row['room_type']}</td>";
                                                echo "<td>{$row['ac_non_ac']}</td>";
                                                echo "<td>{$row['room_capacity']}</td>";
                                                echo "<td>{$row['room_price']}</td>";
                                                echo "<td>{$row['room_status']}</td>";
                                                echo "<td class='text-right'>";
                                                echo "<div class='dropdown dropdown-action'> <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='fas fa-ellipsis-v ellipse_color'></i></a>";
                                                echo "<div class='dropdown-menu dropdown-menu-right'> <a class='dropdown-item' href='#' onclick='loadEditRoomForm({$row['room_id']})'><i class='fas fa-pencil-alt m-r-5'></i> Edit</a> <a class='dropdown-item' href='#' data-toggle='modal' data-target='#delete_asset'><i class='fas fa-trash-alt m-r-5'></i> Delete</a> </div>";
                                                echo "</div>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            // No records found
                                            echo "<tr><td colspan='8'>No records found</td></tr>";
                                        }
                                        // Function to handle form submission and apply filters
                                        function handleFormSubmission()
                                        {
                                            global $conn;
                                            // Your logic for handling form submission goes here
                                            // Example: Construct SQL query based on form data
                                            $sql = "SELECT * FROM tbl_room WHERE 1";
                                            return $sql;
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
</body>
<script>
    // Function to handle dynamic filtering based on input values
    function filterRooms() {
        var roomNumber = $('#roomNumberInput').val().toLowerCase();
        var roomType = $('#roomTypeInput').val().toLowerCase();
        var roomStatus = $('#roomStatusInput').val().toLowerCase();
        // Filter table rows based on input values
        var found = false;
        $('#tableBody tr').each(function() {
            var row = $(this);
            var number = row.find('td:eq(0)').text().toLowerCase();
            var type = row.find('td:eq(1)').text().toLowerCase();
            var status = row.find('td:eq(5)').text().toLowerCase();
            var numberMatch = number.includes(roomNumber);
            var typeMatch = type.includes(roomType);
            var statusMatch = status.includes(roomStatus);
            // Show row only if all filters match
            var rowVisible = numberMatch && typeMatch && statusMatch;
            row.toggle(rowVisible);
            if (rowVisible) {
                found = true;
            }
        });
        // Show no records found message if no matches found
        $('#noRecords').toggle(!found);
    }
    function loadAddUserForm() {
        console.log('loadAddUserForm() called');
        $.ajax({
            url: 'adduserform.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data);
            },
            error: function() {
                console.error('Error loading adduser.php');
            }
        });
    }
    function loadEditRoomForm(roomId) {
        console.log('loadEditRoomForm() called with roomId:', roomId);
        $.ajax({
            url: 'editroomform.php?room_id=' + roomId, // Pass room ID as a parameter
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data);
                // Update the value of the readonly input field with the fetched room ID
                $('#room_id').val(roomId);
                // Disable editing for the readonly input field
                $('#room_id').prop('readonly', true);
            },
            error: function() {
                console.error('Error loading editroomform.php');
            }
        });
    }
</script>

</html>
