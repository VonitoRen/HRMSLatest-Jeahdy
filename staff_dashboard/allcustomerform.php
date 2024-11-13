<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>List of Customers</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="page-wrapper">
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <div class="mt-5">
                        <h4 class="card-title float-left mt-2">All Customers</h4>
                        <a href="#" onclick="loadAddCustomerForm()" class="btn btn-primary float-right veiwbutton">Add Customer</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form>
                    <div class="row formtype">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Customer ID</label>
                                <input class="form-control" type="text" id="customerIdInput" oninput="filterCustomers()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Customer Name</label>
                                <input class="form-control" type="text" id="customerNameInput" oninput="filterCustomers()">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Search</label>
                                <a href="#" class="btn btn-success btn-block mt-0 search_button"> Search </a>
                            </div>
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
                                <th>Customer Name</th>
                                <th>Customer ID</th>
                                <th>Birthdate</th>
                                <th>Phone Number</th>
                                <th class="text-right">Actions</th> 
                                
                            </tr>
                            </thead>
                                    <tbody id="tableBody">
                                        <?php
                                        include("allcustomer.php");

                                        // Check if the form data is submitted
                                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                            // Handle form submission and apply filters
                                            $sql = handleFormSubmission();
                                        } else {
                                            // If the form is not submitted, retrieve all records from tbl_userclient
                                            $sql = "SELECT * FROM tbl_userclient";
                                        }

                                        // Execute the query and return the result set
                                        $result = executeQuery($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                // Output table rows
                                                echo "<tr>";
                                                echo "<td>{$row['client_fname']} {$row['client_lname']}</td>";
                                                echo "<td>{$row['client_id']}</td>"; // Assuming client_id is the unique identifier
                                                echo "<td>{$row['client_bdate']}</td>";
                                                echo "<td>{$row['client_pnum']}</td>";
                                                echo "<td class='text-right'>";
                                                echo "<div class='dropdown dropdown-action'> <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='fas fa-ellipsis-v ellipse_color'></i></a>";
                                                echo "<div class='dropdown-menu dropdown-menu-right'> <a class='dropdown-item' href='#' onclick='loadEditCustomerForm({$row['client_id']})'><i class='fas fa-pencil-alt m-r-5'></i> Edit</a> <a class='dropdown-item' href='#' onclick='deleteCustomer({$row['client_id']})'><i class='fas fa-trash-alt m-r-5'></i> Delete</a> </div>";
                                                echo "</div>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            // No records found
                                            echo "<tr><td colspan='5'>No records found</td></tr>";
                                        }

                                        // Function to handle form submission and apply filters
                                        function handleFormSubmission()
                                        {
                                            // Your logic for handling form submission goes here

                                            // Example: Construct SQL query based on form data
                                            $sql = "SELECT * FROM tbl_userclient WHERE 1";

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
</body>
<script>
    // Function to handle dynamic filtering based on input values
    function filterCustomers() {
        var customerId = $('#customerIdInput').val().toLowerCase();
        var customerName = $('#customerNameInput').val().toLowerCase();

        // Filter table rows based on input values
        var found = false;
        $('#tableBody tr').each(function() {
            var row = $(this);
            var name = row.find('td:eq(0)').text().toLowerCase();
            var id = row.find('td:eq(1)').text().toLowerCase();

            var idMatch = id.includes(customerId);
            var nameMatch = name.includes(customerName);

            // Show row only if all filters match
            var rowVisible = idMatch && nameMatch;
            row.toggle(rowVisible);
            if (rowVisible) {
                found = true;
            }
        });

        // Show no records found message if no matches found
        $('#noRecords').toggle(!found);
    }

    function loadEditCustomerForm(clientId) {
        console.log('loadEditCustomerForm() called with clientId:', clientId);
        $.ajax({
            url: 'editcustomerform.php',
            type: 'GET',
            data: { client_id: clientId },
            dataType: 'html',
            success: function(data) {
                console.log('AJAX success');
                $('#content').html(data); // Assuming you have a div with id="content" to load the form
            },
            error: function() {
                console.error('Error loading editcustomerform.php');
            }
        });
    }
    function loadEditUserForm(clientId) {
    console.log('loadEditUserForm() called with userId:', clientId);
    $.ajax({
        url: 'editcustomerform.php?client_id=' + clientId, // Pass user ID as a parameter
        type: 'GET',
        dataType: 'html',
        success: function(data) {
            console.log('AJAX success');
            $('#content').html(data); 
            
            // Update the value of the readonly input field with the fetched user ID
            $('#client_id').val(clientId);
            
            // Disable editing for the readonly input field
            $('#client_id').prop('readonly', true);
            
       
        },
        error: function() {
            console.error('Error loading edituserform.php');
        }
    });
}



</script>
</html>
