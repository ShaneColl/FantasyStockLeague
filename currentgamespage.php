<<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <title>FS League - Join Game</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>

  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
<div class="container-fluid">
<div class="well outter-well">
  <div class="row">
  <h1 class="text-center ubuntu-font" style="font-size:50px;"><strong>Account</strong></h1>
  </div>
  </br></br>
  <form action="userHub.php" method="get" style="padding-left: 2.5%;">
  <fieldset class="form-group">
    <div class="row">
      <legend class="col-xs-3 ubuntu-font">Available games:</legend>
      <legend class="col-xs-4 col-xs-offset-3 ubuntu-font">Player Stats:</legend>
    </div>
    <div class="row">
      <div class = "col-xs-6">
        <div class="btn-group" style = "display: block">

        <?php
        	session_start();
        	$email = $_SESSION['email'];
        	$connection = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
        	$sql = mysqli_query($connection, "SELECT* FROM `session_player_data` WHERE email_INV = '$email'");
        	while ($row = $sql->fetch_assoc()){
            $seshname = $row['session_name'];
            $emGM = $row['email_GM'];
            $sql2 = mysqli_query($connection, "SELECT* FROM `session_player_data` WHERE email_INV != '$email' AND session_name = '$seshname' AND
            email_GM = '$emGM'");
        ?>
        <button class="btn-md button-new ubuntu-font" title = "Score:         $<?php echo $row['total_score'] . "\r\n";?> Players: <?php
          while($playerRow = $sql2->fetch_assoc()){
            echo $playerRow['email_INV'] . ",";
          ?>
          <?php } ?>"
          style = "border-radius: 0px; box-shadow: 0 0 0 0; width: 50%; display:block" type="submit" name="gridRadios" value="<?php echo $row['session_name']; ?>,<?php echo $row['email_GM']; ?>">
          <strong style = "font-size: 20px"><?php echo $row['session_name']; ?></strong> <br> <p style = "color:white; font-weight: 100">(Game Creator: <?php echo $row['email_GM']; ?>)</p>
        </button>
          <?php } ?>
        </div>
      </div>
      <div class = "col-xs-4" style = "border: 4px solid #98AFC7; padding: 10px">
        <p class = "ubuntu-font"><strong>Email: <?php
          $sql3 = mysqli_query($connection, "SELECT* FROM `account` WHERE email = '$email'");
          $account = $sql3->fetch_assoc();
          echo $account['email'];
          ?>
        </strong></p>
        <p class = "ubuntu-font"><strong>Username: <?php
          echo $account['username']
          ?>
        </strong></p>
        <p class = "ubuntu-font"><strong>Wins: <?php
          echo $account['wins'];
          ?>
        </strong></p>
        <p class = "ubuntu-font"><strong>Total games completed: <?php
          echo $account['total_played'];
          ?>
        </strong></p>
      </div>
    </div>
  </fieldset>
  </form>
<br></br><br></br>
<div class="row">
  <a class="btn button-new col-xs-4 col-md-5" href="login.html">Back</a>
  <a class="btn button-new col-xs-offset-4 col-xs-4 col-md-offset-1 col-md-5" href="index.html">Main Menu</a>
</div>
</div>
</div>
<script>
  $("button").tooltip({
    position: {my: "right+160", at: "right"}

  });
</script>
</body>
</html>
