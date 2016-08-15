<?php
function timeIn($seconds) {
	if (is_null($seconds)) {
		return "";
	} else {
		$time = intval($seconds);
	}
	if ($time < 60) {
		return $time . " seconds";
	} else if ($time < (60 * 60)) {
		return round($time / 60) . " minutes";
	} else if ($time < 60 * 60 * 24) {
		return round($time / (60 * 60)) . " hours and " . ($time / 60) % 60 . " minutes";
	}
}

function get_periods() {//gets 4 time periods, the half of month we are in today, and three previous ones
	$drop_down = array();
	$now = new DateTime();
	$now = $now -> format('j-n-y');
	$now = explode('-', $now);
	$curr = "";
	if ($now[1] >= 2) {//feb and on
		if ($now[0] > 15) {//today is in second half of month
			$drop_down = [($now[1] - 1) . '/1 - ' . ($now[1] - 1) . '/15', ($now[1] - 1) . "/15 - " . ($now[1] - 1) . '/' . cal_days_in_month(CAL_GREGORIAN, $now[1], $now[2]), ($now[1]) . "/1 - " . $now[1] . '/15', $now[1] . "/15 - " . $now[1] . "/" . $now[0]];
		} else {//today is in first half of month
			$drop_down = [($now[1] - 2) . "/15 - ". ($now[1] - 2) . "/" . cal_days_in_month(CAL_GREGORIAN, $now[1] - 2, $now[2]),($now[1] - 1) . "/1 - " . ($now[1] - 1) . "/15",($now[1] - 1) . "/15 - " . ($now[1] - 1) . "/" . cal_days_in_month(CAL_GREGORIAN, $now[1] - 1, $now[2]),($now[1]) . "/1 - " . ($now[1]) . "/" . ($now[0])];
		}
	}
	else if ($now[1] == 1){//we are in jan, previous periods are in last year
		if ($now[0] > 15) {//second half
			$drop_down = [(12) . '/1 - ' . (12) . '/15', (12) . "/15 - " . (12) . '/' . cal_days_in_month(CAL_GREGORIAN, $now[1], $now[2]), ($now[1]) . "/1 - " . $now[1] . '/15', $now[1] . "/15 - " . $now[1] . "/" . $now[0]];
		} else {//first half
			$drop_down = [(11) . "/15 - ". (11) . "/" . cal_days_in_month(CAL_GREGORIAN, 11, $now[2]),(12) . "/1 - " . (12) . "/15",(12) . "/15 - " . (12) . "/" . cal_days_in_month(CAL_GREGORIAN, 12, $now[2]),($now[1]) . "/1 - " . ($now[1]) . "/" . ($now[0])];
		}
	}

	return $drop_down;
}
session_start();
if(isset($_SESSION['user'])){
	$id = $_SESSION['user'];
}
else{
	header("Location: timesheetlogin.php"); /* Redirect browser */
	exit();
}
$options = get_periods();

//todays transactions
require("config.php");
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if ($conn -> connect_error) {
	die("Connection failed: " . $con -> connecterror);
}
$sql = "SELECT * FROM logs WHERE id = $id AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)";
$respoinse = $conn -> query($sql);
$transactions = array();
$total = 0;
if($respoinse->num_rows > 0){
	while ($row = $respoinse -> fetch_assoc()) {
		array_push($transactions, $row);
	}
	for ($i = 0; $i < $respoinse -> num_rows; $i++) { //TODO: make this not O(n^2) can store the id's and names in a table
		if ($transactions[$i]['checkedIn'] === '1') {
			$transactions[$i]['checkedIn'] = "Clocked IN";
		} else {
			$transactions[$i]['checkedIn'] = "Clocked OUT";
			$total += $transactions[$i]['time'];
		}
	}
}
$sql2 = "SELECT Name FROM employees WHERE ID = " . $id;
$getName = $conn -> query($sql2);
if($getName->num_rows){
	$row2 = $getName -> fetch_assoc();
	$name = $row2['Name'];
}
else{
	header('Location: timesheetlogin.php?logout=298uf984j');
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Employee Logs</title>

		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.css" rel="stylesheet">

		<!-- MetisMenu CSS -->
		<link href="css/metisMenu.css" rel="stylesheet">

		<!-- Timeline CSS -->
		<link href="css/timeline.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="css/sb-admin-2.css" rel="stylesheet">

		<!-- Morris Charts CSS -->
		<link href="css/morris.css" rel="stylesheet">

		<!-- Tables CSS -->
		<link href="css/dataTables.css" rel="stylesheet">

		<!-- custom for vert offset CSS -->
		<link href="css/custom.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

	</head>

	<body>

		<div id="page-wrapper-full">
			<div class="row vert-offset-top-1">
				<div class="col-lg-3">
					<a class="btn btn-danger" href=<?php echo '"timesheetlogin.php?logout='.$id.'"'; ?> role="button" id="back"><span class="glyphicon glyphicon-chevron-left"></span> Back</a>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">Employee Logs</h1>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			<!-- /.row -->

			<!-- /.row -->
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="row">
						<div class="col-md-4">
							<label class="col-sm-2 control-label">Period:</label>
						</div>

						<div class="col-md-8">
							<select class="form-control" id="periods" autocomplete="off">
								<option selected style="display: none">Last 24 hours</option>
								<?php
								foreach ($options as $period) {
									echo "<option>" . $period . "</option>";
								}
								?>
							</select>
						</div>

					</div>
					<div class="row vert-offset-top-3" id="table-area">
						<table class="table table-striped" id="periodTable">
							<thead>
								<tr>
									<th>Name</th>
									<th>Action</th>
									<th>Date</th>
									<th>Time</th>
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($transactions as $tr) {
									echo "<tr>
<td>" . $name . "</td><td>" . $tr['checkedIn'] . "</td><td>" . $tr['date'] . "</td><td>" . timeIn($tr['time']) . "</td>";
									if ($tr['checkedIn'] === "Clocked OUT") {
										echo "<td class=\"edit\"><a href=\"#\"><span class=\"pull-right\"><i class=\"fa fa-gear\"></i></span></a></td>";
									} else {
										echo "<td></td>";
									}
									echo "</tr>";
								}
								echo "<tfoot data-seconds=\"" . $total . "\"><td>Total:</td><td></td><td></td><td>" . timeIn($total) . "</td></tfoot>";
								?>
							</tbody>
						</table>
					</div>

				</div>

			</div>
				<!-- /.row -->
			<div class="row vert-offset-bottom-12" style="padding-bottom: 200px;">
				<div class="col-lg-3 col-lg-offset-9">
					<a style="visibility: hidden;" class="btn btn-success" href="#" role="button" id="print">Generate Timesheet <span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
			</div>
		</div>
		<!-- /#wrapper -->

		<!-- jQuery -->
		<script src="js/jquery.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.js"></script>

		<!-- Metis Menu Plugin JavaScript -->
		<script src="js/metisMenu.js"></script>

		<!-- Morris Charts JavaScript -->
		<script src="js/raphael.js"></script>

		<!-- Custom Theme JavaScript -->
		<script src="js/sb-admin-2.js"></script>

		<!-- Tables JavaScript -->
		<script src="js/dataTables.js"></script>

		<script>
			//where is this used?
			function strip_tags(html) {
				var tmp = document.createElement("div");
				tmp.innerHTML = html;
				return tmp.textContent || tmp.innerText;
			}

			//what is this?
			Number.prototype.padLeft = function(base, chr) {
				var len = (String(base || 10).length - String(this).length) + 1;
				return len > 0 ? new Array(len).join(chr || '0') + this : this;
			}
			//function to get a text representation of the duration in seconds
			function timeIn(seconds) {
				if (seconds < 60) {
					return seconds + " seconds";
				} else if (seconds < 60 * 60) {
					return Math.floor(seconds / 60) + " minutes";
				} else if (seconds < 60 * 60 * 24) {
					return Math.floor(seconds / (60 * 60)) + " hours and " + ((seconds / 60) % 60) + " minutes";
				}
			}


			$(document).ready(function() {
				//create the datatable
				var table = $('#periodTable').DataTable({
					paging : false,
					scrollY : 400
				});
			});

			//when you select an option
			$('#periods').change(function(e) {
				$('#print').attr('style', null);
				var str = $('#periods :selected').text();
				//remove spaces
				str = str.replace(/ /g, '');
				var dates = str.split("-");
				$.post('getperiodpub.php', {
					'start' : dates[0],
					'end' : dates[1],
					'id': <?php echo $id; ?>
				}, function(data) {
					$('#table-area').empty();
					$('#table-area').html(data);
					$('#periodTable').DataTable({
						paging : false,
						scrollY : 400
					});
				});

			});
			$('#print').click(function(e){
				redirectPost('timesheetprint.php', {id: <?php echo $id; ?>, totalTime: $('tfoot').data('seconds'), period: $('#periods :selected').text()});
			});
			function redirectPost(location, args){
		        var form = $('<form></form>');
		        form.attr("method", "post");
		        form.attr("action", location);

		        $.each( args, function( key, value ) {
		            var field = $('<input></input>');

		            field.attr("type", "hidden");
		            field.attr("name", key);
		            field.attr("value", value);

		            form.append(field);
		        });
		        $(form).appendTo('body').submit();
		    }
		</script>

	</body>

</html>
