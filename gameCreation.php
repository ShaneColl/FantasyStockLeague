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
		  echo '
			<link href= "https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
			<div class = "container-fluid">
			   <div class = "well outter-well">
		              <h1 class = "text-center ubuntu-font" style="font-size:50px"><strong>Startup Parameters</strong></h1>
	  		      <div class = "gameParams" style = "margin-left: 10px">
			         <div class = "form-group text-left" style = "width: 200px">
			            <label class = "ubuntu-font" style = "font-size: 20px">Game length:</label>
	        	            <input type = "text" class = "form-control" id = "timespan" placeholder = "Game length (days)">
	      		         </div>

			         <div class="checkbox">
			            <label class = "ubuntu-font" style = "font-size: 20px"><strong>
			                <input type="checkbox" value="">Day trading restricted</strong>
			            </label>
	      		         </div>

	      		         <div class = "form-group text-left" style = "width: 200px">
	        	            <label class = "ubuntu-font" style = "font-size: 20px">Stock limit:</label>
	        	            <input type = "text" class = "form-control" id = "stocklimit" placeholder = "100">
	      		         </div>

			         <label class = "ubuntu-font" style = "font-size: 20px">Starting cash amount:</label>

			         <div class = "input-group" style = "width: 200px">
				    <span class = "input-group-addon" id = startingcash>$</span>
	        		    <input type = "text" class = "form-control" id = "startingcash" placeholder = "0.00">
	      		         </div>
	  		      </div>
		              <br><br/>
		  	      <div class = "row">
		    	         <div class = "col-xs-4 col-md-3">
		      	            <a class="btn-lg button-new ubuntu-font"  href="index.html">Back to Main Menu</a>
		    	         </div>
		 	         <div class = "col-xs-4 col-xs-offset-4 col-md-offset-6 col-md-3">
		     	            <a class="btn-lg button-new ubuntu-font"  href="addFriends.html">Confirm</a>
		  	         </div>
		 	      </div>
			   </div>	
			</div>';
		}
	}
?>
</body>
