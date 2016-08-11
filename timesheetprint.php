<?php
require('fpdf/fpdf.php');
//sql stuff
if(isset($_POST['id']) AND isset($_POST['totalTime']) AND isset($_POST['period'])){
	//save vars and query employee data from database
	$id = $_POST['id'];
	$time = $_POST['totalTime'];
	$period = $_POST['period'];
	$period = str_replace(" ", "", $period);
	$tmp = explode("-", $period);
	$tmp[0] = explode("/", $tmp[0]);
	$tmp[1] = explode("/", $tmp[1]);
	$period = array('start'=>array('month'=>$tmp[0][0], 'day'=>$tmp[0][1]), 'end'=>array('month'=>$tmp[1][0], 'day'=>$tmp[1][1]));
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
	$weekdays = array(0,0,0,0,0);
	for($i = $period['start']['day']; $i <= $period['end']['day']; $i++){
		$dayOfWeek = date('N', DateTime::createFromFormat('n/j', $period['start']['month'] . "/" . $i)->getTimestamp());
		if($dayOfWeek < 6){
			$weekdays[$dayOfWeek - 1]++;
		}
	}
	return array('weeks'=>max($weekdays), 'days'=>array_sum($weekdays));
}
function generateWeeks($numWeeks, $numDays, $time, $maxTime, $start, $end){
	echo $numWeeks . "<br/>";
	//given the number of weeks to generate, distribute time in the days of the weeks
	$total = $time;
	$weeks = array();
	$val = $total / $numDays;
	$count = $start['day'];
	for($i = 0; $i < $numWeeks; $i++){
		$tmp = array(0,0,0,0,0);
		for(; $count <= $end['day'] AND date('N', DateTime::createFromFormat('n/j', $start['month'] . "/" . ($count))->getTimestamp()) < 6; $count++){
			$day = date('N', DateTime::createFromFormat('n/j', $start['month'] . "/" . ($count))->getTimestamp());
			$tmp[$day-1] = $val;
		}
		$weeks[] = $tmp;
		$count += 2;
	}
	return $weeks;
}
class PDF extends FPDF
{

}

// $name = $_POST['name'];
$name = 'David Teutli';
// $department = $_POST['department'];
$department = 'Department' . $time;
echo json_encode(generateWeeks(numWeeks($period)['weeks'], numWeeks($period)['days'], $time, 28, $period['start'], $period['end']));
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
