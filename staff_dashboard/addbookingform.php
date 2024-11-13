<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Add Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.17/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>

<body>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title mt-5">Add Booking</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form id="bookingForm">
                        <div class="row formtype">
                            <div class="col-md-4">
                                <label>Client ID</label>
                                <select class="form-control" id="client_id" name="client_id" onchange="fetchClientName()" required>
                                    <option value="">Select Client ID</option>
                                    <!-- Client IDs will be populated dynamically from getclientids.php -->
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" id="client_name" readonly required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Room Type</label>
                                    <select class="form-control" id="room_type" name="room_type" onchange="updateTotalMembers()" required>
                                        <option value="">Select</option>
                                        <option value="Single">Single</option>
                                        <option value="Double">Double</option>
                                        <option value="Family">Family</option> <!-- Added Family option -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Members</label>
                                    <input type="text" class="form-control" id="total_members" readonly required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" id="usr1" readonly required>
                                </div>
                            </div>
                            <!-- New elements -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>AC/Non-AC</label>
                                    <select class="form-control" id="ac_non_ac" name="ac_non_ac" onchange="fetchAvailableRooms()" required>
                                        <option value="">Select</option>
                                        <option value="AC">AC</option>
                                        <option value="Non-AC">Non-AC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Room Number</label>
                                    <select class="form-control" id="room_number" name="room_number" required>
                                        <!-- Room numbers will be populated dynamically based on selected room type and AC/Non-AC -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Additional Pillows</label>
                                    <select class="form-control" id="additional_pillows">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <!-- Add more options if needed -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Additional Blankets</label>
                                    <select class="form-control" id="additional_blankets">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <!-- Add more options if needed -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Cost</label>
                                    <input type="text" class="form-control" id="total_cost" readonly>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <button type="button" class="btn btn-primary buttonedit1">Create Booking</button>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.17/sweetalert2.min.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- Your JavaScript code -->
    <script>
        $(document).ready(function() {
            // Fetch client IDs from getclientids.php and populate the Client ID select field
            $.ajax({
                url: 'getclientids.php',
                type: 'GET',
                success: function(response) {
                    var clientIds = JSON.parse(response);
                    clientIds.forEach(function(clientId) {
                        $('#client_id').append('<option value="' + clientId + '">' + clientId + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", xhr.responseText);
                    // Handle error
                }
            });
        });

        function fetchClientName() {
            var clientId = $("#client_id").val();
            if (clientId && clientId !== 'Select Client ID') {
                // Clear the name and phone number fields
                $("#client_name").val('');
                $("#usr1").val('');

                // Fetch and populate client name and phone number
                $.ajax({
                    url: 'getclientname.php',
                    type: 'POST',
                    data: {
                        clientId: clientId
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Set the client name and phone number fields with the fetched data
                        $("#client_name").val(response.fullName);
                        $("#usr1").val(response.phoneNumber);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", xhr.responseText);
                        // Handle error	
                    }
                });
            } else {
                // Clear the name and phone number fields when "Select Client ID" is chosen
                $("#client_name").val('');
                $("#usr1").val('');
            }
        }

        function fetchAvailableRooms() {
            // Get the selected room type
            var roomType = $("#room_type").val();
            // Get the selected AC/Non-AC option
            var acNonAc = $("#ac_non_ac").val();

            // Ensure both room type and AC/Non-AC option are selected
            if (!roomType || roomType === '' || !acNonAc || acNonAc === '') {
                return;
            }

            // Fetch available room numbers based on availability status, room type, and AC/Non-AC option
            $.ajax({
                url: 'getavailablerooms.php',
                type: 'POST',
                data: {
                    room_type: roomType,
                    ac_non_ac: acNonAc,
                    room_status: 'AVAILABLE' // Add room status parameter
                },
                dataType: 'json',
                success: function(response) {
                    // Clear previous options
                    $("#room_number").empty();

                    // If no rooms are available for the selected criteria
                    if (response.error) {
                        // Show a message indicating that no rooms are available
                        $("#room_number").append('<option value="">No Available Rooms</option>');
                    } else {
                        // Populate room numbers
                        response.forEach(function(room) {
                            $('#room_number').append('<option value="' + room.room_id + '">' + room.room_number + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", xhr.responseText);
                    // Handle error
                }
            });
        }

        function updateTotalMembers() {
            var roomType = $("#room_type").val();
            var totalMembers = 1; // Default value for Single room type
            if (roomType === 'Double') {
                totalMembers = 2;
            } else if (roomType === 'Family') {
                totalMembers = 3;
            }
            $("#total_members").val(totalMembers);
        }

        // Function to handle the button click event
        $('.buttonedit1').click(function() {
            // Get the form data
            var clientId = $("#client_id").val();
            var clientName = $("#client_name").val();
            var roomType = $("#room_type").val();
            var totalMembers = $("#total_members").val();
            var phoneNumber = $("#usr1").val();
            var acNonAc = $("#ac_non_ac").val();
            var roomNumber = $("#room_number").val(); // Include room number
            var additionalPillows = $("#additional_pillows").val(); // Include additional pillows
            var additionalBlankets = $("#additional_blankets").val(); // Include additional blankets

            // Validate form fields
            if (!clientId || clientId === 'Select Client ID' || !clientName || !roomType || !totalMembers || !phoneNumber || !acNonAc) {
                // Show error message if any field is empty
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in all fields!',
                });
                return;
            }

            // Fetch base price from database
            $.ajax({
                url: 'getbaseprice.php',
                type: 'POST',
                data: {
                    room_type: roomType,
                    ac_non_ac: acNonAc
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        var basePrice = parseFloat(response.base_price); // Parse the base price as float
                        // Calculate total cost including additional amenities
                        var totalCost = calculateTotalCost(basePrice);
                        // Show confirmation dialog
                        Swal.fire({
                            title: 'Confirm Booking Details',
                            html: `<p>Client ID: ${clientId}</p><p>Client Name: ${clientName}</p><p>Room Type: ${roomType}</p><p>Total Members: ${totalMembers}</p><p>Phone Number: ${phoneNumber}</p><p>AC/Non-AC: ${acNonAc}</p><p>Room Number: ${roomNumber}</p><p><strong>Total Cost: ${totalCost}</strong></p>`, // Include room number and bold total cost
                            showCancelButton: true,
                            confirmButtonText: 'Confirm',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Submit form data to addbooking.php
                                $.ajax({
                                    url: 'addbooking.php',
                                    type: 'POST',
                                    data: {
                                        client_id: clientId,
                                        client_fullname: clientName,
                                        room_type: roomType,
                                        total_members: totalMembers,
                                        client_pnum: phoneNumber,
                                        ac_non_ac: acNonAc,
                                        room_number: roomNumber, // Include room number
                                        additional_pillows: additionalPillows, // Include additional pillows
                                        additional_blankets: additionalBlankets, // Include additional blankets
                                        total_cost: totalCost
                                    },
                                    success: function(response) {
                                        // Show success message
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Proceed to the next step',
                                            text: response,
                                        });
                                        // Load check_in_out.php with the client_id
                                        loadCheckInOutPage(clientId);
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Error:", xhr.responseText);
                                        // Show error message
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Something went wrong!',
                                        });
                                    }
                                });
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to fetch base price!',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", xhr.responseText);
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    });
                }
            });
        });

        function calculateTotalCost(basePrice) {
            // Get the selected AC/Non-AC option
            var acNonAc = $("#ac_non_ac").val();

            // Additional costs for pillows and blankets
            var additionalPillows = parseInt($("#additional_pillows").val()) || 0;
            var additionalBlankets = parseInt($("#additional_blankets").val()) || 0;
            var pillowCost = 100;
            var blanketCost = 150;

            // Calculate additional cost for amenities
            var additionalCost = (additionalPillows * pillowCost) + (additionalBlankets * blanketCost);

            // Adjust base price based on AC/Non-AC option
            if (acNonAc === "AC") {
                basePrice += 500;
            } else if (acNonAc === "Non-AC") {
                // If Non-AC is selected, there's no additional charge
                // Do nothing here
            }

            // Calculate total cost
            var totalCost = basePrice + additionalCost;

            // Update total cost field
            $("#total_cost").val(totalCost.toFixed(2)); // Ensure the total cost is formatted to two decimal places

            return totalCost;
        }

        function loadCheckInOutPage(clientId) {
            $.ajax({
                url: 'check_in_out.php',
                type: 'GET',
                data: { client_id: clientId }, // Pass the client_id as a parameter
                dataType: 'html',
                success: function(data) {
                    $('#content').html(data);
                },
                error: function() {
                    console.error('Error loading check_in_out.php');
                }
            });
        }
    </script>
</body>

</html>
