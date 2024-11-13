<?php
require('lib/fpdf/fpdf.php');
require('allbooking.php'); // Include the file where the database connection is established

class GenerateReservationList extends FPDF
{
    public $columnWidths; // Change property visibility to public
    public $tableLeftMargin; // Left margin for the table

    function Header()
    {
        // Add header if needed
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Reservation List', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        // Add footer if needed
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function AddTableHeader($header, $data)
    {
        // Add table header
        $this->SetFont('Arial', 'B', 8); // Adjusted font size
        foreach ($header as $col) {
            if($col != 'checkinout_id') {
                $colName = $this->getHeaderName($col);
                $maxWidth = $this->GetStringWidth($colName) + 6; // Add padding
                foreach ($data as $row) {
                    if (isset($row[$col])) {
                        $contentWidth = $this->GetStringWidth($row[$col]) + 6; // Add padding
                        $maxWidth = max($maxWidth, $contentWidth);
                    }
                }
                $this->columnWidths[$col] = $maxWidth;
            }
        }

        // Calculate table width
        $tableWidth = array_sum($this->columnWidths);

        // Determine left margin to center the table horizontally
        $this->tableLeftMargin = ($this->GetPageWidth() - $tableWidth) / 2;

        // Set X position to place the table header in the center
        $this->SetX($this->tableLeftMargin);

        // Add table header
        foreach ($header as $col) {
            if($col != 'checkinout_id') {
                $colName = $this->getHeaderName($col);
                $this->Cell($this->columnWidths[$col], 10, $colName, 1, 0, 'C');
            }
        }
        $this->Ln();
    }

    function AutoTable($header, $data)
    {
        // Add table content
        $this->SetFont('Arial', '', 8); // Adjusted font size
        $this->AddTableHeader($header, $data);
        
        // Add data rows
        foreach ($data as $row) {
            // Set X position to place the table content in the center
            $this->SetX($this->tableLeftMargin);
            
            $this->Row($row);
        }
    }

    function Row($data)
    {
        // Add table row
        foreach ($this->columnWidths as $col => $width) {
            if($col != 'checkinout_id') {
                $this->Cell($width, 10, isset($data[$col]) ? $data[$col] : '', 1, 0, 'C');
            }
        }
        $this->Ln();
    }

    function getHeaderName($col)
    {
        // Get header name from column name
        $headerNames = array(
            'reservation_id' => 'Reservation ID',
            'client_id' => 'Client ID',
            'client_fullname' => 'Client Fullname',
            'total_members' => 'Total Members',
            'room_type' => 'Room Type',
            'room_utility' => 'Room Utility',
            'room_number' => 'Room Number',
            'add_pillow' => 'Add Pillow',
            'add_blanket' => 'Add Blanket',
            'total_cost_per_day' => 'Total Cost Per Day',
            'totalBill' => 'Total Bill'
        );

        return isset($headerNames[$col]) ? $headerNames[$col] : $col;
    }
}

$pdf = new GenerateReservationList();
$pdf->SetTitle('Reservation List');

// Fetch data from tbl_reservation
$sql = "SELECT reservation_id, client_id, client_fullname, total_members, room_type, room_utility, room_number, add_pillow, add_blanket, total_cost_per_day, totalBill FROM tbl_reservation";
$result = executeQuery($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$header = array('reservation_id', 'client_id', 'client_fullname', 'total_members', 'room_type', 'room_utility', 'room_number', 'add_pillow', 'add_blanket', 'total_cost_per_day', 'totalBill');

$pdf->AddPage('Letter');
$pdf->AutoTable($header, $data);
$pdf->Output();
?>
