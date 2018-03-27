<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <title>FS League - Join Game</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>

  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
<div class="container-fluid">
<div class="well outter-well">
  <div class="row">
  <h1 class="text-center ubuntu-font" style="font-size:50px;"><strong>Select a Game</strong></h1>
  </div>
  </br></br>
  <form action="userHub.html" method="get" style="padding-left: 2.5%;">
  <fieldset class="form-group">
    <div class="row">
    <legend class="col-xs-3">Available games:</legend>
    </div>
    <div class="row">
    <div class="col-xs-10">
    
      <div class="form-check">
      <label class="form-check-label">
      
      <?php
      	session_start();
      	$email = $_SESSION['email'];
      	$connection = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
      	$sql = mysqli_query($connection, "SELECT `session_name` FROM `session_player_data` WHERE email_INV = '$email'");
      	while ($row = $sql->fetch_assoc()){
      ?>
      <br>
      <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios<?php echo $count; ?>" value="option<?php echo $count; ?>" checked>
        <?php echo $row['session_name']; ?></input>
        </br>
        <?php } ?>
      </label>
      </div>
    </div>
    </div>
  </fieldset>
  <div class="row">
    <button class="btn button-new col-xs-3" type="submit">Join</button>
  </div>
  </form>
<br></br><br></br>
<div class="row">
<div class="col-xs-4 col-md-6">
  <a class="btn button-new col-xs-3" href="loadgame.html">Back</a>
</div>
<div class="col-xs-4 col-md-6">
  <a class="btn button-new col-xs-3" href="index.html">Main Menu</a>
</div>
</div>
</div>
</div>
</body>