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

function get_periods() {
	$drop_down = array();
	$now = new DateTime();
	$now = $now -> format('j-n-y');
	$now = explode('-', $now);
	$curr = "";
	if ($now[1] >= 2) {
		if ($now[0] > 15) {
			$drop_down = [($now[1] - 1) . '/1 - ' . ($now[1] - 1) . '/15', ($now[1] - 1) . "/15 - " . ($now[1] - 1) . '/' . cal_days_in_month(CAL_GREGORIAN, $now[1], $now[2]), ($now[1]) . "/1 - " . $now[1] . '/15', $now[1] . "/15 - " . $now[1] . "/" . $now[0]];
		} else {
			$drop_down = [($now[1] - 2) . "/15 - ". ($now[1] - 2) . "/" . cal_days_in_month(CAL_GREGORIAN, $now[1] - 2, $now[2]),($now[1] - 1) . "/1 - " . ($now[1] - 1) . "/15",($now[1] - 1) . "/15 - " . ($now[1] - 1) . "/" . cal_days_in_month(CAL_GREGORIAN, $now[1] - 1, $now[2]),($now[1]) . "/1 - " . ($now[1]) . "/" . ($now[0])];
		}
	}
	else if ($now[1] == 1){
		if ($now[0] > 15) {
			$drop_down = [(12) . '/1 - ' . (12) . '/15', (12) . "/15 - " . (12) . '/' . cal_days_in_month(CAL_GREGORIAN, $now[1], $now[2]), ($now[1]) . "/1 - " . $now[1] . '/15', $now[1] . "/15 - " . $now[1] . "/" . $now[0]];
		} else {
			$drop_down = [(11) . "/15 - ". (11) . "/" . cal_days_in_month(CAL_GREGORIAN, 11, $now[2]),(12) . "/1 - " . (12) . "/15",(12) . "/15 - " . (12) . "/" . cal_days_in_month(CAL_GREGORIAN, 12, $now[2]),($now[1]) . "/1 - " . ($now[1]) . "/" . ($now[0])];
		}
	}

	return $drop_down;
}

$options = get_periods();

//todays transactions
$conn = new mysqli("localhost", "root", "1969", "clock");
if ($conn -> connect_error) {
	die("Connection failed: " . $con -> connecterror);
}
$sql = "SELECT * FROM logs WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)";
$respoinse = $conn -> query($sql);
$transactions = array();
while ($row = $respoinse -> fetch_assoc()) {
	array_push($transactions, $row);
}
for ($i = 0; $i < $respoinse -> num_rows; $i++) { //TODO: make this not O(n^2) can store the id's and names in a table
	$id = $transactions[$i]['ID'];
	$sql2 = "SELECT Name FROM employees WHERE ID = " . $id;
	$getName = $conn -> query($sql2);
	$row2 = $getName -> fetch_assoc();
	$name = $row2['Name'];
	$transactions[$i]['ID'] = $name;
	if ($transactions[$i]['checkedIn'] === '1') {
		$transactions[$i]['checkedIn'] = "Clocked IN";
	} else {
		$transactions[$i]['checkedIn'] = "Clocked OUT";
	}
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

		<div id="wrapper">

			<!-- Navigation -->
			<?php
			include ('navbar.php');
			?>

			<div id="page-wrapper">
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog2" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h4 class="modal-title" id="myModalLabel">Modal title</h4>
							</div>
							<div class="modal-body">
								<form class="form-inline">
									<div class="form-group">
										<label for="hours">Hours</label>
										<input type="number" class="form-control" id="hours" placeholder="0">
									</div>
									<div class="form-group">
										<label for="mins">Minutes</label>
										<input type="number" class="form-control" id="mins" placeholder="0">
									</div>

								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">
									Cancel
								</button>
								<button type="button" class="btn btn-primary" id="save">
									Save changes
								</button>
							</div>
						</div>
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
<td>" . $tr['ID'] . "</td><td>" . $tr['checkedIn'] . "</td><td>" . $tr['date'] . "</td><td>" . timeIn($tr['time']) . "</td>";
										if ($tr['checkedIn'] === "Clocked OUT") {
											echo "<td class=\"edit\"><a href=\"#\"><span class=\"pull-right\"><i class=\"fa fa-gear\"></i></span></a></td>";
										} else {
											echo "<td></td>";
										}
										echo "</tr>";
									}
									?>
								</tbody>
							</table>
						</div>

					</div>

				</div>
				<!-- /.row -->
			</div>
			<!-- /#page-wrapper -->

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
			//create a csv from the table to be able to download it
			function table2csv(tableElm) {
				var csv = '';
				var headers = [];
				var rows = [];

				// Get header names
				$(tableElm + ' thead').find('th').each(function() {
					var $th = $(this);
					var text = $th.text();
					var header = '"' + text + '"';
					headers.push(header);
				});
				csv += headers.join(',') + "\n";

				// get table data
				$(tableElm + ' tbody').find('tr').each(function(i, e) {
					var $td = $(e);
					var text = "";
					$td.children().each(function(i, e) {
						text += '"' + $(e).text() + '",';
					});
					text = text.substring(0, text.length - 1);
					var row = text;
					rows.push(row);
				});
				csv += rows.join("\n");
				return csv;

			}
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
			$('#periods option').click(function(e) {
				var str = $('#periods :selected').text();
				//remove spaces
				str = str.replace(/ /g, '');
				var dates = str.split("-");
				$.post('getperiod.php', {
					'start' : dates[0],
					'end' : dates[1]
				}, function(data) {
					$('#table-area').empty();
					$('#table-area').html(data);
					$('#periodTable').DataTable({
						paging : false,
						scrollY : 400
					});
				});

			});
			
			$('#export').bind('click', function(event) {
				event.preventDefault();
				var file = table2csv('#periodTable');
				$.post('csv.php', {
					'csv' : file
				}, function(data) {
					$('#export').attr({
						'download' : $('#periods :selected').text() + ".csv",
						'href' : "data:application/csv;charset=utf-8," + encodeURIComponent(data),
						'target' : '_blank'
					});

				}).done(function() {
					$('#export').unbind('click');
					$('#export')[0].click();
				});
			});
			var unmodified = true;
			$('#table-area').delegate('.edit', 'click', function(e) {
				console.log($('#save'));
				//alert($(e.target).closest('tr').find('td.name').text());
				var row = $(e.target).closest('tr').children();
				var time = $(row[3]).text();
				var minutes = time.match(/(\d+) (?:minutes|minutes)/);
				var hours = time.match(/(\d+) (?:hours|hours)/)
				if (minutes != null) {
					$('#mins').val(minutes[1]);
				}
				if (hours != null) {
					$('#hours').val(hours[1]);
				}
				$('#myModal').modal('show');
				$('#save').bind('click', function() {
					if (true) {
						var $prev = $(e.target).closest('tr').prev();
						var cells = $prev.children();
						var timestamp = $(cells[2]).text();
						var validTimestamp = timestamp.split(" ");
						var startdate = new Date(validTimestamp[0] + "T" + validTimestamp[1]);
						var seconds = startdate.getTime() / 1000;
						var old = $(row[2]).text();
						var added = ($('#mins').val() * 60) + ($('#hours').val() * 60 * 60);
						var newTime = seconds + added;
						var d = new Date(newTime * 1000),
						    dformat = [d.getFullYear(), (d.getMonth() + 1).padLeft(), d.getDate().padLeft()].join('-') + ' ' + [d.getHours().padLeft(), d.getMinutes().padLeft(), d.getSeconds().padLeft()].join(':');
						$.post('user.php', {
							'override' : 'true',
							'old' : old,
							'new' : dformat,
							'seconds' : added
						}, function(data) {
							if ('error' in data) {
								$('#message').remove();
								$('.modal-footer').prepend("<a class=\"btn btn-warning\" id=\"message\">" + data['error'] + "</a>");
							} else if ('success' in data) {
								$('#message').remove();
								$('.modal-footer').prepend("<a data-dismiss=\"modal\" class=\"btn btn-success\" id=\"message\">" + data['success'] + "</a>");
								$(row[2]).text(dformat);
								$(row[3]).text(timeIn(added));
							} else{
								$('#message').remove();
								$('.modal-footer').prepend("<a data-dismiss=\"modal\" class=\"btn btn-success\" id=\"message\">Something went wrong</a>");
							}

						});
					} else {
						$('#message').remove();
						$('.modal-footer').prepend("<a href=\"tableall.php\" class=\"btn btn-warning\" id=\"message\">Can't edit if order changed, please click here</a>");
					}

				});
				console.log(row[2]);

			});
			$('#myModal').on('hidden.bs.modal', function() {
				$('#mins').val(0);
				$('#hours').val(0);
				$('#message').remove();
				$('#save').unbind('click');
				console.log("removed bind");
			});
		</script>

	</body>

</html>
