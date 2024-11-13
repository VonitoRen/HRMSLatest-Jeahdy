<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>List of Users</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="mt-5">
                                <h4 class="card-title float-left mt-2">All Users</h4> <a href="#" onclick="loadAddUserForm()" class="btn btn-primary float-right veiwbutton">Add Staff</a> </div>
                        </div>	
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <form>
                            <div class="row formtype">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>User ID</label>
                                        <input class="form-control" type="text" id="staffIdInput" oninput="filterUsers()"> </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input class="form-control" type="text" id="staffNameInput" oninput="filterUsers()"> </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" id="roleSelect" onchange="filterUsers()">
                                        <option value="">Select</option>
                                        <option value="Staff">Staff</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Search</label> <a href="#" class="btn btn-success btn-block mt-0 search_button"> Search </a> </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-table">
                            <div class="card-body booking_card">
                                <div class="table-responsive">
                                    <table class="datatable table table-stripped table table-hover table-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Staff ID</th>
                                                <th>Email</th>
                                                <th>Ph.Number</th>
                                                <th>Join Date</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
<?php


include("alluser.php");

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission and apply filters
    $sql = handleFormSubmission();
} else {
    // If the form is not submitted, retrieve all records from tbl_staff with userlevel joined from tbl_user
    $sql = "SELECT s.staff_id, s.staff_firstname, s.staff_lastname, s.staff_username, s.staff_email, s.staff_phonenumber, s.staff_status, s.staff_joineddate, u.userlevel AS staff_role 
            FROM tbl_staff s
            JOIN tbl_user u ON s.staff_id = u.id";
}

// Execute the query and return the result set
$result = executeQuery($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Output table rows
        echo "<tr>";
        echo "<td>{$row['staff_firstname']} {$row['staff_lastname']}</td>";
        echo "<td>{$row['staff_id']}</td>"; // Assuming staff_id is the unique identifier
        echo "<td>{$row['staff_email']}</td>";
        echo "<td>{$row['staff_phonenumber']}</td>";
        echo "<td>{$row['staff_joineddate']}</td>";
        echo "<td>{$row['staff_role']}</td>"; // Displaying staff_role fetched from tbl_user
        echo "<td>";
        echo "<div class='actions'> <a href='#' class='btn btn-sm bg-success-light mr-2'>{$row['staff_status']}</a> </div>";
        echo "</td>";
        echo "<td class='text-right'>";
        echo "<div class='dropdown dropdown-action'> <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='fas fa-ellipsis-v ellipse_color'></i></a>";
        echo "<div class='dropdown-menu dropdown-menu-right'> <a class='dropdown-item' href='#' onclick='loadEditUserForm({$row['staff_id']})'><i class='fas fa-pencil-alt m-r-5'></i> Edit</a> <a class='dropdown-item' href='#' data-toggle='modal' data-target='#delete_asset'><i class='fas fa-trash-alt m-r-5'></i> Delete</a> </div>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
        
    }
} else {
    // No records found
    echo "<tr><td colspan='8'>No records found</td></tr>";
}

// Function to handle form submission and apply filters
function handleFormSubmission()
{
    global $conn;

    // Your logic for handling form submission goes here

    // Example: Construct SQL query based on form data
    $sql = "SELECT * FROM tbl_staff WHERE 1";

    return $sql;
}

?>
                                        </tbody>
                                       
                                    </table>
                                    <div id="noRecords" style="display: none; text-align: center; margin-top: 10px;">No records found</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    // Function to handle dynamic filtering based on input values
    function filterUsers() {
        var staffId = $('#staffIdInput').val().toLowerCase();
        var staffName = $('#staffNameInput').val().toLowerCase();
        var role = $('#roleSelect').val().toLowerCase();
        
        // Filter table rows based on input values
        var found = false;
        $('#tableBody tr').each(function() {
            var row = $(this);
            var name = row.find('td:eq(0)').text().toLowerCase();
            var id = row.find('td:eq(1)').text().toLowerCase();
            var roleVal = row.find('td:eq(5)').text().toLowerCase();
            
            var idMatch = id.includes(staffId);
            var nameMatch = name.includes(staffName);
            var roleMatch = role === '' || roleVal.includes(role);
            
            // Show row only if all filters match
            var rowVisible = idMatch && nameMatch && roleMatch;
            row.toggle(rowVisible);
            if (rowVisible) {
                found = true;
            }
        });
        
        // Show no records found message if no matches found
        $('#noRecords').toggle(!found);
    }
	
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
    function loadEditUserForm(userId) {
    console.log('loadEditUserForm() called with userId:', userId);
    $.ajax({
        url: 'edituserform.php?user_id=' + userId, // Pass user ID as a parameter
        type: 'GET',
        dataType: 'html',
        success: function(data) {
            console.log('AJAX success');
            $('#content').html(data); 
            
            // Update the value of the readonly input field with the fetched user ID
            $('#user_id').val(userId);
            
            // Disable editing for the readonly input field
            $('#user_id').prop('readonly', true);
            
            // Trigger the change event to enable editing for other fields
            enableEditing(userId);
        },
        error: function() {
            console.error('Error loading edituserform.php');
        }
    });
}


</script>
</html>
