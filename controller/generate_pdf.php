<?php
require_once('../vendor/TCPDF-main/tcpdf.php');

// Create a TCPDF object
$pdf = new TCPDF();
$pdf->SetAutoPageBreak(true, 10);

// Add a page in landscape orientation
$pdf->AddPage('L');
$pdf->SetFont('helvetica',  15); // Set font to bold, size 16

// Add your heading
$pdf->SetFont('helvetica', 'B', 16); // 'B' sets the font style to bold
$pdf->Cell(0, 10, 'Seasonal Summary of Fertilizer Distribution ', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12); // Set the font style back to normal if needed for other content

$pdf->SetCellHeightRatio(0.1); // Adjust this ratio to reduce the line spacing
$pdf->Cell(0, 10, 'Agrarian Center', 0, 1, 'C');
$pdf->Cell(0, 10, 'Sooriyawewa,', 0, 2, 'C');
$pdf->Cell(0, 10, 'Meegahajadura.', 0, 2, 'C');
$pdf->SetCellHeightRatio(1); // Reset the line spacing ratio to default if needed for other content

$pdf->SetFont('helvetica', 'B', 16); // Set font to bold
$pdf->Cell(0, 10, 'Registration Details of Farmers', 0, 2, 'C'); // Output text
$underlinePos = $pdf->GetY(); // Get current Y position
$textWidth = $pdf->GetStringWidth('Registration Details of Farmers'); // Get width of the text

// Underline
$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)));
$pdf->Line(($pdf->GetPageWidth() - $textWidth) / 2, $underlinePos, ($pdf->GetPageWidth() + $textWidth) / 2, $underlinePos);

$pdf->SetFont('helvetica', '', 12); // Set font back to normal if needed for other content

$pdf->Ln(10); // Add some space after the heading

$header = array('First Name', 'Last Name', 'Contact ', 'NIC', 'Acc. Number', 'Address 1', 'Address 2', 'Address 3');
$data = array();

// Database connection
$con = mysqli_connect("localhost", "root", "", "aims");

if ($con) {
    // Fetch data from the database
    $query = "SELECT * FROM far_reg";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        while ($row = mysqli_fetch_assoc($query_run)) {
            $data[] = array(
                $row['far_fname'],
                $row['far_lname'],
                $row['far_con'],
                $row['far_nic'],
                $row['far_acc'],
                $row['far_add1'],
                $row['far_add2'],
                $row['far_add3']
            );
        }
    }

    // Set the width of the cells
    $cellWidth = 35;

    // Set colors and formatting for the table
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetDrawColor(128, 128, 128);

    // Add a table header
    foreach ($header as $col) {
        $pdf->Cell($cellWidth, 10, $col, 1);
    }
    $pdf->Ln();

    // Add table data
    foreach ($data as $row) {
        foreach ($row as $col) {
            $pdf->Cell($cellWidth, 10, $col, 1);
        }
        $pdf->Ln();
    }

    // Output the PDF to the browser
    $pdf->Output('far_reg_data.pdf', 'I');

    // Close the database connection
    mysqli_close($con);
} else {
    echo "Connection to the database failed.";
}
?>