<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Add Customer</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
</head>

<body>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title mt-5">Add Customer</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form id="customer_form">
                        <div class="row formtype">
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
                                    <input id="client_pnum" name="client_pnum" class="form-control" type="text" value="" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value = this.value.replace(/[^0-9]/g, '');" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <button type="button" onclick="confirmAddCustomer()" class="btn btn-primary buttonedit">Add Customer</button>
        </div>
    </div>

    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <!-- Include other scripts as needed -->
    <script>
        function confirmAddCustomer() {
            // Show confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to add this customer.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, add it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If user confirms, submit the form
                    submitForm();
                }
            });
        }

        function submitForm() {
            // Check if all fields are filled
            var firstName = $("#client_fname").val();
            var lastName = $("#client_lname").val();
            var birthdate = $("#client_bdate").val();
            var phoneNumber = $("#client_pnum").val();

            if (firstName && lastName && birthdate && phoneNumber) {
                // All fields are filled, submit the form via AJAX
                $.ajax({
                    type: "POST",
                    url: "addcustomer.php",
                    data: $("#customer_form").serialize(), // Serialize the form data
                    success: function(response) {
                        console.log("Success:", response);
                        // Show the success alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Customer Successfully Added',
                            showConfirmButton: false,
                            timer: 1500,
                            position: 'center'
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
                            position: 'center'
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
                    position: 'center'
                });
            }
        }

        function resetForm() {
            // Reset the form fields
            $("#customer_form")[0].reset();
        }
    </script>
</body>

</html>
