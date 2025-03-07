<?php include_once "includes/config.php";
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;


session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>

<body>
	<div class="app">
		<div class="layout">
			<?php include_once "includes/heading.php"; ?>
			<?php include_once "includes/sidemenu.php"; ?>
			<div class="page-container">
				<div class="main-content">
					<!-- form starts !-->
					<form action="registrardocs.php" method="post">
						<div class="row">
							<div class="col-lg-12">
								<!-- <?php
								$checkrecord = "SELECT * FROM users24 WHERE fname LIKE ? AND lname LIKE ?";
								$params = array($_POST['firstname'], $_POST['lastname']);
								$stmt = $DB_con->prepare($checkrecord);
								$stmt->execute($params);
								?>
									<div class="card">
										<div class="card-header bg-primary rounded-top pt-2">
											<h4 class="text-light"><span class="icon-holder"><i class="anticon anticon-cloud-server"></i></span> Student Record Found!</h4>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-lg-12">
													<h1>Student Name: <span class="text-success"><?php echo strtoupper($_POST['lastname'] . ", " . $_POST['firstname'] . " " . $_POST['middlename']); ?> is NOT A NEW STUDENT. Please proceed to the Cashier for Enrollment.</span></h1>
												</div>
											</div>
										</div>
										<div class="card-footer text-center"><span class="icon-holder"><i class="anticon anticon-loading"></i></span> Redirecting in 5 seconds...</div>
									</div> -->
								<?php
								
								if ($_POST['syear'] == '2024-25'){
									$checkStudentQuery = $DB_con->prepare("SELECT * FROM user WHERE position = :position ORDER BY id DESC");
									$checkStudentQuery->execute(["position" => "Student"]);
									$existingUsers = $checkStudent->fetch(PDO::FETCH_OBJ);
									
									$removeCharacter = explode("S24", $existingUsers->username);
									$nStudent = str_pad(str_pad(intval($removeCharacter[1]) + 1, 5, 0, STR_PAD_LEFT), 5, "0", STR_PAD_LEFT);
									$insertNewStudent = "S24" . $nStudent;

									//  If School year is 2024-25 this query will return

									$uniqid = uniqid('WNS-');
									$lateEnrolled = "INSERT INTO user (position, is_situation, empno, sy, type, gender, username, password, apptype, lname, fname, mname, grade, dob, lrn, prevsch, prevschcountry, uniqid, status, strand, nationality, nationalities, guardianname, guardianemail, guardianphone, referral, visa, religion)
									VALUES (:position, :is_situation, :empno, :sy, :type, :gender, :username, :password, :apptype, :lname, :fname, :mname, :grade, :dob, :lrn, :prevsch, :prevschcountry, :uniqid, :status, :strand, :nationality, :nationalities, :guardianname, :guardianemail, :guardianphone, :referral, :visa, :religion)";

									$lateEnrolledQuery = $DB_con->prepare($lateEnrolled);
									$lateEnrolledQuery->execute([
										':position' => "Student",
										':is_situation' => $_POST['applicationtype'],
										':empno' => $insertNewStudent,
										':sy' => $_POST['syear'],
										':type' => $_POST['type'],
										':gender' => ucwords(strtolower($_POST['gender'])),
										':username' => $insertNewStudent,
										':password' => password_hash($uniqid, PASSWORD_DEFAULT),
										':apptype' => ucwords(strtolower($_POST['applicationtype'])),
										':lname' => ucwords(strtolower($_POST['lastname'])),
										':fname' => ucwords(strtolower($_POST['firstname'])),
										':mname' => ucwords(strtolower($_POST['middlename'])),
										':grade' => $_POST['gradelevel'],
										':dob' => $_POST['dob'],
										':lrn' => $_POST['lrn'],
										':prevsch' => ucwords(strtolower($_POST['oldschool'])),
										':prevschcountry' => ucwords(strtolower($_POST['countryName'])),
										':uniqid' => $uniqid,
										':status' => 1, // Status is set based on type
										':strand' => ucwords(strtolower($_POST['strand'])),
										':nationality' => ucwords(strtolower($_POST['nationalityName'])),
										':nationalities' => ucwords(strtolower($_POST['nationalityName2'])),
										':guardianname' => ucwords(strtolower($_POST['guardian'])),
										':guardianemail' => isset($_POST['guardianemail']) ? $_POST['guardianemail'] : null, // Check if guardian email exists
										':guardianphone' => isset($_POST['guardianphone']) ? $_POST['guardianphone'] : null, // Check if guardian phone exists
										':referral' => ucwords(strtolower($_POST['referral'])),
										':visa' => $_POST['visa'],
										':religion' => $_POST['religion']
									]);
									
								} else {
									$checkStudent = $DB_con->prepare("SELECT * FROM users24 WHERE position = :position ORDER BY id DESC");
									$checkStudent->execute(["position" => "Student"]);
									$existingUser = $checkStudent->fetch(PDO::FETCH_OBJ);
									
									$removeCharacter = explode("S25", $existingUser->username);
									$nStudent = str_pad(str_pad(intval($removeCharacter[1]) + 1, 5, 0, STR_PAD_LEFT), 5, "0", STR_PAD_LEFT);
									$insertNewStudent = "S25" . $nStudent;
									
									// Check if type is 'Old Student', and set status to 6
									$status = ($_POST['type'] == "Old Student") ? 6 : 1;
									
									$uniqid = uniqid('WNS-');
									$newstudent = "INSERT INTO users24 (position, is_situation, empno, sy, type, gender, username, password, apptype, lname, fname, mname, grade, dob, lrn, prevsch, prevschcountry, uniqid, status, strand, nationality, nationalities, guardianname, guardianemail, guardianphone, referral, visa, religion) 
									VALUES (:position, :is_situation, :empno, :sy, :type, :gender, :username, :password, :apptype, :lname, :fname, :mname, :grade, :dob, :lrn, :prevsch, :prevschcountry, :uniqid, :status, :strand, :nationality, :nationalities, :guardianname, :guardianemail, :guardianphone, :referral, :visa, :religion)";
									
									$studqry = $DB_con->prepare($newstudent);
									$studqry->execute(array(
										':position' => "Student",
										':is_situation' => $_POST['applicationtype'],
										':empno' => $insertNewStudent,
										':sy' => $_POST['syear'],
										':type' => $_POST['type'],
										':gender' => ucwords(strtolower($_POST['gender'])),
										':username' => $insertNewStudent,
										':password' => password_hash($uniqid, PASSWORD_DEFAULT),
										':apptype' => ucwords(strtolower($_POST['applicationtype'])),
										':lname' => ucwords(strtolower($_POST['lastname'])),
										':fname' => ucwords(strtolower($_POST['firstname'])),
										':mname' => ucwords(strtolower($_POST['middlename'])),
										':grade' => $_POST['gradelevel'],
										':dob' => $_POST['dob'],
										':lrn' => $_POST['lrn'],
										':prevsch' => ucwords(strtolower($_POST['oldschool'])),
										':prevschcountry' => ucwords(strtolower($_POST['countryName'])),
										':uniqid' => $uniqid,
										':status' => $status, // Status is set based on type
										':strand' => ucwords(strtolower($_POST['strand'])),
										':nationality' => ucwords(strtolower($_POST['nationalityName'])),
										':nationalities' => ucwords(strtolower($_POST['nationalityName2'])),
										':guardianname' => ucwords(strtolower($_POST['guardian'])),
										':guardianemail' => isset($_POST['guardianemail']) ? $_POST['guardianemail'] : null, // Check if guardian email exists
										':guardianphone' => isset($_POST['guardianphone']) ? $_POST['guardianphone'] : null, // Check if guardian phone exists
										':referral' => ucwords(strtolower($_POST['referral'])),
										':visa' => $_POST['visa'],
										':religion' => $_POST['religion']
									));
								}

									// Create a new PHPMailer instance
									$mail = new PHPMailer(true);

									try {
										// Load environment variables
										$dotenv = Dotenv::createImmutable(__DIR__);
										$dotenv->load();

										$mail->isSMTP();
										$mail->Host = $_ENV['SMTP_HOST'];  // SMTP host
										$mail->SMTPAuth = true;
										$mail->Username = $_ENV['SMTP_USERNAME']; 
										$mail->Password = $_ENV['SMTP_PASSWORD'];
										$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
										$mail->Port = $_ENV['SMTP_PORT'];  // SMTP port

										// Recipients data (2 different recipients)
										$recipients = [
											[
												'email' => $_POST['guardianemail'],
												'name' => 'Guardian',
												'message' => "
													<center>
														<img src='assets/images/logo/logo.png'>
														<h1>Congratulations!</h1>
														<h2>Your child's application has been received!</h2><br>
														<hr>
													</center>
													<p style='font-size:1.2em;'>
														Here are the details of your application:
														<br><br>
														Reference Number: <strong>" . $uniqid . "</strong><br>
														Name: <strong>" . strtoupper($_POST['lastname'] . ', ' . $_POST['firstname'] . ' ' . $_POST['middlename']) . "</strong><br>
														<h4>Your Westfields Portal Account Details</h4>
														Username: <strong style='color:black;'>" . str_replace(' ', '', strtolower($_POST['lastname'] . $_POST['firstname'])) . "</strong><br>
														Password: <strong style='color:black;'>" . $uniqid . "</strong>
													</p>
												"
											],
											[
												'email' => $_ENV['REGISTRAR'],
												'name' => 'Registrar',
												'message' => "
													<center>
														<img src='assets/images/logo/logo.png'>
														<h1>New Application Received!</h1>
														<h2>Details for the new student:</h2><br>
														<hr>
													</center>
													<p style='font-size:1.2em;'>
														Student Name: <strong>" . strtoupper($_POST['lastname'] . ', ' . $_POST['firstname'] . ' ' . $_POST['middlename']) . "</strong><br>
														Reference Number: <strong>" . $uniqid . "</strong><br>
														Status: <strong>Pending</strong>
													</p>
												"
											]
										];

										// Send emails to each recipient with their respective message
										foreach ($recipients as $recipient) {
											$mail->clearAddresses(); // Clear any previous recipient
											$mail->setFrom('no-reply@westfields.edu.ph', 'Westfields International School');
											$mail->addAddress($recipient['email'], $recipient['name']); // Add current recipient

											$mail->isHTML(true);
											$mail->Subject = 'Application Status';
											$mail->Body = $recipient['message'];

											// Send email
											$mail->send();
										}
										// echo 'Email sent successfully.';
									} catch (Exception $e) {
										echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
									}

									// store into the s_payables table
									$applicationFee = isset($_POST['applicationFee']) ? 1 : NULL;
									$afTuitionFee = isset($_POST['afTuitionFee']) ? 1 : NULL;
									$afTfOtherFees = isset($_POST['afTfOtherFees']) ? 1 : NULL;
									$assessmentFee = isset($_POST['assessmentFee']) ? 1 : NULL;
									$registrationFee = isset($_POST['registrationFee']) ? 1 : NULL;
									$specialPermit = isset($_POST['specialPermit']) ? 1 : NULL;
									$internationalFeeOld = isset($_POST['internationalFeeOld']) ? 1 : NULL;
									$internationalFeeNew = isset($_POST['internationalFeeNew']) ? 1 : NULL;
									$pta = isset($_POST['pta']) ? 1 : NULL;

									// s_payables Query
									$studentPayableQuery = $DB_con->prepare("INSERT INTO s_payables (user_id, reservation_fee, tuition_fee, other_fee, assessment_fee, registration_fee, special_permit, international_fee_old,international_fee_new,pta) VALUES (?,?,?,?,?,?,?,?,?,?)");
									$studentPayableQuery->execute([
										$uniqid,
										$applicationFee,
										$afTuitionFee,
										$afTfOtherFees,
										$assessmentFee,
										$registrationFee,
										$specialPermit,
										$internationalFeeOld,
										$internationalFeeNew,
										$pta
									]);

									$log_enroll_query = $DB_con->prepare('INSERT INTO logs_enroll (ern,stage,usertouch,touch,notes) VALUES (?, ?, ?, ?, ? )');
									$log_enroll_query->execute([$uniqid, "Verification", $_SESSION['fname']. " " .$_SESSION['lname'], date("Y-m-d H:i:s"), $_POST['notes']]);

									// var_dump([
									// 	'Notes' => $notes,
									// 	'Application' => $applicationFee,
									// 	'Tuition' => $afTuitionFee,
									//     'Other' => $afTfOtherFees,
									//     'Assessment' => $assessmentFee,
									//     'Registration' => $registrationFee,
									//     'Special Permit' => $specialPermit
									// ]);
									// 	die();


								?>
									<div class="card">
										<div class="card-header bg-primary rounded-top pt-2">
											<h4 class="text-light"><span class="icon-holder"><i class="anticon anticon-cloud-server"></i></span> Student Record Found!</h4>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-lg-12">
													<h1>Enrollment Reference Number: <strong class="text-danger"><?php echo $uniqid; ?></strong></h1>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-12">
													<h1>Student Name: <span class="text-success"><?php echo strtoupper($_POST['lastname'] . ", " . $_POST['firstname'] . " " . $_POST['middlename']); ?></span></h1>
												</div>
											</div>
										<div class="card-footer text-center"><span class="icon-holder"><i class="anticon anticon-loading"></i></span> Redirecting in 5 seconds...</div>
									</div>
								<script>
									function pageRedirect() {
										var delay = 5000;
										setTimeout(function() {
											window.location = "registrardocs.php";
										}, delay);
									}
									pageRedirect();
								</script>
							</div>
						</div>
					</form>
					<!-- form ends !-->
				</div>
				<?php include_once "includes/footer.php"; ?>
			</div>
			<?php include_once "includes/scripts.php"; ?>
		</div>
	</div>
</body>

</html>