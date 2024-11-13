<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Check-in and Check-out</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.17/sweetalert2.min.css">
</head>

<body>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="mt-5">
                            <h4 class="card-title float-left mt-2">Select Check-in and Check-out Dates</h4>
                        </div>
                    </div>
                </div>
            </div>
            <form id="dateForm">
                <div class="form-group">
                    <label for="checkin">Check-in Date</label>
                    <input type="text" class="form-control" id="checkin" name="checkin" required>
                </div>
                <div class="form-group">
                    <label for="checkout">Check-out Date</label>
                    <input type="text" class="form-control" id="checkout" name="checkout" required>
                </div>
                <button type="button" class="btn btn-primary" id="confirmDatesButton">Confirm Dates</button>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.17/sweetalert2.min.js"></script>
    <!-- Datepicker Initialization -->
    <script>
    // Function to load the Reservation List Report in a new window
    function loadReservationListReport() {
        window.open('GenerateReceiptReport.php', '_blank');
    }
    function loadAddBookingForm() {
        $.ajax({
            url: 'addbookingform.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                $('#content').html(data); // Assuming you have a container with id 'content' where you want to load the form
            },
            error: function() {
                console.error('Error loading addbookingform.php');
            }
        });
    }
    // Initialize datepicker and handle button click event
    $(document).ready(function() {
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

        $('#confirmDatesButton').click(function() {
            var checkinDate = $('#checkin').val();
            var checkoutDate = $('#checkout').val();

            if (!checkinDate || !checkoutDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select both check-in and check-out dates!',
                });
                return;
            }

            $.ajax({
                url: 'insertcheckinout.php',
                type: 'GET',
                data: {
                    checkin: checkinDate,
                    checkout: checkoutDate
                },
                success: function(response) {
                    $.ajax({
                        url: 'calculateTotalBill.php',
                        type: 'GET',
                        data: {
                            checkin: checkinDate,
                            checkout: checkoutDate
                        },
                        success: function(totalBill) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Reservation Confirmation',
                                text: 'Reservation Status: ' + totalBill,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    loadReservationListReport(); // Open Reservation List Report
                                    loadAddBookingForm(); // Redirect to addbookingform.php
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong while calculating total bill!',
                            });
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong while finalizing booking!',
                    });
                }
            });
        });
    });
</script>
</body>

</html>
