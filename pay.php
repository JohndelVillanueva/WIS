<?php
include_once "includes/config.php";
session_start();

if ($_POST['stage'] <= 8) {
  $process = "UPDATE users24 SET status = :status, tf = :tf WHERE uniqid = :uniqid";
  $process_statement = $DB_con->prepare($process);
  $process_statement->execute(array(':status' => $_POST['stage'], ':tf' => $_POST['tf'], ':uniqid' => $_POST['ern']));

  $log = "INSERT INTO logs_enroll ( ern, stage, usertouch, touch, notes ) VALUES ( :ern, :stage, :user, NOW(), :notes )";
  $logstmt = $DB_con->prepare($log);
  $logstmt->execute(array(':ern' => $_POST['ern'], ':stage' => $_POST['stage'], ':user' => $_SESSION['fname'] . " " . $_SESSION['lname'], ':notes' => $_POST['notes']));
  /*$message = "
									<center>
										<img src='https://westfields.edu.ph/wp-content/uploads/2021/11/logo1x-1.png'>
										<h1>Here comes a new challenger!</h1>
										<h2>A new student has been enrolled!</h2><br>
										<hr>
									</center>
									<p style='font-size:1.2em;'>
										Here are the details of your application:
										<br><br>
										Name: <strong>" . strtoupper( $_POST[ 'lastname' ] . ", " . $_POST[ 'firstname' ] . " " . $_POST[ 'middlename' ] ) . "</strong><br>
										Grade: <strong>" . $uniqid . "</strong>
										Section: <strong>" . $uniqid . "</strong>
									</p>
									";

  $to = $_POST[ 'guardianemail' ];
  $subject = 'Congratulations on choosing Westfields!';
  $from = 'no-reply@westfields.edu.ph';

  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers .= 'From: ' . $from . "\r\n" .
  'Reply-To: ' . $from . "\r\n" .
  'X-Mailer: PHP/' . phpversion();
  if ( mail( $to, $subject, $message, $headers, '-f no-reply@westfields.edu.ph -F "Westfields Admissions"' ) ) {
    echo 'A confirmation email has been sent to ' . $_POST[ 'guardianemail' ];
    die();
  } else {
    echo 'Cannot reach you at ' . $_POST[ 'guardianemail' ];
    die();
  }*/

  header("Location: cashier.php?ern=" . $_POST['ern']);
  die();
} else {
  header("Location: cashier.php?ern=" . $_POST['ern'] . "&err=1");
  die();
}
