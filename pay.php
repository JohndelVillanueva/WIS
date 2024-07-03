<?php
include_once "includes/config.php";
session_start();

if ($_POST['stage'] <= 8) {
  $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
  $process_statement = $DB_con->prepare($process);
  $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));

  $log = "INSERT INTO logs_enroll ( ern, stage, usertouch, touch, notes ) VALUES ( :ern, :stage, :user, NOW(), :notes )";
  $logstmt = $DB_con->prepare($log);
  $logstmt->execute(array(':ern' => $_POST['ern'], ':stage' => $_POST['stage'], ':user' => $_SESSION['fname'] . " " . $_SESSION['lname'], ':notes' => $_POST['notes']));


// Retrieve values from POST request
$applicationFee = isset($_POST['applicationFee']) ? 1 : NULL;
$afTuitionFee = isset($_POST['afTuitionFee']) ? 1 : NULL;
$afTfOtherFees = isset($_POST['afTfOtherFees']) ? 1 : NULL;
$assessmentFee = isset($_POST['assessmentFee']) ? 1 : NULL;
$registrationFee = isset($_POST['registrationFee']) ? 1 : NULL;
$specialPermit = isset($_POST['specialPermit']) ? 1 : NULL;
$internationalFeeOld = isset($_POST['internationalFeeOld']) ? 1 : NULL;
$internationalFeeNew = isset($_POST['internationalFeeNew']) ? 1 : NULL;

// Initialize query parts
$setClause = [];
$params = [];

// Dynamically build SET clause and parameters array
if ($applicationFee !== NULL) {
    $setClause[] = "reservation_fee = ?";
    $params[] = $applicationFee;
}
if ($afTuitionFee !== NULL) {
    $setClause[] = "tuition_fee = ?";
    $params[] = $afTuitionFee;
}
if ($afTfOtherFees !== NULL) {
    $setClause[] = "other_fee = ?";
    $params[] = $afTfOtherFees;
}
if ($assessmentFee !== NULL) {
    $setClause[] = "assessment_fee = ?";
    $params[] = $assessmentFee;
}
if ($registrationFee !== NULL) {
    $setClause[] = "registration_fee = ?";
    $params[] = $registrationFee;
}
if ($specialPermit !== NULL) {
    $setClause[] = "special_permit = ?";
    $params[] = $specialPermit;
}
if ($internationalFeeOld !== NULL) {
    $setClause[] = "international_fee_old = ?";
    $params[] = $internationalFeeOld;
}
if ($internationalFeeNew !== NULL) {
  $setClause[] = "international_fee_new = ?";
  $params[] = $internationalFeeNew;
}

// Add user_id to parameters array
$params[] = $_POST['ern'];  // Assuming 'ern' is the user_id

// Check if there are any fields to update
if (!empty($setClause)) {
    // Convert setClause array to string
    $setClauseString = implode(", ", $setClause);
    
    // Prepare the update query
    $studentPayableQuery = $DB_con->prepare("UPDATE s_payables SET $setClauseString WHERE user_id = ?");
    
    // Execute the query with the parameters
    $studentPayableQuery->execute($params);
}


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
