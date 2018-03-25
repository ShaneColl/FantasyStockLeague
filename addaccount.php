<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>FS League - Add Account</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>

  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <div class="container-fluid">
    <div class="well outter-well">
      <div class="row">
        <h1 class="text-center ubuntu-font" style="font-size:50px;"><strong>Create Account</strong></h1>
      </div>
      <div class="row">
        <p class="text-center ubuntu-font" style="font-size:25px;">
          </br>Enter your Email and password to create an account.</br>
        </br></br>
        </p>
      </div>
      <form action="addaccount.php">
        <div class="form-group row">
          <div class="col-xs-8 col-md-6">
            <label for="enteremail" class="ubuntu-font"> Email address and password</label>
            <input type="email" class="form-control ubuntu-font" id="enteremail" placeholder="example@email-address.com" name="email">
            <input type="password" class="form-control ubuntu-font" id="enterpassword" placeholder="password" name="password">
            <input type="hidden" name="add" value="run">
            <input type="submit" a class="btn button-new ubuntu-font">
          </div>
        </div>
        <br><br>
        <?php
if(!empty($_GET['add'])){
if (!empty($_GET['email']) && !empty($_GET['password'])) {

		$mysqli = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		$email = $_GET['email'];
		$pw = $_GET['password'];
	        $row = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM `account` WHERE email = '$email'"));
	
                if($row['email'] == $email){
		     echo '<h1 class="text ubuntu-font" style="font-size:20px;"><strong>Error: account already exists for given Email.</strong></h1>';
	        }
	
	else if(!empty($email) && !empty($pw)){
		mysqli_query($mysqli, "INSERT INTO `account`(`email`, `pw`, `wins`, `total_played`, `last_earnings`) VALUES ('$email', '$pw', 0, 0, 0)");
        echo '<h1 class="text ubuntu-font" style="font-size:20px;"><strong>Account successfully created.</strong></h1>';
	}

}
else{
     echo '<h1 class="text ubuntu-font" style="font-size:20px;"><strong>Error: malformed input.</strong></h1>';
}
}
        ?>
        </br></br>
        <div class="row">
	  <div class="col-xs-4 col-md-6">
	    <a class="btn button-new ubuntu-font" href="index.html">Main Menu</a>
	  </div>
        </div>
      </form>
    </br></br></br></br></br>
    </div>
 </div>

</body>