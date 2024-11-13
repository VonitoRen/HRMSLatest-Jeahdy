<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Add Room</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title mt-5">Add Room</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                <form id="room_form">
    <div class="row formtype">
        <div class="col-md-4">
            <div class="form-group">
                <label>Room Number</label>
                <input class="form-control" type="text" id="room_id" name="room_id" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Room Type</label>
                <select class="form-control" id="room_type" name="room_type">
                    <option disabled selected>Select</option>
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Family">Family</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>AC/NON-AC</label>
                <select class="form-control" id="ac_non_ac" name="ac_non_ac">
                    <option disabled selected>Select</option>
                    <option>AC</option>
                    <option>NON-AC</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Bed Count</label>
                <input class="form-control" type="text" id="bed_count" name="bed_count">
            </div>
        </div>
		<div class="col-md-4">
    <div class="form-group">
        <label>Price</label>
		<input type="text" class="form-control" id="price" name="room_price" placeholder="0.00" autocomplete="off">

    </div>
</div>
    </div>
</form>
                </div>
            </div>
            <button type="button" id="saveButton" class="btn btn-primary buttonedit ml-2" onclick="confirmSave()">Save</button>
        
        </div>
    </div>

    <script>
       $(document).ready(function() {
    // Function to format price
    function formatPrice(price) {
        return parseFloat(price).toFixed(2);
    }

    // Function to update bed count based on room type
    function updateBedCount() {
        var roomType = $('#room_type').val();
        var bedCount = roomType === 'Single' ? 1 : roomType === 'Double' ? 2 : roomType === 'Family' ? 3 : null;
        if (bedCount !== null) {
            $('#bed_count').val(bedCount);
        } else {
            $('#bed_count').val('');
        }
    }

    // Attach change event listener to room type select element
    $('#room_type').change(function() {
        updateBedCount();
    });

    // Attach keyup event listener to price input element
    $('#price').on('keyup', function() {
        var priceInput = $(this);
        var priceValue = priceInput.val();
        // Remove non-numeric characters
        priceValue = priceValue.replace(/[^0-9.]/g, '');
        // Update the value with formatted price
        priceInput.val(formatPrice(priceValue));
    });

    // Fetch the highest room number from the database
    $.ajax({
        url: 'get_highest_room_number.php', // PHP script to fetch the highest room number
        type: 'GET',
        success: function(response) {
            var highestRoomNumber;
            if (response.trim() === '') {
                highestRoomNumber = '001';
            } else {
                highestRoomNumber = (parseInt(response) + 1).toString().padStart(3, '0');
            }
            $('#room_id').val(highestRoomNumber); // Set the room number
        },
        error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText);
            // Handle error
        }
    });
});

// Attach click event listener to the "Save" button
$('#saveButton').click(confirmSave);

function confirmSave() {
    // Check if all required fields are filled
    var roomNumber = $("#room_id").val(); // Change from room_number to room_id
    var roomType = $("#room_type").val();
    var acNonAc = $("#ac_non_ac").val();
    var bedCount = $("#bed_count").val();
    var price = $("#price").val();

    if (!roomNumber || !roomType || !acNonAc || !bedCount || !price) {
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
        text: 'You are about to add the room.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, add it!',
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
            url: "addroom.php",
            data: $("#room_form").serialize(), // Serialize the form data
            success: function(response) {
                console.log("Success:", response);
                // Show the success alert
                Swal.fire({
                    icon: 'success',
                    title: 'Room Successfully Added',
                    showConfirmButton: false,
                    timer: 1500,
                    position: 'center'
                }).then(() => {
                    // Redirect to allroomsform.php
                    loadAllRoomForm();
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
