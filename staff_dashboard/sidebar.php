<style>
    .sidebar-menu li.active a {
    border-radius: 8px;
    box-shadow: 0 7px 12px 0 rgba(95,118,232,.21);
    opacity: 1;
    background: #710827;
}
.sidebar-menu li a {
    color: #710827;
    display: block;
    font-size: 16px;
    height: auto;
    padding: 0 20px;
}


</style>
<div class="sidebar" id="sidebar">
			<div class="sidebar-inner slimscroll">
				<div id="sidebar-menu" class="sidebar-menu">
					<ul>
						<li class="active"> <a href="index.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a> </li>
						<li class="list-divider"></li>


						<li class="submenu"> <a href="#"><i class="fas fa-user"></i> <span> Customers </span> <span class="menu-arrow"></span></a>
							<ul class="submenu_class" style="display: none;">
							<li><a href="#" onclick="loadAllCustomerForm()"> All Customer </a></li>
								<li><a href="#" onclick="loadAddCustomerForm()"> Add Customer </a></li>
								
							</ul>
						</li>

						<li class="submenu"> <a href="#"><i class="fas fa-suitcase"></i> <span> Booking </span> <span class="menu-arrow"></span></a>
							<ul class="submenu_class" style="display: none;">
								<li><a href="#" onclick="loadAllBookingForm()">Booking List</a></li>
								<li><a href="#" onclick="loadAddBookingForm()"> Create Booking </a></li>
							</ul>
						</li>
					
			
					
			
				
						
						<li class="submenu"> 
    <a href="#"><i class="fe fe-table"></i> <span> Reports </span> <span class="menu-arrow"></span></a>
    <ul class="submenu_class" id="userListSubMenu" style="display: none;">
        <li><a href="GenerateUserList.php" target="_blank">Staff Report</a></li>
        <li><a href="GenerateReservationList.php" target="_blank">Reservation Report</a></li>
    </ul>
</li>

<script>
    function loadUserListReport() {
        window.open('GenerateUserList.php', '_blank');
    }
</script>

<script>
    function loadReservationListReport() {
        window.open('GenerateReservationList.php', '_blank');
    }
</script>

						
						
						
		
					</ul>
				</div>
			</div>
		</div>
		