<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{

}

// $name = $_POST['name'];
$name = 'David Teutli';
// $department = $_POST['department'];
$department = 'Department';
// $ut_eid = $_POST['ut_eid'];
$ut_eid = 0123456789;
// $job_title = $_POST['job_title'];
$job_title = 'El Jefe';
// $PI = $_POST['PI'];
$PI = 'Dr. Abdallah';
// $division = $_POST['division'];
$division = 'Division';
// $date = $_POST['date'];
$date = date("Y/m/d");
// $days = $_POST['days'];
$days = [['6','5','6','5','6'],['6','5','6','5','6'],['6','5','6','5','6'],['6','5','6','5','6']];
// $timeperiod = $_POST['timeperiod'];
$timeperiod = ['date','date','date','date'];

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
// Insert a dynamic image from a URL
$pdf->Image('image/timesheet.png',0,0,210,0,'PNG');
$pdf->SetFont('Times','',12);
// $pdf->Cell(Width,Height,'Text',Border,New Line);
$pdf->Cell(0,22,'',0,1); // blank space for format
$pdf->Cell(0,10,$PI,0,1,'C');  // blank space for format and PI variable
$pdf->Cell(0,2,'',0,1);  // blank space for format
$pdf->Cell(80,10,$name,0);
$pdf->Cell(25,10,' ',0);
$pdf->Cell(80,10,$job_title,0,1);

$pdf->Cell(0,4,' ',0,1);
$pdf->Cell(80,10,$department,0);
$pdf->Cell(25,10,' ',0);
$pdf->Cell(80,10,$division,0);

$pdf->Cell(0,15,' ',0,1);
$pdf->Cell(80,10,$ut_eid,0);
$pdf->Cell(25,10,' ',0);
$pdf->Cell(80,10,$date,0,1);

$pdf->Cell(0,4,'',0,1);
$pdf->Cell(28,10,'',0);
$pdf->Cell(60,10,$timeperiod[0],0);
$pdf->Cell(42,10,'',0);
$pdf->Cell(60,10,$timeperiod[1],0,1);


// **** Week 1 ****
$pdf->Cell(0,5,'',0,1);
$pdf->Cell(30,10,'',0);
for ($i=0; $i < 5; $i++) {
  $pdf->Cell(9,10,$days[0][$i],0);
}
$pdf->Cell(7,10,'',0);
$pdf->Cell(9,10,array_sum($days[0]),0);


// **** Week 2 ****
$pdf->Cell(40,10,'',0);
for ($i=0; $i < 5; $i++) {
  $pdf->Cell(9,10,$days[1][$i],0);
}
$pdf->Cell(9,10,'',0);
$pdf->Cell(9,10,array_sum($days[1]),0);

// **** Weekly Totals Week 1 & 2 ****
$pdf->Cell(0,15,'',0,1);
$pdf->Cell(80,10,'',0);
$pdf->Cell(9,10,array_sum($days[0]),0);
$pdf->Cell(93,10,'',0);
$pdf->Cell(9,10,array_sum($days[1]),0,1);

// 2nd row
$pdf->Cell(0,5,'',0,1);
$pdf->Cell(28,10,'',0);
$pdf->Cell(60,10,$timeperiod[2],0);
$pdf->Cell(42,10,'',0);
$pdf->Cell(60,10,$timeperiod[3],0,1);

// **** Week 3 ****
$pdf->Cell(0,5,'',0,1);
$pdf->Cell(30,10,'',0);
for ($i=0; $i < 5; $i++) {
  $pdf->Cell(9,10,$days[2][$i],0);
}
$pdf->Cell(7,10,'',0);
$pdf->Cell(9,10,array_sum($days[0]),0);

// **** Week 4 ****
$pdf->Cell(40,10,'',0);
for ($i=0; $i < 5; $i++) {
  $pdf->Cell(9,10,$days[3][$i],0);
}
$pdf->Cell(9,10,'',0);
$pdf->Cell(9,10,array_sum($days[1]),0);

// **** Weekly Totals Week 3 & 4 ****
$pdf->Cell(0,15,'',0,1);
$pdf->Cell(80,10,'',0);
$pdf->Cell(9,10,array_sum($days[0]),0);
$pdf->Cell(93,10,'',0);
$pdf->Cell(9,10,array_sum($days[1]),0,1);







$pdf->Output();
?>
