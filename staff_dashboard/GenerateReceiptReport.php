<?php
require('lib/fpdf/fpdf.php');
require('fetchReservationDetails.php');

class GenerateReceiptReport extends FPDF
{
    function Header()
    {
        // Set draw color for wavy design
        $this->SetDrawColor(0, 102, 204); // Blue color
        // Draw wavy design on the upper part of the page
        $this->DrawWavyDesign(0, 30, $this->GetPageWidth(), 20, true);
    
        // Logo
        $pageWidth = $this->GetPageWidth();
        // Calculate image position to center horizontally
        $imageWidth = 30; // Adjust image width
        $imageX = ($pageWidth - $imageWidth) / 2;
        // Image with adjusted position
        $this->Image('assets/img/Logofinalmikka.png', $imageX, 3, $imageWidth); // Centered image and moved below
    
        // Set background color
        $this->SetFillColor(120, 5, 39);
        // Set text color
        $this->SetTextColor(255, 255, 255);
        // Set font
        $this->SetFont('Arial', 'B', 24); // Increased font size
    
        // Adjust y-coordinate to move the title down
        $titleY = 22; // Adjust this value as needed
        // Adjust y-coordinate to move the background down
        $backgroundY = 20; // Adjust this value as needed
        $this->Ln(15); // Add some space after the title
        // Title with background color
        $this->Cell(0, 10, 'Hotel Receipt', 0, 1, 'C', true, '', $titleY); // Extend the height of the cell to match the background
        // Background color with adjusted position

        $this->Ln(10); // Add some space after the title
    }
    function Footer()
    {
        // Draw wavy design on the lower part of the page
        $this->SetDrawColor(0, 102, 204); // Blue color
        

        // Set font for the message
        $this->SetFont('Arial', 'B', 10);
        // Set text color for the message
        $this->SetTextColor(113, 8, 39); // Dark maroon color
        // Add the message
        $this->Cell(0, 10, 'Enjoy Your Stay at Hotel Mikka', 0, 0, 'C');
    }

    function ReceiptContent($reservationDetails)
    {
        // Set font
        $this->SetFont('Arial', '', 10); // Further reduced font size
        // Set text color
        $this->SetTextColor(0, 0, 0);
        foreach ($reservationDetails as $detail) {
            $this->Cell(0, 7, 'Reservation ID: ' . $detail['reservation_id'], 0, 1);
            $this->Cell(0, 7, 'Client ID: ' . $detail['client_id'], 0, 1);
            $this->Cell(0, 7, 'Client Name: ' . $detail['client_fullname'], 0, 1);
            $this->Cell(0, 7, 'Total Members: ' . $detail['total_members'], 0, 1);
            $this->Cell(0, 7, 'Room Type: ' . $detail['room_type'], 0, 1);
            $this->Cell(0, 7, 'Room Utility: ' . $detail['room_utility'], 0, 1);
            $this->Cell(0, 7, 'Room Number: ' . $detail['room_number'], 0, 1);
            $this->Cell(0, 7, 'Additional Pillow: ' . $detail['add_pillow'], 0, 1);
            $this->Cell(0, 7, 'Additional Blanket: ' . $detail['add_blanket'], 0, 1);
            $this->Cell(0, 7, 'Checkinout ID: ' . $detail['checkinout_id'], 0, 1);
            $this->Cell(0, 7, 'Total Cost Per Day: ' . $detail['total_cost_per_day'], 0, 1);
            // Highlight total bill section
            $this->SetFillColor(255, 204, 204); // Light red background color
            $this->Cell(0, 7, 'Total Bill: ' . $detail['totalBill'], 1, 1, '', true);
            $this->Ln(6); // Add some space between each detail section
        }
    }

    // Function to draw wavy design
    function DrawWavyDesign($x, $y, $width, $height, $upwards)
    {
        $start_x = $x;
        $end_x = $x + $width;
        $range_x = $end_x - $start_x;
    
        $this->SetLineWidth(30); // Increase line width for a thicker wave
    
        $wave_length = 1;
        $amplitude_upper = 5; // Increased amplitude for upper wave
        $amplitude_lower = 2;  // Decreased amplitude for lower wave
    
        $wave_count = intval($range_x / $wave_length);
        $points_upper = array();
        $points_lower = array();
    
        for ($i = 0; $i <= $wave_count; $i++) {
            $points_upper[] = array(
                $start_x + $i * $wave_length,
                $y + ($upwards ? -1 : 2) * $amplitude_upper * sin($i * 7 * M_PI / $wave_count)
            );
            $points_lower[] = array(
                $start_x + $i * $wave_length,
                $y + $height + ($upwards ? -1 : 0) * $amplitude_lower * sin($i * 4 * M_PI / $wave_count)
            );
        }
    
        // Define gradient colors
        $color_start = array(0, 102, 204); // Start color (blue)
        $color_end = array(255, 204, 0);   // End color (yellow)
    
        // Draw upper wave
        for ($i = 1; $i < $wave_count; $i++) {
            // Interpolate color between start and end color
            $r = $color_start[0] + ($color_end[0] - $color_start[0]) * $i / $wave_count;
            $g = $color_start[1] + ($color_end[1] - $color_start[1]) * $i / $wave_count;
            $b = $color_start[2] + ($color_end[2] - $color_start[2]) * $i / $wave_count;
            $this->SetDrawColor($r, $g, $b);
            $this->Line($points_upper[$i - 1][0], $points_upper[$i - 1][1], $points_upper[$i][0], $points_upper[$i][1]);
        }
    
       
    }
}

// Create PDF instance
$pdf = new GenerateReceiptReport();
$pdf->SetTitle('Receipt');

// Fetch reservation details
$reservationDetails = fetchReservationDetails();

// Check if reservation details exist and it's an array with at least one element
if (is_array($reservationDetails) && count($reservationDetails) > 0) {
    // Add a page with custom size for smaller receipt-like appearance
    $pdf->AddPage('P', array(100, 150)); // Width: 100mm, Height: 150mm
    $pdf->ReceiptContent($reservationDetails);
} else {
    // If no reservation details found or it's not an array, display a message
    $pdf->AddPage('P', array(100, 150)); // Width: 100mm, Height: 150mm
    $pdf->Cell(0, 10, 'No reservation details found', 0, 1, 'C');
}

// Output PDF
ob_clean(); // Clean (erase) the output buffer
$pdf->Output();
?>
