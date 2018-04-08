<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <title>FS League User Hub</title>

	<?php 
	
	session_start();
	
	$dual_valueOrig = $_GET["gridRadios"];;
	$dual_value = explode (",",$dual_valueOrig);
	
	$session = $dual_value[0];
	$gm_email = $dual_value[1];
	
	$_SESSION['session_name'] = $session;
	$_SESSION['GM_email'] = $gm_email;
	    
    ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>

  <link rel="stylesheet" href="css/style.css">
</head>

<body>
<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <div class="container-fluid">
    <div class="well outter-well">
<div class="row">
  <h1 class = "text-center ubuntu-font funkyfont" style="font-size:50px;"><strong>User Portfolio</strong></h1>
</div>
<div class="row">
  <a class="btn btn-lg button-new ubuntu-font" style = "margin: 5px 0px 5px 0px; padding: 2px 15px" href="buy_sell.php">Buy/Sell</a>
</div>
  <br><br\>
<div class="row">
  <a class="btn btn-lg button-new ubuntu-font" style = "margin: 5px 0px 5px 0px; padding: 2px 15px" href="#">Show Friends' Scores</a>
</div>
  <br><br\>
<div class="row">
  <a class="btn btn-lg button-new ubuntu-font" style = "margin: 5px 0px 5px 0px; padding: 2px 15px" href="http://fsleague.website">Main Menu</a>
</div>
</div>
</div>
</body>
