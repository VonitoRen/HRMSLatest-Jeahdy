<?php
session_start();

// Check if the user is not logged in, redirect to login if so
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

// HTML for the dashboard goes here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Hotel Admin Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/ramdol.png">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">
	<link rel="stylesheet" href="assets/css/feathericon.min.css">
	<link rel="stylesheet" href="assets/plugins/morris/morris.css">
	<link rel="stylesheet" href="assets/css/style.css"> 
</head>

<body>
    <div class="main-wrapper">
        <?php include 'header.php'; ?>
        <?php include 'sidebar.php'; ?>
        <div id="content"> <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12 mt-5">
                        <?php include 'dashboardcontent.php'; ?>    
						</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                        
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>  <!-- pop ups -->
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/plugins/raphael/raphael.min.js"></script>
    <script src="assets/plugins/morris/morris.min.js"></script>
    <script src="assets/js/chart.morris.js"></script>
    <script src="assets/js/sidebar.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap Datepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.0.17/sweetalert2.min.js"></script>
    <!-- Datepicker Initialization -->
    <script>
        // Initialize datepicker for check-in date
        $('#checkin').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: '0d'
        });

        // Initialize datepicker for check-out date
        $('#checkout').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: '0d'
        });

        // Handle button click event
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

            // Finalize the booking with dates
            $.ajax({
                url: 'insertcheckinout.php',
                type: 'GET',
                data: {
                    checkin: checkinDate,
                    checkout: checkoutDate
                },
                success: function(response) {
                    // After successfully inserting check-in and check-out dates,
                    // call the calculateTotalBill.php script to calculate the total bill
                    $.ajax({
                        url: 'calculateTotalBill.php',
                        type: 'GET',
                        data: {
                            checkin: checkinDate,
                            checkout: checkoutDate
                        },
                        success: function(response) {
                            // Display the response, which contains the total bill
                            Swal.fire({
                                icon: 'success',
                                title: 'Total Bill',
                                html: response,
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
        });
    </script>
    
    <script>
     function loadAllBookingForm() {
        console.log('loadAllBookingForm() called');
        $.ajax({
            url: 'allbookingform.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data); 
            },
            error: function() {
                console.error('Error loading allbookingform.php');
            }
        });
    }
	
	
</script>
<script>
    function loadAddBookingForm() {
        console.log('loadAddBookingForm() called');
        $.ajax({
            url: 'addbookingform.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data); 
            },
            error: function() {
                console.error('Error loading addbookingform.php');
            }
        });
    }
	
</script>
<script>
    function loadEditBookingForm() {
        console.log('loadEditBookingForm() called');
        $.ajax({
            url: 'edit-booking.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data); 
            },
            error: function() {
                console.error('Error loading edit-booking.php'); 
            }
        });
    }
	
</script>

<script>
    function loadAddCustomerForm() {
        console.log('loadEditBookingForm() called');
        $.ajax({
            url: 'addcustomerform.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data); 
            },
            error: function() {
                console.error('Error loading add-customer.php');
            }
        });
    }
	
</script>
<script>
    function loadAllCustomerForm() {
        console.log('loadEditBookingForm() called');
        $.ajax({
            url: 'allcustomerform.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data); 
            },
            error: function() {
                console.error('Error loading add-customer.php');
            }
        });
    }
	
</script>

<script>
    function loadAddRoomForm() {
        console.log('loadEditBookingForm() called');
        $.ajax({
            url: 'addroomform.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data); 
            },
            error: function() {
                console.error('Error loading add-room.php');
            }
        });
    }
	
</script>
<script>
    function loadEditRoomForm() {
        console.log('loadEditBookingForm() called');
        $.ajax({
            url: 'edit-room.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data); 
            },
            error: function() {
                console.error('Error loading edit-room.php');
            }
        });
    }
	
</script>
<script>
    function loadAllRoomForm() {
        console.log('loadAllRoomsForm() called');
        $.ajax({
            url: 'allroomsform.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data); 
            },
            error: function() {
                console.error('Error loading allroomsform.php');
            }
        });
    }
	
</script>
<script>
    function loadPricingForm() {
        console.log('loadPricingForm() called');
        $.ajax({
            url: 'pricing.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data); 
            },
            error: function() {
                console.error('Error loading pricing.php');
            }
        });
    }
	
</script>

</script>
<script>
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
	
</script>
<script>
    function loadAllUserForm() {
        console.log('loadAddUserForm() called');
        $.ajax({
            url: 'alluserform.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data); 
            },
            error: function() {
                console.error('Error loading alluserform.php');
            }
        });
    }
	
</script>
<script>
    function loadEditUserForm() {
        console.log('loadEditUserForm() called');
        $.ajax({
            url: 'edituserform.php',
            type: 'GET',
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data); 
            },
            error: function() {
                console.error('Error loading edituserform.php');
            }
        });
    }
	
</script>
<script>
    function resetEditUserForm() {
    $('#user_id').prop('disabled', false); // Make User ID selectable
    $('#user_id').val(''); // Reset User ID value
    $('#user_id option[value=""]').text('Select User ID'); // Reset User ID placeholder text
    $('input, select').not('#user_id').prop('readonly', true); // Make all other fields readonly
    $('#staff_userlevel, #staff_status').prop('disabled', true); // Disable Role and Status select boxes
    $('#staff_userlevel, #staff_status').val('Select'); // Reset Role and Status select boxes
    $('#staff_firstname, #staff_lastname, #staff_username, #staff_email, #staff_phonenumber, #staff_joineddate').val(''); // Reset other input values
}


</script>
</body>

</html>

