<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>CTIS Clock</title>

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
			<?php include('navbar.php'); ?>

			<div id="page-wrapper">
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">Administrator</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->

				<!-- /.row -->
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-warning">
							<div class="panel-heading">
								<div class="row">
									<div class="col-md-offset-5">
										<div class="huge">
											Add
										</div>
									</div>
								</div>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="form-group">
										<div class="col-md-10 col-md-offset-1">
											<div class="form-group">
												<label class="control-label">Name:</label>
                                            	<input id="name" class="form-control">
											</div>
											<div class="form-group">
												<label class="control-label">Classification:</label>
                                            	<input id="classification" class="form-control">
											</div>
											<div class="form-group">
												<label class="control-label">ID:</label>
                                            	<input id="id" class="form-control">
                                            	<p class="help-block">If left empty, id will be generated automatically</p>
											</div>
										</div>
                                            
                                            <div class="col-md-8 col-md-offset-2">
                                            	<button type="submit" id="submit" class="vert-offset-top-1 btn btn-success btn-default btn-block">Create Employee</button>
                                            </div>
                                            
                                        </div>
								</div>
							</div>
							
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
		
		<!-- create user -->
		<script>
		//TODO: Handle when user id already exists and when success
			$('#submit').click(submit);
			function submit(){
				var name = $('#name').val();
				var classif = $('#classification').val();
				var id = $('#id').val();
				if(name.length * classif.length){
					if(id.length == 0){
						id = Math.floor(Math.random() * (9999 - 1000)) + 1000;
					}
					$.post('user.php', {'add': true, 'name': name, 'class': classif, 'id': id}, function(data){
						console.log(data);
					});
				}
				else{
					if(classif.length){
						$('#name').parent('.form-group').addClass('has-error');
						$('#name').siblings('label').append(document.createTextNode(" Must not be empty"));						
					}
					else if(name.length){
						$('#classification').parent('.form-group').addClass('has-error');
						$('#classification').siblings('label').append(document.createTextNode(" Must not be empty"));
					}
					else{
						$('#name').parent('.form-group').addClass('has-error');
						$('#name').siblings('label').append(document.createTextNode(" Must not be empty"));
						$('#classification').parent('.form-group').addClass('has-error');
						$('#classification').siblings('label').append(document.createTextNode(" Must not be empty"));
					}
				}
			}
		</script>

	</body>

</html>
