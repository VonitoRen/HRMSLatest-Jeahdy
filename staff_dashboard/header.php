<?php

// Include the authentication file
include 'connection.php';
include '../authentication.php';

// Check if user is logged in
if (isset($_SESSION['username'])) {
    $loggedInUser = array(
        'name' => $_SESSION['username'],
        'user_level' => $_SESSION['user_level']
    );
}


?>

<style>
	.logoclass {
		color: #710827;
    font-size: 23px;
    font-weight: 600;
    margin-left: 4px;
	}
	.fe {
    display: inline-block;
    font: normal normal normal 16px feathericon;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
	color:#710827;
}
.header {
    left: 0;
    position: fixed;
    right: 0;
    top: 0;
    z-index: 1001;
    height: 80px;
    background-color: #ecdce0;
    padding: 0 10px 0 0;
    border-bottom: 1px solid #edf2f9;
}
.logoclass {
    color: #710827;
    font-size: 23px;
    font-weight: 600;
    margin-left: 4px;
}
</style>
<head>
<link rel="stylesheet" href="assets/css/style.css"> 
</head>
<div class="header">
			<div class="header-left">
				<a href="index.php" class="logo"> <img src="assets/img/Logofinalmikka.png" width="50" height="70" alt="logo"> <span class="logoclass">HOTEL</span> </a>
				<a href="index.php" class="logo logo-small"> <img src="assets/img/Logofinalmikka.png" alt="Logo" width="30" height="30"> </a>
			</div>
			<a href="javascript:void(0);" id="toggle_btn"> <i class="fe fe-text-align-left"></i> </a>
			<a class="mobile_btn" id="mobile_btn"> <i class="fas fa-bars"></i> </a>
			<ul class="nav user-menu">
				<li class="nav-item dropdown noti-dropdown">
					<div class="dropdown-menu notifications">
						<div class="topnav-dropdown-header"> <span class="notification-title">Notifications</span> <a href="javascript:void(0)" class="clear-noti"> Clear All </a> </div>
						<div class="noti-content">
							<ul class="notification-list">
								<li class="notification-message">
									<a href="#">
										<div class="media"> <span class="avatar avatar-sm">
											<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-18.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Carlson Tech</span> has approved <span class="noti-title">your estimate</span></p>
												<p class="noti-time"><span class="notification-time">4 mins ago</span> </p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="#">
										<div class="media"> <span class="avatar avatar-sm">
											<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-11.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">International Software
													Inc</span> has sent you a invoice in the amount of <span class="noti-title">$218</span></p>
												<p class="noti-time"><span class="notification-time">6 mins ago</span> </p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="#">
										<div class="media"> <span class="avatar avatar-sm">
											<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-17.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">John Hendry</span> sent a cancellation request <span class="noti-title">Apple iPhone
													XR</span></p>
												<p class="noti-time"><span class="notification-time">8 mins ago</span> </p>
											</div>
										</div>
									</a>
								</li>
								<li class="notification-message">
									<a href="#">
										<div class="media"> <span class="avatar avatar-sm">
											<img class="avatar-img rounded-circle" alt="User Image" src="assets/img/profiles/avatar-13.jpg">
											</span>
											<div class="media-body">
												<p class="noti-details"><span class="noti-title">Mercury Software
												Inc</span> added a new product <span class="noti-title">Apple
												MacBook Pro</span></p>
												<p class="noti-time"><span class="notification-time">12 mins ago</span> </p>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</div>
						<div class="topnav-dropdown-footer"> <a href="#">View all Notifications</a> </div>
					</div>
				</li>
				<li class="nav-item dropdown has-arrow">
					<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"> <span class="user-img"><img class="rounded-circle" src="assets/img/profiles/avatar-18.jpg" width="31" alt="Soeng Souy"></span> </a>
					<div class="dropdown-menu">
						<div class="user-header">
							<div class="avatar avatar-sm"> <img src="assets/img/profiles/avatar-18.jpg" alt="User Image" class="avatar-img rounded-circle"> </div>
							<div class="user-text">
							<h7><?php echo isset($loggedInUser['name']) ? $loggedInUser['name'] : 'Guest'; ?></h7> <!-- Dynamic user name -->
        <p class="text-muted mb-0"><?php echo isset($loggedInUser['user_level']) ? $loggedInUser['user_level'] : 'Guest'; ?></p> <!-- Dynamic user level -->
							</div>
						</div><a class="dropdown-item" href="logout.php">Logout</a>



				</li>
			</ul>
			<div class="top-nav-search">
				<form>
					
			
				</form>
			</div>
		</div>