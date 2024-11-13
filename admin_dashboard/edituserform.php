<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>Edit User</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<div class="page-wrapper">
<div class="content container-fluid">
<div class="page-header">
<div class="row align-items-center">
<div class="col">
<h3 class="page-title mt-5">Edit User</h3>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<form id="user_form">
<div class="row formtype">
    
<div class="col-md-4">
<div class="form-group">
<label>User ID</label>
<input class="form-control" id="user_id" name="user_id" type="text" value="" readonly required>
</div>
</div>
<div class="col-md-4">
<div class="form-group">
<label>First Name</label>
<input id="staff_firstname" name="staff_firstname" class="form-control" type="text" value="" readonly required>
</div>
</div>
<div class="col-md-4">
<div class="form-group">
<label>Last Name</label>
<input id="staff_lastname" name="staff_lastname" class="form-control" type="text" value="" readonly required>
</div>
</div>
<div class="col-md-4">
<div class="form-group">
<label>User Name</label>
<input id="staff_username" name="staff_username" class="form-control" type="text" value="" readonly required>
</div>
</div>
<div class="col-md-4">
<div class="form-group">
<label>Email</label>
<input id="staff_email" name="staff_email" class="form-control" type="email" value="" readonly required>
</div>
</div>
<div class="col-md-4">
<div class="form-group">
<label>Phone Number</label>
<input id="staff_phonenumber" name="staff_phonenumber" class="form-control" type="text" value="" readonly required>
</div>
</div>
<div class="col-md-4">
<div class="form-group">
<label>Role</label>
<select class="form-control" id="staff_userlevel" name="staff_userlevel" disabled required>
<option disabled selected>Select</option>
    <option>Front Desk Staff</option>
    <option>Admin</option>
</select>
</div>
</div>
<div class="col-md-4">
<div class="form-group">
<label>Status</label>
<select class="form-control" id="staff_status" name="staff_status" disabled required>
<option disabled selected>Select</option>
    <option value="ACTIVE">Active</option>
    <option value="DEACTIVATE">Deactivate</option>
</select>
</div>
</div>
</div>
</form>
</div>
</div>
<button type="button" class="btn btn-primary buttonedit" onclick="confirmUpdate()">Save</button>

</div>
</div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Add SweetAlert JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script>
    


function enableEditing(userId) {
    $('input,select').prop('readonly', false);
    $('#staff_userlevel').prop('disabled', false);
    $('#staff_status').prop('disabled', false);
    // Disable editing for User ID field
    $('#user_id').prop('readonly', true);
    
    // Fetch user data
    $.ajax({
        url: 'edituser.php',
        type: 'GET',
        data: { user_id: userId },
        success: function(response) {
            var userData = JSON.parse(response);
            // Populate form fields with user data
            $('#staff_firstname').val(userData.staff_firstname);
            $('#staff_lastname').val(userData.staff_lastname);
            $('#staff_username').val(userData.staff_username);
            $('#staff_email').val(userData.staff_email);
            $('#staff_phonenumber').val(userData.staff_phonenumber);
            $('#staff_status').val(userData.staff_status);
            
            // Populate Role dropdown with user level fetched from database
            $('#staff_userlevel').val(userData.userlevel);
        },
        error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText);
            // Handle error
        }
    });
}

function confirmUpdate() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to update the user information.',
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
    // Check if all fields are filled
    var FirstName = $("#staff_firstname").val();
    var LastName = $("#staff_lastname").val();
    var username = $("#staff_username").val();
    var phoneNumber = $("#staff_phonenumber").val();
    var userType = $("#staff_userlevel").val();

    if (FirstName && LastName && username && phoneNumber && userType) {
        // All fields are filled, submit the form via AJAX
        $.ajax({
            type: "POST",
            url: "editusersave.php",
            data: $("#user_form").serialize(), // Serialize the form data
            success: function(response) {
                // Show the success alert with custom class
                Swal.fire({
                    icon: 'success',
                    title: 'User Successfully Updated',
                    showConfirmButton: false,
                    timer: 1500,
                    position: 'center',
                    customClass: {
                        popup: 'custom-swal-popup'
                    }
                }).then(() => {
                    // Redirect to alluserform.php after successful update
                    loadAllUserForm();
                });
            },
            error: function(xhr, status, error) {
                // Show an error alert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again later.',
                    showConfirmButton: true,
                    position: 'center',
                    customClass: {
                        popup: 'custom-swal-popup'
                    }
                });
            }
        });
    } else {
        // Some fields are empty, show an error alert
        Swal.fire({
            icon: 'error',
            title: 'Please fill in all fields',
            showConfirmButton: false,
            timer: 2000,
            position: 'center',
            customClass: {
                popup: 'custom-swal-popup'
            }
        });
    }
}

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

</body>
</html>
