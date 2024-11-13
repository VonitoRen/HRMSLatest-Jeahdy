<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Edit User Form</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title mt-5">Edit Customer</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form id="customer_form">
                    <div class="row formtype">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Client ID</label>
                                <input class="form-control" id="client_id" name="client_id" type="text" value="" readonly required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>First Name</label>
                                <input id="client_fname" name="client_fname" class="form-control" type="text" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input id="client_lname" name="client_lname" class="form-control" type="text" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Birthdate</label>
                                <input id="client_bdate" name="client_bdate" class="form-control" type="date" value="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input id="client_pnum" name="client_pnum" class="form-control" type="text" value="" required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <button type="button" id="saveButton" class="btn btn-primary buttonedit">Save</button>
    </div>
</div>

<script>
$(document).ready(function() {
    // Fetch user data
    var clientId = <?php echo isset($_GET['client_id']) ? $_GET['client_id'] : 0; ?>;
    $.ajax({
        url: 'editcustomer.php',
        type: 'GET',
        data: { client_id: clientId },
        success: function(response) {
            var customerData = JSON.parse(response);
            // Populate form fields with customer data
            $('#client_id').val(customerData.client_id); // Set the client_id value
            $('#client_fname').val(customerData.client_fname);
            $('#client_lname').val(customerData.client_lname);
            $('#client_bdate').val(customerData.client_bdate);
            $('#client_pnum').val(customerData.client_pnum);
        },
        error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText);
            // Handle error
        }
    });

    // Attach click event listener to the "Save" button
    $('#saveButton').click(confirmUpdate);

    function confirmUpdate() {
        // Check if all required fields are filled
        var firstName = $("#client_fname").val();
        var lastName = $("#client_lname").val();
        var birthdate = $("#client_bdate").val();
        var phoneNumber = $("#client_pnum").val();

        if (!firstName || !lastName || !birthdate || !phoneNumber) {
            // Some fields are empty, show an error alert
            Swal.fire({
                icon: 'error',
                title: 'Please fill in all fields',
                showConfirmButton: false,
                timer: 2000,
                position: 'center'
            });
            return; // Exit the function early if any field is empty
        }

        // All required fields are filled, show the confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to update the customer information.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                submitForm();
            }
        });
    }

    function submitForm() {
        // All fields are filled, submit the form via AJAX
        $.ajax({
            type: "POST",
            url: "editcustomersave.php",
            data: $("#customer_form").serialize(),
            success: function(response) {
                console.log("Success:", response);
                // Show the success alert
                Swal.fire({
                    icon: 'success',
                    title: 'Customer Successfully Updated',
                    showConfirmButton: false,
                    timer: 1500,
                    position: 'center'
                }).then(() => {
                    // Redirect to allcustomerform.php after successful update
                    loadAllCustomerForm();
                });
            },
            error: function(xhr, status, error) {
                console.error("Error:", xhr.responseText);
                // Show an error alert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again later.',
                    showConfirmButton: true,
                    position: 'center'
                });
            }
        });
    }

    // Function to reload allcustomerform.php
    function loadAllCustomerForm() {
        $.ajax({
            url: 'allcustomerform.php',
            type: 'GET',
            success: function(data) {
                $('#content').html(data); // Assuming you have a div with id="content" to load the form
            },
            error: function() {
                console.error('Error loading allcustomerform.php');
            }
        });
    }
});
</script>
</body>
</html>
