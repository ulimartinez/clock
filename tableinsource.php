<?php //todays transactions
	$toReturn = array();
	header('Content-Type: application/json');
	if(isset($_POST['usersin'])){
		require("config.php");
		$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
		if ($conn -> connect_error) {
			die("Connection failed: " . $con -> connecterror);
		}
		$sql = "SELECT t1.* FROM logs t1 LEFT OUTER JOIN logs t2  ON (t1.ID = t2.ID AND t1.date < t2.date) WHERE t2.ID IS NULL";
		$respoinse = $conn -> query($sql);
		$latest = array();
		while ($row = $respoinse -> fetch_assoc()) {
			if ($row['checkedIn'] === "1")
			{
				array_push($latest, $row);
			}
			
		}
		$total = count($latest);
		$toReturn['total'] = $total;
		for ($i = 0; $i < $total; $i++) {
			$id = $latest[$i]['ID'];
			$sql2 = "SELECT Name FROM employees WHERE ID = " . $id;
			$getName = $conn -> query($sql2);
			$row2 = $getName -> fetch_assoc();
			$name = $row2['Name'];
			$latest[$i]['Name'] = $name;
			
		}
		$toReturn['html'] = "";
		foreach ($latest as $tr){
			$toReturn['html'] += "<tr>
						<td>" . $tr['Name'] . "</td><td>" . $tr['date'] . "</td><td><a href=\"#\" class=\"kickout\" data-id=\"" . $tr['ID'] . "\">Force out</a></td>
				  </tr>";
		}
		echo json_encode($toReturn);
	}
?>