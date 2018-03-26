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
<?php
	session_start();
	if(empty($_GET["email"]) || empty($_GET["password"])){
		echo '
			<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
			  <div class="container-fluid">
				<div class="well outter-well">
				  <div class="row">
					<h1 class="text-center ubuntu-font" style="font-size:50px;"><strong>Select a Game</strong></h1>
				  </div>
				  </br></br>
				  <form style="padding-left: 2.5%;">
				  <h1 class="text ubuntu-font" style="font-size:20px;"><strong>Error: malformed input, return to the previous page and try again.</strong></h1>
				  </form>
				<br></br><br></br>
				<div class="row">

				  <a class="btn btn-lg button-new col-xs-5 col-md-3" href="loadgame.html">Back</a>


				  <a class="btn btn-lg button-new col-xs-5 col-xs-offset-2 col-md-3 col-md-offset-6" href="index.html">Main Menu</a>


				</div>
			     </div>
			  </div>';
	}
	else{
		$mysqli = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

		$email = $_GET["email"];
		$_SESSION['email'] = $email;
		$pw = $_GET["password"];
		$row = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM `account` WHERE email = '$email'"));

		if($row['email'] != $email){
			echo '
				<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
				  <div class="container-fluid">
					<div class="well outter-well">
					  <div class="row">
						<h1 class="text-center ubuntu-font" style="font-size:50px;"><strong>Select a Game</strong></h1>
					  </div>
					  </br></br>
					  <form style="padding-left: 2.5%;">
					  <h1 class="text ubuntu-font" style="font-size:20px;"><strong>Error: no account found for given Email.</strong></h1>
					  </form>
					<br></br><br></br>
					<div class="row">

					  <a class="btn btn-lg button-new col-xs-5 col-md-3 col-md-offset-6" href="loadgame.html">Back</a>


					  <a class="btn btn-lg button-new col-xs-5 col-xs-offset-2 col-md-3 col-md-offset-6" href="index.html">Main Menu</a>

					</div>
				     </div>
				  </div>';
		}

		else if($row['pw'] != $pw){
			echo '
				<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
				  <div class="container-fluid">
					<div class="well outter-well">
					  <div class="row">
						<h1 class="text-center ubuntu-font" style="font-size:50px;"><strong>Select a Game</strong></h1>
					  </div>
					  </br></br>
					  <form style="padding-left: 2.5%;">
					  <h1 class="text ubuntu-font" style="font-size:20px;"><strong>Error: wrong password, return to the previous page and try again.</strong></h1>
					  </form>
					<br></br><br></br>
					<div class="row">

					  <a class="btn btn-lg button-new col-xs-5 col-md-3 col-md-offset-6" href="loadgame.html">Back</a>


					  <a class="btn btn-lg button-new col-xs-5 col-xs-offset-2 col-md-3 col-md-offset-6" href="index.html">Main Menu</a>

					</div>
				     </div>
				  </div>';
		}
		else{
		 header("Location: startParams.php");
		 exit(0);
		}
	}
?>

</body>
