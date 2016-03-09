<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>SB Admin 2 - Bootstrap Admin Theme</title>

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
				<?php //todays transactions
				$conn = new mysqli("129.108.32.61", "ctis", "19691963", "clock");
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
				for ($i = 0; $i < count($latest); $i++) {
					$id = $latest[$i]['ID'];
					$sql2 = "SELECT Name FROM employees WHERE ID = " . $id;
					$getName = $conn -> query($sql2);
					$row2 = $getName -> fetch_assoc();
					$name = $row2['Name'];
					$latest[$i]['ID'] = $name;
					
				}
				?>
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Logged In Users</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->

				<!-- /.row -->
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Name</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($latest as $tr)
								{
									echo "<tr>
												<td>" . $tr['ID'] . "</td><td>" . $tr['date'] . "</td><td><a href=\"#\" class=\"kickout\">Force out</a></td>
										  </tr>";
								}
								?>
							</tbody>
						</table>
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
			$('.kickout').click(function (e){
				e.preventDefault();
				var row = $(e.target).closest('tr');
				var cells = $(row).children();
				var person = $(cells[0]).text();
				console.log(person);
				$.post('user.php', {'kickout': 'true', 'person': person}, function(){
					$(row).remove();
				})
				
			})
		</script>

	</body>

</html>
