<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Add User</title>
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
<body>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title mt-5">Add User</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form id="user_form">
                        <div class="row formtype">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input id="staff_firstname" name="staff_firstname" class="form-control" type="text" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input id="staff_lastname" name="staff_lastname" class="form-control" type="text" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input id="staff_username" name="staff_username" class="form-control" type="text" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input id="staff_email" name="staff_email" class="form-control" type="email" value="" required>
                                    <span id="email_validation_message" style="color: red;"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input id="staff_password" name="staff_password" class="form-control" type="password" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input id="staff_passwordconfirm" name="staff_passwordconfirm" class="form-control" type="password" value="" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input id="staff_phonenumber" name="staff_phonenumber" class="form-control" type="text" value=""  maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value = this.value.replace(/[^0-9]/g, '');" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" id="staff_userlevel" name="staff_userlevel" required>
                                        <option>Select</option>
                                        <option>Front Desk Staff</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <button type="button" onclick="submitForm()" class="btn btn-primary buttonedit">Add User</button>
        </div>
    </div>

    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <!-- Include other scripts as needed -->
    <script>
        document.getElementById('staff_email').addEventListener('input', function() {
            var emailInput = this.value;
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var validationMessage = document.getElementById('email_validation_message');
            
            if (emailInput === "") {
                // If the input is empty, remove the validation message
                validationMessage.textContent = '';
            } else {
                // If the input is not empty, validate the email format
                if (emailRegex.test(emailInput)) {
                    validationMessage.textContent = 'Valid email address';
                    validationMessage.style.color = 'green';
                } else {
                    validationMessage.textContent = 'Invalid email address';
                    validationMessage.style.color = 'red';
                }
            }
        });
    </script>
	<script>
    function submitForm() {
        // Check if all fields are filled
        var FirstName = $("#staff_firstname").val();
        var LastName = $("#staff_lastname").val();
        var username = $("#staff_username").val();
        var password = $("#staff_password").val();
        var repassword = $("#staff_passwordconfirm").val();
        var userType = $("#staff_userlevel").val();
        var phoneNumber = $("#staff_phonenumber").val();
        var email = $("#staff_email").val();

          // Validate email format
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        // Email is invalid, show an error alert
        Swal.fire({
            icon: 'error',
            title: 'Invalid Email Address',
            text: 'Please enter a valid email address.',
            showConfirmButton: true,
            position: 'center',
            customClass: {
                popup: 'custom-swal-popup'
            }
        });
        return; // Stop further execution
    }

        if (FirstName && LastName && username && password && repassword && userType && phoneNumber) {
            if (password === repassword) { // Check if passwords match
                // All fields are filled and passwords match, submit the form via AJAX
                $.ajax({
                    type: "POST",
                    url: "adduser.php",
                    data: $("#user_form").serialize(), // Serialize the form data
                    success: function(response) {
                        console.log("Success:", response);
                        // Clear the email input field
                        $("#staff_email").val('');
                        // Show the success alert with custom class
                        Swal.fire({
                            icon: 'success',
                            title: 'User Successfully Added',
                            showConfirmButton: false,
                            timer: 1500,
                            position: 'center',
                            customClass: {
                                popup: 'custom-swal-popup'
                            }
                        });

                        // Reset the form fields
                        resetForm();
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", xhr.responseText);
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
                // Passwords don't match, show an error alert
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'The entered passwords do not match. Please re-enter your password.',
                    showConfirmButton: true,
                    position: 'center',
                    customClass: {
                        popup: 'custom-swal-popup'
                    }
                });
            }
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

    function resetForm() {
       
        $("#user_form")[0].reset();
     
        document.getElementById('email_validation_message').textContent = '';
    }
</script>

</body>

</html>
