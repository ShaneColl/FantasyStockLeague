<!DOCTYPE html>
<html>
<body>

	<?php
		$mysqli = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
		$ticker = $_POST['ticker'];
		$value = $_POST['value'];
		$total_value = $_POST['total_value'];
		$amount = $_POST['amount'];
		if (mysqli_connect_errno() && isset($ticker)
		  {
		  echo "Failed to connect to MySQL: " . mysqli_connect_error();
		  }
		$player_Email = "fakeemail@email.com";
		$GM_Email = "ddd@test.com";
		$session_name = "tester_game";
		$querystring = "INSERT INTO session_data(email_GM, session_name, stock_ticker, price, number, owner) VALUES ('".$GM_Email."','".$session_name."','".$ticker."','".$price."','".$number."','".$player_Email."') WHERE owner = '" . $player_Email . "' and email_GM = '" . $GM_Email . "' and session_name = '" . $session_name . "'";
		$result = $mysqli->query($querystring);
		if (!$result) {
			echo 'Could not run query: ' . mysqli_error();
		}
		mysqli_close(mysqli);
	?>	

</body>
</html>