<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Add Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.17/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
    width: 900px; /* Set the desired width */
 
    margin: 150px auto; /* Center the container horizontally */
    padding: 100px;
    border: 1px solid #ccc;
    border-radius: 100px;
    background-color: #f9f9f9;
}

        .room {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #e7f4e4;
        }
        .unavailable {
            background-color: #f4e4e4;
        }
        .highlight {
            background-color: #87CEFA !important;
        }
    </style>
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
                                    <select class="form-control" id="room_type" name="room_type" onchange="fetchAvailableRooms()" required>
                                        <option value="">Select</option>
                                        <option value="Single">Single</option>
                                        <option value="Double">Double</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Members</label>
                                    <select class="form-control" id="total_members" name="total_members" required>
                                        <option value="">Select</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input type="text" class="form-control" id="usr1" readonly required>
                                </div>
                            </div>
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
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Check-in Date</label>
                                    <input type="text" class="form-control" id="checkin" name="checkin_date" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Check-out Date</label>
                                    <input type="text" class="form-control" id="checkout" name="checkout_date" required>
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
                }
            });

            // Initialize datepickers for check-in and check-out dates
            $('#checkin').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                startDate: '0d'
            });

            $('#checkout').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                startDate: '0d'
            });

            // Event listener to update total cost when dates are selected
            $('#checkin, #checkout').on('changeDate', function() {
                var checkinDate = $('#checkin').datepicker('getDate');
                var checkoutDate = $('#checkout').datepicker('getDate');
                calculateTotalCost(checkinDate, checkoutDate);
            });
        });

        function fetchClientName() {
            var clientId = $("#client_id").val();
            if (clientId && clientId !== 'Select Client ID') {
                $("#client_name").val('');
                $("#usr1").val('');
                $.ajax({
                    url: 'getclientname.php',
                    type: 'POST',
                    data: {
                        clientId: clientId
                    },
                    dataType: 'json',
                    success: function(response) {
                        $("#client_name").val(response.fullName);
                        $("#usr1").val(response.phoneNumber);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", xhr.responseText);
                    }
                });
            } else {
                $("#client_name").val('');
                $("#usr1").val('');
            }
        }

        function fetchAvailableRooms() {
            var roomType = $("#room_type").val();
            var acNonAc = $("#ac_non_ac").val();
            if (!roomType || roomType === '' || !acNonAc || acNonAc === '') {
                return;
            }
            $.ajax({
                url: 'getavailablerooms.php',
                type: 'POST',
                data: {
                    room_type: roomType,
                    ac_non_ac: acNonAc,
                    room_status: 'AVAILABLE'
                },
                dataType: 'json',
                success: function(response) {
                    $("#room_number").empty();
                    if (response.error) {
                        $("#room_number").append('<option value="">No Available Rooms</option>');
                    } else {
                        response.forEach(function(room) {
                            $('#room_number').append('<option value="' + room.room_id + '">' + room.room_number + '</option>');
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", xhr.responseText);
                }
            });
        }

        $('.buttonedit1').click(function() {
            var clientId = $("#client_id").val();
            var clientName = $("#client_name").val();
            var roomType = $("#room_type").val();
            var totalMembers = $("#total_members").val();
            var phoneNumber = $("#usr1").val();
            var acNonAc = $("#ac_non_ac").val();
            var roomNumber = $("#room_number").val();
            var additionalPillows = $("#additional_pillows").val();
            var additionalBlankets = $("#additional_blankets").val();
            var checkinDate = $("#checkin").val();
            var checkoutDate = $("#checkout").val();
            var totalCost = $("#total_cost").val();

            if (!clientId || clientId === 'Select Client ID' || !clientName || !roomType || !totalMembers || !phoneNumber || !acNonAc || !checkinDate || !checkoutDate || !roomNumber) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please fill in all fields!',
                });
                return;
            }

            Swal.fire({
                title: 'Confirm Booking Details',
                html: `<p>Client ID: ${clientId}</p><p>Client Name: ${clientName}</p><p>Room Type: ${roomType}</p><p>Total Members: ${totalMembers}</p><p>Phone Number: ${phoneNumber}</p><p>AC/Non-AC: ${acNonAc}</p><p>Check-in Date: ${checkinDate}</p><p>Check-out Date: ${checkoutDate}</p><p>Total Cost: ${totalCost}</p>`,
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
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
                            room_number: roomNumber,
                            add_pillow: additionalPillows,
                            add_blanket: additionalBlankets,
                            checkin_date: checkinDate,
                            checkout_date: checkoutDate,
                            total_cost: totalCost
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Booking Added',
                                text: response,
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }
                    });
                }
            });
        });

        function calculateTotalCost(startDate, endDate) {
            var basePrice = 0;
            var roomType = $("#room_type").val();
            var acNonAc = $("#ac_non_ac").val();
            if (roomType && acNonAc) {
                $.ajax({
                    url: 'getbaseprice.php',
                    type: 'POST',
                    data: {
                        room_type: roomType,
                        ac_non_ac: acNonAc
                    },
                    dataType: 'json',
                    async: false,
                    success: function(response) {
                        if (response.success) {
                            basePrice = parseFloat(response.base_price);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", xhr.responseText);
                    }
                });
            }

            var additionalPillows = parseInt($("#additional_pillows").val()) || 0;
            var additionalBlankets = parseInt($("#additional_blankets").val()) || 0;
            var pillowCost = 100;
            var blanketCost = 150;
            var additionalCost = (additionalPillows * pillowCost) + (additionalBlankets * blanketCost);
            if (acNonAc === "AC") {
                basePrice += 500;
            }

            if (startDate && endDate) {
                var timeDiff = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24));
                if (timeDiff > 0) {
                    var totalCost = (basePrice + additionalCost) * timeDiff;
                    $("#total_cost").val(totalCost.toFixed(2));
                    return totalCost;
                }
            }
            $("#total_cost").val('');
            return 0;
        }
    </script>
</body>
</html>
