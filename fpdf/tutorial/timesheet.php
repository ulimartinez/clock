<?php
require('../fpdf.php');

class PDF extends FPDF
{

}

// $name = $_POST['name'];
$name = 'David Teutli';
// $department = $_POST['department'];
$department = 'Department';

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
// Insert a dynamic image from a URL
$pdf->Image('../timesheet.png',0,0,210,0,'PNG');
$pdf->SetFont('Times','',12);
$pdf->Cell(0,80,$name,0,1);
$pdf->Cell(0,-55,$department,0,1);
$pdf->Cell(0,-55,$department,0,1);
$pdf->Output();
?>
