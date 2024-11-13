<?php
session_start();

// Check if the user is already logged in, redirect to dashboard if so
if (isset($_SESSION['user_id'])) {
    header("Location: admin_dashboard/index.php");
    exit;
}
include_once('admin_dashboard/connection.php');

$user_id = 1; // Replace with the appropriate user ID

// New password to hash and store
$newPassword = 'nibba'; // Replace with the new plain-text password
$newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

// Update query
$sql = "UPDATE tbl_user SET password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $newHashedPassword);
$stmt->execute()

// HTML login form goes here
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://kit.fontawesome.com/0c3444f8ca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="CSS/login.css">
    <title>Login Form</title>
</head>
<body>
<div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="#">
			<h1>Create Account</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
			</div>
			<span>or use a username for registration</span>
			<input type="text" placeholder="Name" />
			<input type="text" placeholder="Username" />
			<input type="password" placeholder="Password" />
			<button>Sign Up</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="#" id="loginForm" method="POST">
			<h1>Log in</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
			</div>
			<span>or use your account</span>
			<input type="text" name="username" placeholder="Username" required />
			<input type="password" name="password" placeholder="Password" required />
			<a href="#">Forgot your password?</a>
			<button class="btn btn-primary btn-block" type="submit">Log in</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Join Us at Hotel Mikka!</h1>
				<p>Sign in to Hotel Mikka for personalized experiences</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Welcome to Hotel Mikka!</h1>
				<p>Let's start your extraordinary stay.</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Handle form submission
    $('#loginForm').submit(function(event) {
        // Prevent default form submission
        event.preventDefault();
        
        // Collect form data
        var formData = $(this).serialize();
        
        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: 'authentication.php',
            data: formData,
            success: function(response) {
                // Handle response from server
                if (response === 'success_admin') {
                    window.location.href = 'admin_dashboard/index.php'; // Redirect for admin
                } else if (response === 'success_staff') {
                    window.location.href = 'staff_dashboard/index.php'; // Redirect for staff
                } else {
                    // Show error message for other cases
                    Swal.fire({
                        icon: 'error',
                        title: 'Authentication Failed',
                        text: 'Invalid username or password. Please try again.',
                        showConfirmButton: true,
                        position: 'center',
                        customClass: {
                            popup: 'custom-swal-popup'
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request.',
                    showConfirmButton: true,
                    position: 'center',
                    customClass: {
                        popup: 'custom-swal-popup'
                    }
                });
            }
        });
    });
});
</script>
</body>
</html>
