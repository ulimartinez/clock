<?php
	if (isset($_GET['out']))
	{
		session_start();
		$_SESSION = array();
	}
	if (isset($_GET['id']))
	{
		$id = $_GET['id'];
		if (!$id)
		{
			$form = "<div class=\"form-group has-error\">
  						<label class=\"control-label\" for=\"inputError1\">Please enter username</label>
  						<input type=\"text\" class=\"form-control\" id=\"inputError1\" placeholder=\"Username\" name=\"username\" autofocus>
					</div>";
		}
	}
	else {
		$form = "<div class=\"form-group\">
                 	<input class=\"form-control\" placeholder=\"Username\" name=\"username\" type=\"text\" autofocus>
                 </div>";
	}
	if (isset($_GET['name']))
	{
		$name = $_GET['name'];
		if (!$name)
		{
			$form2 = "<div class=\"form-group has-error\">
  						<label class=\"control-label\" for=\"inputError2\">Please enter password</label>
  						<input type=\"password\" class=\"form-control\" id=\"inputError2\" placeholder=\"Password\" name=\"password\">
					</div>";
		}
	}
	else {
		$form2 = "<div class=\"form-group\">
                 	<input class=\"form-control\" placeholder=\"Password\" name=\"password\" type=\"password\">
                 </div>";
	}
	if (isset($_GET['error']))
	{
		$id = $_GET['error'];
		if ($id)
		{
			$form = "<div class=\"form-group has-error\">
  						<label class=\"control-label\" for=\"inputError1\">Invalid Username or password</label>
  						<input type=\"text\" class=\"form-control\" id=\"inputError1\" placeholder=\"Username\" name=\"username\" autofocus>
					</div>";
					$form2 = "<div class=\"form-group has-error\">
  						<input type=\"password\" class=\"form-control\" id=\"inputError2\" placeholder=\"Password\" name=\"password\">
					</div>";
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

    <title>Admin training</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!--custom -->
    <link href="css/screen.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="css/font-awesome.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="login">
    <div class="container" id="bordered">
       
        
        
        <div class="row vert-offset-top-12">
        	<div class="col-md-7 col-md-offset-2">
        		<div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form action="admin.php" role="form" method="post">
                            <fieldset>
                                <?php echo $form; ?>
                                <?php echo $form2; ?>
                                
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="Enter" />
                                
                            </fieldset>
                        </form>
                    </div>
                </div>
        	</div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.js"></script>

    

    <!-- Custom Theme JavaScript -->


</body>

</html>
