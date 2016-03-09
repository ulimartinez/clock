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
				$sql = "SELECT * FROM employees";
				$response = $conn -> query($sql);
				$users = array();
				while ($row = $response -> fetch_assoc()) {
					array_push($users, $row);

				}
				?>
				<div class="row">
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
											<label for="name">Name</label>
											<input type="text" class="form-control" id="name" placeholder="Someone">
										</div>
										<div class="form-group">
											<label for="class">Class</label>
											<input type="text" class="form-control" id="class" placeholder="Something">
											<label for="id">Id</label>
											<input type="text" class="form-control" id="id" placeholder="0000">
										</div>

									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">
										Cancel
									</button>
									<button type="button" class="btn btn-danger" id="delete">
										Delete User
									</button>
									<button type="button" class="btn btn-primary" id="save">
										Save changes
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12">
						<h1 class="page-header">Employees</h1>
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
									<th>Class</th>
									<th>ID</th>
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($users as $tr) {
									echo "<tr>
									<td class=\"name\">" . $tr['Name'] . "</td><td>" . $tr['Class'] . "</td><td>" . $tr['ID'] . "</td><td class=\"edit\"><a href=\"#\"><span class=\"pull-right\"><i class=\"fa fa-gear\"></i></span></a></td>
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
		$('.edit').click(function(e) {
				//alert($(e.target).closest('tr').find('td.name').text());
				var name = $(e.target).closest('tr').find('td.name').text();
				var classif = $(e.target).closest('tr').find('td.name').next('td').text();
				var id = $(e.target).closest('tr').find('td.name').next('td').next('td').text();
				$('#name').val(name);
				$('#class').val(classif);
				$('#id').val(id);
				$('#myModal').modal('show');
				console.log($(e.target).closest('tr').children());
				$('#delete').click(function() {
					var procede = confirm("Are you sure?");
					if (procede) {
						$.post('user.php', {
							'delete' : $('#id').val()
						}, function() {
							$('#name').val('deleted');
							$('#id').val('deleted');
							$('#class').val('deleted');
							$(e.target).closest('tr').find('td.name').text('deleted');
							$(e.target).closest('tr').find('td.name').next('td').text('deleted');
							$(e.target).closest('tr').find('td.name').next('td').next('td').text('deleted');
							$('#myModal').modal('hide');
						})
					}
				});
				$('#save').click(function() {
					name = $('#name').val();
					classif = $('#class').val();
					id = $('#id').val();
					$.post('user.php', {
						'saved' : 'true',
						'name' : name,
						'class' : classif,
						'id' : id
					}, function(data){
						if('error' in data)
						{
							$('#message').remove();
							$('.modal-footer').prepend("<a class=\"btn btn-warning\" id=\"message\">" + data['error'] + "</a>");
						}
						else if ('success' in data)
						{
							$('#message').remove();
							$('.modal-footer').prepend("<a data-dismiss=\"modal\" class=\"btn btn-success\" id=\"message\">" + data['success'] + "</a>");
							$(e.target).closest('tr').find('td.name').text(name);
							$(e.target).closest('tr').find('td.name').next('td').text(classif);
							$(e.target).closest('tr').find('td.name').next('td').next('td').text(id);
						}
						
					});
				});
			});
$('table').DataTable();

</script>

</body>

</html>
