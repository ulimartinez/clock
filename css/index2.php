
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Welcome to CTIS</title>

	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/custom.css" rel="stylesheet">
	<link href="css/screen.css" rel="stylesheet">

</head>

<body>

	<div id="outer">

		<div id="clockdigital">
			<img alt="Clocks hours" id="digitalhour" src="image/digitalhours.gif" style="transform: rotate(180deg);">
			<img alt="Clocks minutes" id="digitalminute" src="image/digitalminutes.gif" style="transform: rotate(150deg);">
			<img alt="Clocks seconds" id="digitalsecond" src="image/digitalseconds.gif" style="transform: rotate(55deg);">
			<div class="topgradient" style="opacity: 0.8;">
				&nbsp;
			</div>
			<div style="opacity: 0.8;">
				&nbsp;
			</div>
		</div>

		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">

						<h4 class="modal-title" id="myModalLabel">Welcome!</h4>
					</div>
					<div class="modal-body">
						...
					</div>
				</div>
			</div>
		</div>
		<div id="container" class="panel default-panel">
			<h3>CTIS </h3>
			<center>
				<div class="row">
					<div class="col-md-3" style="display: inline">
						<input type="password" size="6" id="digit-one">
					</div>
					<div class="col-md-3" style="display: inline">
						<input type="password" size="6" readonly id="digit-two">
					</div>
					<div class="col-md-3" style="display: inline">
						<input type="password" size="6" readonly id="digit-three">
					</div>
					<div class="col-md-3" style="display: inline">
						<input type="password" readonly size="6"  id="digit-four">
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
	</div>

	<!-- jQuery -->
	<script src="js/jquery.js"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js"></script>

	<!-- clock-->
	<script type="text/javascript" src="js/joncombe.js"></script>
	<script type="text/javascript" src="js/css-clocks.js"></script>

	<script>
	function timeIn(seconds) {
		if (seconds < 60) {
			return seconds + " seconds";
		} else if (seconds < 60 * 60) {
			return (seconds / 60).toFixed(2) + " minutes";
		} else if (seconds < 60 * 60 * 24) {
			return Math.floor(seconds / (60 * 60)) + " hours and " + ((seconds / 60) % 60).toFixed(2) + " minutes";
		}
	}

	var str = "";
	$('.num').on('click', function(e) {
		$(e.target).css('background-color', '#dadada');
		timeoutID = window.setTimeout(function() {
			$(e.target).css('background-color', '#f3f3f3');
		}, 100);
		var digits = $('input');
		$.each(digits, function(f) {
			if (!$(digits[f]).val()) {
				var txt = $(e.target).text();
						//txt.replace(/^\s+|\s+$/g,'');
						console.log(txt);
						$(digits[f]).val(txt);
						str += txt;
						return false;
					}
					//console.log(digits[e]);
				});

		if ($('#digit-four').val()) {
			console.log('call the update thing with ' + str);
			$('.modal-body').text("User with id " + str + "attempted to clock in from remote location.");
			$('#myModal').modal('show');
			timeoutID = window.setTimeout(function() {
				$('#myModal').modal('hide');
			}, 6000);

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
});

</script>
</body>

</html>
