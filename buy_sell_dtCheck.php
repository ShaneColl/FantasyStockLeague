
	<?php
		session_start(); 

		$session_name = $_SESSION['session_name'];
		$email = $_SESSION['email'];
		$GM_Email = $_SESSION['GM_email'];
		
		
		 $mysqli = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
		 if (mysqli_connect_errno())
		   {
		   echo "Failed to connect to MySQL: " . mysqli_connect_error();
		   }
		 $ticker = $_POST['ticker'];
		 $dt_date = $_POST['date'];
		 $querystring = "SELECT * FROM session_data WHERE owner = '" . $email . "' and email_GM = '" . $GM_Email . "' and session_name = '" . $session_name . "' and stock_ticker = '" . $ticker . "' and CONVERT( DATE, DATE ) = '" . $dt_date . "'";
		 $result = $mysqli->query($querystring);
		 if ($row = mysqli_fetch_assoc($result)) {
			echo 1;
		 }
		 else{
			echo 0;
		 }
		 ?>
