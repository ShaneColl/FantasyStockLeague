<!DOCTYPE html>
<html>
<body>
<?php
   session_start();
   $dom = new DOMDocument;
   $dom->loadHTMLFile('addFriends.html');
   echo '<p>peepee</p>';
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
      echo '<p>papapa</p>';
      
      $msg = "You're friend has invited you to a game of FSLeague! Find your game here: www.fsleague.website/loadgame.php";
      /*$msg = '<html>';
      $msg .= '<head>';
      $msg .= '<title>FsLeague Invite!</title>';
      $msg .= '</head>';
      $msg .= '<body>';
      $msg .= '<p>You're friend has invited you to a game of FSLeague! Find your game here: </p>';
      $msg .= '<a href="www.fsleague.website/loadgame.php">www.fsleague.website/loadgame.php</a>';
      $msg .= '</body>';
      $msg .= '</html>';
      */
      /*
      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
      $headers .= 'From: <fsledcxs@server140.web-hosting.com>' . "\r\n";
      */
      $address = $_POST['friendEmail'];
      echo '<p>pupupu</p>';
      
      mail($address,"FSLeague invite",$msg);
      //mail($address,"FSLeague invite",$msg,$headers);
	      
      echo '<p>plepplepplep</p>';

      // Update session_player_data table with invited players
      $email = $_SESSION['email'];
      $session = $_SESSION['gameName'];
      $mysqli = mysqli_connect("localhost", "fsledcxs", "@rka54yM9&0i", "fsledcxs_main");
      mysqli_query($mysqli, "INSERT INTO `session_player_data`(`email_GM`, `session_name`, `email_INV`, `total_score`) VALUES ('$email', '$session', '$address', 0)");
      header("Location: userHub.html");
      
   // }
   // $html = $dom->saveHTML();
   }
?>
</body>
</html>