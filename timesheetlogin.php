<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable = no">

		<title>Welcome to CTIS</title>

		<!-- Bootstrap Core CSS -->
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
		<link href="css/screen.css" rel="stylesheet">

	</head>

	<body>

		<div id="outer">
			<a class="btn btn-default btn-lg" id="refresh" href="/clock"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
			<div class="col-md-6 col-md-offset-3 vert-offset-top-12">
				<div id="container-pub" class="panel default-panel">
					<h3>CTIS </h3>
					<center>
						<div class="row">
							<div class="col-md-3" style="display: inline">
								<input type="password" size="6" id="digit-one" maxlength="1">
							</div>
							<div class="col-md-3" style="display: inline">
								<input type="password" size="6" id="digit-two" maxlength="1">
							</div>
							<div class="col-md-3" style="display: inline">
								<input type="password" size="6" id="digit-three" maxlength="1">
							</div>
							<div class="col-md-3" style="display: inline">
								<input type="password" size="6"  id="digit-four" maxlength="1">
							</div>
						</div>
	
					</center>
					<div class="row">
						<div class="row vert-offset-top-1 col-md-10 col-md-offset-1">
							<div class="num text-center col-md-4 col-sm-4 col-xs-4">1</div>
							<div class="num text-center col-md-4 col-sm-4 col-xs-4">2</div>
							<div class="num text-center col-md-4 col-sm-4 col-xs-4">3</div>
						</div>
						<div class="row col-md-10 col-md-offset-1">
							<div class="num text-center col-md-4 col-sm-4 col-xs-4">4</div>
							<div class="num text-center col-md-4 col-sm-4 col-xs-4">5</div>
							<div class="num text-center col-md-4 col-sm-4 col-xs-4">6</div>
						</div>
						<div class="row col-md-10 col-md-offset-1">
							<div class="num text-center col-md-4 col-sm-4 col-xs-4">7</div>
							<div class="num text-center col-md-4 col-sm-4 col-xs-4">8</div>
							<div class="num text-center col-md-4 col-sm-4 col-xs-4">9</div>
						</div>
						<div class="row col-md-10 col-md-offset-1">
							<div class="clear col-md-4 col-sm-4 col-xs-4">
								<center>
									<h1 class="clear">CLR</h1>
								</center>
							</div>
							<div class="num text-center col-md-4 col-sm-4 col-xs-4">0</div>
							<div class="del col-md-4 col-sm-4 col-xs-4">
								<center>
									<h1 class="del">&lt-</h1>
								</center>
							</div>
						</div>
					</div>
				</div>
				<!-- end container -->
			</div>
			<!-- end col-md-6-->
			
		</div>

		<!-- jQuery -->
		<script src="js/jquery.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.js"></script>


		<script>
			function timeIn(seconds) {
				if (seconds < 60) {
					return seconds + " seconds";
				} else if (seconds < 60 * 60) {
					return (seconds / 60).toFixed(2) + " minutes";
				} else {
					return Math.floor(seconds / (3600)) + " hours and " + ((seconds / 60) % 60).toFixed(2) + " minutes";
				}
		}

		var str = "";
		$('.num').on('click', function(e) {
			e.preventDefault();
			$(this).css('background-color', '#dadada');
			var resetColor = function(div) {
				$(div).css('background-color', '#f3f3f3');
			}
			setTimeout(resetColor(this), 50);
			var digits = $('input');
			$.each(digits, function(f) {
				if (!$(digits[f]).val()) {
				var txt = $(e.target).text();
				//txt.replace(/^\s+|\s+$/g,'');
				$(digits[f]).val(txt);
				str += txt;
				return false;
			}
		//console.log(digits[e]);
		});

		if ($('#digit-four').val()) {
			console.log('call the update thing with ' + str);
			$.post('user.php', {
			'id' : str,
			'timesheet' : "true"
			}, function(data) {
				if(data.hasOwnProperty('session')){
					window.location = 'timesheet.php';
				}
			});
			
			

			//alert('Th1s dude logged in');
			$('.clear').trigger('click');
			str = "";
		}
		});
		$('.del').on('click', function(e) {
			var digits = $('input').get().reverse();
			$(digits).each(function(i) {
			if ($(digits[i]).val()) {
				$(digits[i]).val('');
				return false;
			}
		});
		str = str.substring(0, str.length - 1);
		})
		$('.clear').on('click', function(e) {
			$('input').val("");
			str = "";
		});
		$('input').on('keyup', function(){
			if($(this).prop('id') == "digit-one"){
				str += $(this).val();
				console.log(str);
				$('#digit-two').focus();
			}
			else if($(this).prop('id') == "digit-two"){
				str += $(this).val();
				$('#digit-three').focus();
			}
			else if($(this).prop('id') == "digit-three"){
				str += $(this).val();
				console.log(str);
				$('#digit-four').focus();
			}
			else if($(this).prop('id') == "digit-four"){
				str += $(this).val();
				$.post('user.php', {
				'id' : str,
				'timesheet' : "true"
				}, function(data) {
					if(data.hasOwnProperty('session')){
						window.location = 'timesheet.php';
					}
				});
			}
		});

		</script>
	</body>

</html>
