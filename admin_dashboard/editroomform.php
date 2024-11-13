<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Edit Room</title>
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title mt-5">Edit Room</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form id="editRoomForm">
                        <div class="row formtype">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="roomNumberInput">Room Number</label>
                                    <input class="form-control" type="text" id="roomNumberInput" name="room_id" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="roomTypeInput">Room Type</label>
                                    <select class="form-control" id="roomTypeInput" name="room_type" required>
                                        <option disabled selected>Select</option>
                                        <option>Single</option>
                                        <option>Double</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="acNonAcInput">AC/NON-AC</label>
                                    <select class="form-control" id="acNonAcInput" name="ac_non_ac" required>
                                        <option disabled selected>Select</option>
                                        <option>AC</option>
                                        <option>NON-AC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bedCountInput">Bed Count</label>
                                    <select class="form-control" id="bedCountInput" name="room_capacity" required>
                                        <option disabled selected>Select</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="priceInput">Price</label>
                                    <input type="text" class="form-control" id="priceInput" name="room_price" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <button type="button" id="saveButton" class="btn btn-primary buttonedit ml-2">Save</button>
           
        </div>
    </div>

    <script>
        // Fetch room data based on room ID and populate the form fields
        $(document).ready(function () {
            var roomId = <?php echo $_GET['room_id']; ?>;
            $.ajax({
                url: 'editroom.php', // Adjust the URL as needed
                type: 'GET',
                dataType: 'json',
                data: { room_id: roomId },
                success: function (data) {
                    // Populate form fields with fetched data
                    $('#roomNumberInput').val(data.room_id);
                    $('#roomTypeInput').val(data.room_type);
                    $('#acNonAcInput').val(data.ac_non_ac);
                    $('#bedCountInput').val(data.room_capacity);
                    $('#priceInput').val(data.room_price);
                },
                error: function () {
                    console.error('Error fetching room data');
                }
            });

            // Attach click event listener to the "Save" button
            $('#saveButton').click(confirmUpdate);

            function confirmUpdate() {
                // Check if all required fields are filled
                var roomType = $("#roomTypeInput").val();
                var acNonAc = $("#acNonAcInput").val();
                var bedCount = $("#bedCountInput").val();
                var price = $("#priceInput").val();

                if (!roomType || !acNonAc || !bedCount || !price) {
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
                    text: 'You are about to update the room information.',
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
                    url: "editroomsave.php",
                    data: $("#editRoomForm").serialize(),
                    success: function (response) {
                        console.log("Success:", response);
                        // Show the success alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Room Successfully Updated',
                            showConfirmButton: false,
                            timer: 1500,
                            position: 'center'
                        }).then(() => {
                            // Redirect to the desired page after successful update
                            loadAllRoomForm();
                        });
                    },
                    error: function (xhr, status, error) {
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
        });

	
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
</body>

</html>
