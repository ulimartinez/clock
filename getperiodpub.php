<?php
function timeIn($seconds) {
	if (is_null($seconds)){
		return "";
	}
	else{
		$time = intval($seconds);
	}
	if ($time < 60){
		return $time . " seconds";
	} 
	else if ($time < (60 * 60)){
		return round($time / 60) . " minutes";
	} 
	else{
		return round($time / (60 * 60)) . " hours and " . round(($time / 60) % 60) . " minutes";
	}
}


require("config.php");
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if ($conn -> connect_error) {
	die("Connection failed: " . $con -> connecterror);
}


if (isset($_POST['start'])){
	$start2 = $_POST['start'];
	$start2 = explode('/', $start2);
	$year = date('y');
	if (date('n') < $start2[0])
	{
		$year--;
	}
	$start = DateTime::createFromFormat('n/j/y G', $_POST['start'] . "/" . $year . " 0");
	$end = DateTime::createFromFormat('n/j/y G', $_POST['end'] . "/" . $year . " 23");
	$end = $end->format('Y-m-d H:i:s');
	$start = $start->format('Y-m-d H:i:s');
	$id = $_POST['id'];
	$sql = "SELECT * FROM logs WHERE (date BETWEEN  '" . $start . "' AND '" . $end ."') AND ID = ". $id;
	$response = $conn -> query($sql);
	$period = array();
	while ($row = $response->fetch_assoc()){
		array_push($period, $row);
	}
	for ($i = 0; $i < count($period); $i++) {
		$id = $period[$i]['ID'];
		$sql2 = "SELECT Name FROM employees WHERE ID = " . $id;
		$getName = $conn -> query($sql2);
		$row2 = $getName -> fetch_assoc();
		$name = $row2['Name'];
		$period[$i]['name'] = $name;
		if ($period[$i]['checkedIn'] === '1') {
			$period[$i]['checkedIn'] = "Clocked IN";
		} else {
			$period[$i]['checkedIn'] = "Clocked OUT";
		}
	}
	echo "<table class=\"table table-striped\" id=\"periodTable\">
	<thead>
	<tr>
	<th>Name</th>
	<th>Action</th>
	<th>Date</th>
	<th>Time</th>
	</tr>
	</thead>
	<tbody>";
	foreach ($period as $tr) {
		echo "<tr data-id=\"" . $tr['ID'] . "\">
		<td>" . $tr['name'] . "</td><td>" . $tr['checkedIn'] . "</td><td>" . $tr['date'] . "</td><td>" . timeIn($tr['time']) . "</td>";
		echo "</tr>";
	}
	echo "</tbody>
	</table>";
}

?>