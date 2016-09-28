<?php
ini_set('date.timezone', 'America/Denver');
function to_arr($array, $row) {
	$timestamp = new DateTime($row['date']);
	$timestamp = $timestamp -> getTimestamp();
	$row['date'] = $timestamp;
	array_push($array, $row);
	return $array;
}

$to_return = array();
require("config.php");
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$user = "Person";
if ($conn -> connect_error) {
	die("Connection failed: " . $con -> connecterror);
}
if (isset($_POST['clock'])) {
	$id = $_POST['id'];
	$sql = "SELECT * FROM employees WHERE id = " . $id;
	$in_out = "SELECT t1.* FROM logs t1 LEFT OUTER JOIN logs t2  ON (t1.ID = t2.ID AND t1.date < t2.date) WHERE t2.ID IS NULL AND t1.ID = " . $id;
	$total = "SELECT SUM(time) FROM logs WHERE ID = " . $id . " AND date > DATE_SUB(NOW(), INTERVAL HOUR(NOW()) HOUR)";
	$result = $conn -> query($sql);
	if ($result -> num_rows == 1) {
		$row = $result -> fetch_assoc();
		$user = $row['Name'];
		$result_today = $conn -> query($total);
		if ($result_today -> num_rows == 1) {
			$time_row = $result_today->fetch_assoc();
			$total_time = $time_row['SUM(time)'];
		}
		$result2 = $conn -> query($in_out);
		if ($result2 -> num_rows == 1) {
			//user has logged in before
			$user_log = $result2 -> fetch_assoc();
			$latest = $user_log['checkedIn'];
			if ($latest === "1") {
				//user is currently logged in
				$to_return['welcome'] = "<h4 class=\"modal-title\" id=\"myModalLabel\">Goodbye " . $user . "!</h4>";
				$to_return['status'] = "<p id=\"status\">OUT</p>";
				$to_return['today'] = $total_time;
				$date = new DateTime();
				$start = new DateTime($user_log['date']);
				$time = $date -> getTimestamp() - $start -> getTimestamp();
				$logout = "INSERT into logs (ID, checkedIn, time) Values(" . $id . ", 0, " . $time . ")";
				$conn -> query($logout);

				$to_return['time'] = $time;
			} else if ($latest === "0") {
				//user is currently logged out
				$to_return['welcome'] = "<h4 class=\"modal-title\" id=\"myModalLabel\">Welcome back " . $user . "!</h4>";
				$to_return['status'] = "<p id=\"status\">IN</p>";
				$login = "INSERT into logs (ID, checkedIn) Values(" . $id . ", 1)";
				$conn -> query($login);
			}

		} else {
			//entered for the first time
			$to_return['welcome'] = "<h4 class=\"modal-title\" id=\"myModalLabel\">Welcome " . $user . "!</h4>";
			$to_return['status'] = "<p id=\"status\">IN</p>";
			$log = "INSERT into logs (ID, checkedIn) Values(" . $id . ", 1)";
			$result = $conn -> query($log);
			//echo "inserted for the first time";
		}
	}
	header('Content-Type: application/json');
	echo json_encode($to_return);
}
if (isset($_POST['delete'])) {
	$sql = "DELETE FROM employees WHERE ID = " . $_POST['delete'];
	$conn -> query($sql);
}
if (isset($_POST['saved'])) {
	if($_POST['old_id'] === $_POST['new_id']){
		//id is the same, update just the name and classif
		$update = "UPDATE employees SET Name = \"" . $_POST['name'] . "\", Class = \"" . $_POST['class'] . "\" WHERE ID =" . $_POST['old_id'];
		if ($conn -> query($update)) {
			$to_return['success'] = "Updated";
		}
	}
	else{
		//check that the new id is valid
		if(is_numeric($_POST['new_id']) AND $_POST['new_id'] < 10000 AND $_POST['new_id'] >= 1000){
			//check that the new id doesn't conflict with another one
			$sql = "SELECT * FROM employees WHERE ID = " . $_POST['new_id'];
			$result = $conn -> query($sql);
			if($result->num_rows > 0){
				$to_return['error'] = "That ID is already taken";
			}
			else{
				//set new id, name, and classification
				$update = "UPDATE employees SET ID = " . $_POST['new_id'] . ", Name = \"" . $_POST['name'] . "\", Class = \"" . $_POST['class'] . "\" WHERE ID =" . $_POST['old_id'];
				if ($conn -> query($update)) {
					$to_return['success'] = "Updated";
				}
			}
		}
		else{
			$to_return['error'] = "Please enter a valid 4 digit number";
		}
	}
	header('Content-Type: application/json');
	echo json_encode($to_return);
}
if (isset($_POST['override'])) {
	$sql = "UPDATE logs SET time = " . $_POST['seconds'] . ", date = '" . $_POST['new'] . "' WHERE date = '" . $_POST['old'] . "'";

	$result = $conn -> query($sql);
	if ($result->num_rows > 0) {
		$to_return['success'] = "Updated";
	} else {
		$to_return['error'] = "Error";
	}
	$to_return['query'] = $sql;
	header('Content-Type: application/json');
	echo json_encode($to_return);
}
if (isset($_POST['kickout'])) {
	//find out id
	$id = $_POST['person'];
	$latest = "SELECT t1.* FROM logs t1 LEFT OUTER JOIN logs t2  ON (t1.ID = t2.ID AND t1.date < t2.date) WHERE t2.ID IS NULL AND t1.ID = " . $id;
	$result = $conn -> query($latest);
	if ($result -> num_rows > 0) {
		$row = $result -> fetch_assoc();
		$date = new DateTime();
		$start = DateTime::createFromFormat('Y-m-d H:i:s', $row['date']);
		$time = $date -> getTimestamp() - $start -> getTimestamp();
	}
	$sql2 = "INSERT into logs (ID, checkedIn, time) Values(" . $id . ", 0, " . $time . ")";
	$result = $conn -> query($sql2);
	$to_return['result'] = $result;
	$to_return['query'] = $sql2;
	echo json_encode($to_return);
}
if(isset($_POST['timesheet'])){
	$sql = "SELECT * FROM employees WHERE ID = " . $_POST['id'];
	$result = $conn -> query($sql);
	if($result->num_rows <= 0){
		$to_return['error'] = "Invalid Login";
	}
	else{
		session_start();
		$_SESSION['user'] = $_POST['id'];
		$to_return['session'] = 'set';
	}
	header('Content-Type: application/json');
	echo json_encode($to_return);
}
if(isset($_POST['add'])){
	$id = $_POST['id'];
	$sql = "SELECT * FROM employees WHERE ID = " . $id;
	$result = $conn -> query($sql);
	if($result->num_rows > 0){
		$to_return['error'] = "Error, user with id " . $id . " exists";
	}
	else{
		$name = $_POST['name'];
		$class = $_POST['class'];
		$sql = "INSERT INTO employees (ID, Class, Name) VALUES(" . $id . ", '" . $class . "', '" . $name . "')";
		$result = $conn -> query($sql);
		if($result)
			$to_return['success'] = "User with id " . $id . " created succesfully.";
		else {
			$to_return['error'] = "AN unexpected error ocurred. Please refresh and try again.";
		}
	}
	header('Content-Type: application/json');
	echo json_encode($to_return);
}
?>
