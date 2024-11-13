<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming check-in and check-out dates are sent via POST
    $booking_details = $_POST;

    // Debug: Output the received data to the console
    echo "<script>console.log(" . json_encode($booking_details) . ");</script>";

    // Validate if check-in and check-out dates are present
    if(isset($_POST['checkin_date']) && isset($_POST['checkout_date'])) {
        // Store the check-in and check-out dates in the session
        $_SESSION['booking_details'] = $booking_details;
        echo json_encode(['status' => 'success', 'message' => 'Booking details saved in session.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Check-in and check-out dates are missing.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
