<?php session_start();
if (isset($_POST['submit'])) {

	if (empty($_POST['username'])) {
		header('Location: login.php?id=0');
	} else if (empty($_POST['password'])) {
		header('Location: login.php?name=0');
	} else {
		$str = "Congrats, you did it correctly";
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
		$conn = new mysqli("129.108.32.61", "ctis", "19691963", "clock");
		// Check connection
		if ($conn -> connect_error) {
			die("Connection failed: " . $con -> connecterror);
		}
		//check if user exists in database
		$sql = "SELECT * FROM admins WHERE username = \"" . $_SESSION['username'] . "\"";
		$result = $conn -> query($sql);
		if ($result -> num_rows > 0) {
			//exists
		} else {
			header('Location: login.php?error=1');
			//doesnt exist
		}
	}

	$conn -> close();

}
//rederict user if he hasn't logged in
else if (!(isset($_SESSION['username']) AND !empty($_SESSION['password']))) {
	$str = "I don't know how you got here";
	header('Location: login.php');
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
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Administrator</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->

				<!-- /.row -->
				<div class="row vert-offset-top-6">
					<div class="col-md-5 col-md-offset-1">
						<div class="panel panel-success">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-circle fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">
											View active
										</div>
									</div>
								</div>
							</div>
							<a href="tableloggedin.php">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div> </a>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-plus fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">
											Add
										</div>
									</div>
								</div>
							</div>
							<a href="adduser.php">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div> </a>
						</div>
					</div>
					<div class="col-md-5">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-calendar fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">
											View Period
										</div>
									</div>
								</div>
							</div>
							<a href="tableall.php">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div> </a>
						</div>
						<div class="panel panel-warning">
							<div class="panel-heading">
								<div class="row">
									<div class="col-xs-3">
										<i class="fa fa-edit fa-5x"></i>
									</div>
									<div class="col-xs-9 text-right">
										<div class="huge">
											Edit
										</div>
									</div>
								</div>
							</div>
							<a href="edit.php">
							<div class="panel-footer">
								<span class="pull-left">View Details</span>
								<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
								<div class="clearfix"></div>
							</div> </a>
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

	</body>

</html>
