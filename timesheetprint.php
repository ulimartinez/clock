<?php
require('fpdf/fpdf.php');
//sql stuff
if(isset($_POST['id']) AND isset($_POST['totalTime']) AND isset($_POST['period'])){
	//save vars and query employee data from database
	$id = $_POST['id'];
	$time = $_POST['totalTime'];
	$period = $_POST['period'];
	require("config.php");
	$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
	if ($conn -> connect_error) {
		die("Connection failed: " . $con -> connecterror);
	}
	$sql = "SELECT * FROM employees WHERE id = $id";
	$conn->close();
	//TODO: get the values from the db for the pdf header
}
else{
	header('Location: timesheet.php');
	exit();
}
//function to get the number of weeks in period
function numWeeks($period){
	$period = str_replace(" ", "", $period);
	$period = explode("-", $period);//period[0] is start period[1] is end
	$period[0] = explode("/", $period[0]);
	$period[1] = explode("/", $period[1]);
	$weekdays = array(0,0,0,0,0);
	for($i = $period[0][1]; $i <= $period[1][1]; $i++){
		$dayOfWeek = date('N', DateTime::createFromFormat('n/j', $i . "/" . $period[0][0])->getTimestamp());
		if($dayOfWeek < 6){
			$weekdays[$dayOfWeek - 1]++;
		}
	}
	return max($weekdays);
}
class PDF extends FPDF
{

}

// $name = $_POST['name'];
$name = 'David Teutli';
// $department = $_POST['department'];
$department = 'Department' . numWeeks($period);

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
// Insert a dynamic image from a URL
$pdf->Image('image/timesheet.png',0,0,210,0,'PNG');
$pdf->SetFont('Times','',12);
$pdf->Cell(0,80,$name,0,1);
$pdf->Cell(0,-55,$department,0,1);
$pdf->Cell(0,-55,$department,0,1);
$pdf->Output();
?>
