<?php
require('lib/fpdf/fpdf.php');
require('alluser.php'); // Include the file where the database connection is established

class StaffReportPDF extends FPDF
{
    public $columnWidths; // Change property visibility to public
    public $tableCenterX; // Center position of the table

    function Header()
    {
        // Add header if needed
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Staff Report', 0, 1, 'C');
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
        $this->SetFont('Arial', 'B', 10); // Adjusted font size
        foreach ($header as $col) {
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

        // Calculate table width
        $tableWidth = array_sum($this->columnWidths);

        // Determine starting position to center the table horizontally
        $this->tableCenterX = ($this->GetPageWidth() - $tableWidth) / 2;

        // Set X position to center the table header
        $this->SetX($this->tableCenterX);

        // Add table header
        foreach ($header as $col) {
            $colName = $this->getHeaderName($col);
            $this->Cell($this->columnWidths[$col], 10, $colName, 1, 0, 'C');
        }
        $this->Ln();
    }

    function AutoTable($header, $data)
    {
        // Add table content
        $this->SetFont('Arial', '', 10); // Adjusted font size
        $this->AddTableHeader($header, $data);
        
        // Add data rows
        foreach ($data as $row) {
            // Set X position to center the table content for each row
            $this->SetX($this->tableCenterX);
            
            $this->Row($row);
        }
    }

    function Row($data)
    {
        // Add table row
        foreach ($this->columnWidths as $col => $width) {
            $this->Cell($width, 10, isset($data[$col]) ? $data[$col] : '', 1, 0, 'C');
        }
        $this->Ln();
    }

    function getHeaderName($col)
    {
        // Get header name from column name
        $headerNames = array(
            'staff_id' => 'Staff ID',
            'staff_firstname' => 'First Name',
            'staff_lastname' => 'Last Name',
            'staff_username' => 'Username',
            'staff_email' => 'Email',
            'staff_phonenumber' => 'Phone Number',
            'staff_status' => 'Status',
            'staff_joineddate' => 'Joined Date'
        );

        return isset($headerNames[$col]) ? $headerNames[$col] : $col;
    }
}

$pdf = new StaffReportPDF();
$pdf->SetTitle('Staff Report');

// Fetch data from tbl_staff
$sql = "SELECT staff_id, staff_firstname, staff_lastname, staff_username, staff_email, staff_phonenumber, staff_status, staff_joineddate FROM tbl_staff";
$result = executeQuery($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$header = array('staff_id', 'staff_firstname', 'staff_lastname', 'staff_username', 'staff_email', 'staff_phonenumber', 'staff_status', 'staff_joineddate');

$pdf->AddPage('Letter');
$pdf->AutoTable($header, $data);
$pdf->Output();
?>
