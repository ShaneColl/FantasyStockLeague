<!DOCTYPE html>
<html>
<body>
  <?php
    session_start();
    $mysqli = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
    if (mysqli_connect_errno()){
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $emails = $_POST['emails'];
    $msg = "Your friend has invited you to a game of FSLeague! Find your game here: fsleague.website/loadgame.php";
    while(!mail('$emails', "Invite!", '$msg')){
    	mail('$emails', "Invite!", '$msg');
    }

	// Insert Game Params from previous page into database

	$email = $_SESSION['email'];
	$gameName = $_SESSION['gameName'];
	$timespan = $_SESSION['timespan'];
	$dayTrading = $_SESSION['dayTrading'];
	$stockLimit = $_SESSION['stockLimit'];
	$startingCash = $_SESSION['startingCash'];

	$date = new DateTime(date('Y-m-d'));
	$date->modify('+' . $timespan . ' day');
	$currDate = date('Y-m-d');
	$nextDate = $date->format('Y-m-d');
	mysqli_query($mysqli, "INSERT INTO session_list(email_GM, session_name, start_date, end_date, allow_DT, stock_limit, start_cash) VALUES ('$email', '$gameName', '$currDate', '$nextDate', '$dayTrading', $stockLimit, $startingCash)");
	mysqli_query($mysqli, "INSERT INTO `session_player_data`(email_GM, session_name, email_INV, total_score, joined) VALUES ('$email', '$gameName', '$email', '$startingCash', 1)");
	$emailArr = explode(",", $emails);
	foreach($emailArr as $emailInv){
	  if($email != $emailInv){
	    mysqli_query($mysqli, "INSERT INTO session_player_data(email_GM, session_name, email_INV, total_score, joined) VALUES ('$email', '$gameName', '$emailInv', '$startingCash', 0)");
	  }
	}

	exit(0);


/*

include('Mail.php');

object &factory ( mail , $emails );

$recipients = $_POST['emails'];

$headers['Subject'] = 'Invite!';

$body = 'Your friend has invited you to a game of FSLeague! Find your game here: fsleague.website/loadgame.php';

$params['sendmail_path'] = '/php/Mail/sendmail.php';

// Create the mail object using the Mail::factory method
$mail_object =& Mail::factory('sendmail', $params);

$mail_object->send($recipients, $headers, $body);
*/

?>
</body>
</html>
