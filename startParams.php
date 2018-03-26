<!DOCTYPE html>
<html lang = "en">

<head>
	<meta charset="UTF-8">

   	<title>Fantasy Stock League</title>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  	<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>

	<link rel="stylesheet" href="css/style.css">

</head>

<body>

	<link href= "https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
	<div class = "container-fluid">
		<div class = "well outter-well">
			<form action = "" method = "get">
				<h1 class = "text-center ubuntu-font" style="font-size:50px"><strong>Startup Parameters</strong></h1>
				<br><br/>
				<?php
					session_start();
					$mysqli = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
					if (mysqli_connect_errno()){
						echo "Failed to connect to MySQL: " . mysqli_connect_error();
					}
					if(isset($_GET["gameName"], $_GET["timespan"], $_GET["stockLimit"], $_GET["startingCash"])){
						$gameName = $_GET["gameName"];
						$timespan = $_GET["timespan"];
						$dayTrading = (isset($_GET["dayTrading"]))? "TRUE" : "FALSE";
						$stockLimit = $_GET["stockLimit"];
						$startingCash = $_GET["startingCash"];
						$email = $_SESSION['email'];

						$validGameName = FALSE;
						$currentGames = array();
						$i = 0;
						$queryResult = mysqli_query($mysqli, "SELECT * FROM session_list WHERE session_name = '$gameName'");
						if($queryResult->num_rows == 0){
								$validGameName = TRUE;
						}
						if(!$validGameName){
							echo '<p class = "text-center ubuntu-font" style = "color: red">Game name is taken: Please try again</p>';
						}
						else{

							$date = new DateTime(date('Y-m-d'));
							$date->modify('+' . $timespan . ' day');
							$currDate = date('Y-m-d');
							$nextDate = $date->format('Y-m-d');
							mysqli_query($mysqli, "INSERT INTO session_list(email_GM, session_name, start_date, end_date,
							allow_DT, stock_limit, start_cash) VALUES ('$email', '$gameName', '$currDate', '$nextDate', '$dayTrading', $stockLimit, $startingCash)");
							header("Location: addFriends.html");
				 		 	exit(0);
						}
					}
				?>
				<div class = "row">
					<div class = "col-xs-4 col-xs-offset-4">
						<div class = "form-group text-left">
							<label class = "ubuntu-font" style = "font-size: 20px">Game Name:</label>
							<input type = "text" class = "form-control" id = "gameName" name = "gameName" placeholder = "Name of Game">
						</div>
					</div>
				</div>
				<div class = "row">
					<div class = "col-xs-3 col-xs-offset-1">
						<div class = "form-group text-left">
							<label class = "ubuntu-font" style = "font-size: 20px">Game length:</label>
							<input type = "number" class = "form-control" id = "timespan" name = "timespan" placeholder = "Game length (days)">
						</div>

						<div class="checkbox">
							<label class = "ubuntu-font" style = "font-size: 20px"><strong></label>
							<input type="checkbox" name = "dayTrading" value="">Day trading restricted</strong>
							</label>
						</div>

						<div class = "form-group text-left">
							<label class = "ubuntu-font" style = "font-size: 20px">Stock limit:</label>
							<input type = "number" class = "form-control" id = "stocklimit" name = "stockLimit" placeholder = "100">
						</div>

						<label class = "ubuntu-font" style = "font-size: 20px">Starting cash amount:</label>

						<div class = "input-group">
							<span class = "input-group-addon" id = startingcash>$</span>
							<input type = "number" step = "0.01" class = "form-control" id = "startingcash" name = "startingCash" placeholder = "0.00">
						</div>
					</div>
				</div>
				<br><br/>
				<div class = "row">
					<div class = "col-xs-6 col-xs-offset-1">
						<a class="btn-lg button-new ubuntu-font"  href="index.html">Back to Main Menu</a>
					</div>
					<div class = "col-xs-1 col-xs-offset-1">
						<input type = "submit" class="btn-lg button-new ubuntu-font">
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
