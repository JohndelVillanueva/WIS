<?php include_once "includes/config.php";
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
								<?php
								$checkrecord = "SELECT * FROM users24 WHERE fname LIKE ? AND lname LIKE ?";
								$params = array($_POST['firstname'], $_POST['lastname']);
								$stmt = $DB_con->prepare($checkrecord);
								$stmt->execute($params);
								if ($stmt->rowCount() != 0) {
									$uniqid = uniqid('WNS-');
									$oldstudent = "UPDATE users24 SET sy = :sy, uniqid = :uniqid, status = :status WHERE fname LIKE :fname AND lname LIKE :lname";
									$studqry = $DB_con->prepare($oldstudent);
									$studqry->execute(array(
										':sy' => "2024-25",
										':uniqid' => $uniqid,
										':status' => "7",
										':fname' => $_POST['firstname'],
										':lname' => $_POST['lastname'],
									));
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
									</div>
								<?php
								} else {
									$checkStudent = $DB_con->prepare("SELECT MAX(username) AS max_username FROM users24 WHERE position = :position");
									$checkStudent->execute(["position" => "Student"]);
									$existingUser = $checkStudent->fetch(PDO::FETCH_OBJ);

									$lastStudentNumber = $existingUser->max_username;
									if ($lastStudentNumber) {
										$removeCharacter = explode("S", $lastStudentNumber);
										$newStudentNumber = intval($removeCharacter[1]) + 1;
									} else {
										// If no existing student numbers, start from 1
										$newStudentNumber = 1;
									}

									$newStudent = "Sn" . str_pad($newStudentNumber, 7, '0', STR_PAD_LEFT);
									// $checkStudent = $DB_con->prepare("SELECT * FROM users24 WHERE position = :position  ORDER BY empno DESC");
									// $checkStudent->execute(["position" => "Student"]);
									// $existingUser = $checkStudent->fetch(PDO::FETCH_OBJ);

									// // $testdata = "S0000005";
									// // $existingUser = $_POST['username'];
									// // $removeCharacter = explode("S",$existingUser->username);
									// // $newStudent = str_pad(str_pad(intval($removeCharacter[1])+1,7,0,STR_PAD_LEFT),"8","S",STR_PAD_LEFT);
									// $removeCharacter = explode("S", $existingUser->username);
									// $newStudentNumber = intval($removeCharacter[1]) + 1;
									// $newStudent = "Sn" . str_pad($newStudentNumber, 7, '0', STR_PAD_LEFT);

									// // $existingUsername = intval($existingUser->username) + 1;
									// $newstudent = $existingUser++;

									// echo $newstudent;

									$uniqid = uniqid('WNS-');
									$newstudent = "INSERT INTO users24 ( position, sy, gender, username, password, apptype, lname, fname, mname, grade, dob, lrn, prevsch, prevschcountry, uniqid, status, strand, nationality, guardianname, guardianemail, guardianphone, referral, visa, tos, earlybird, modelrelease, feepolicy, refund ) VALUES ( :position, :sy, :gender, :username, :password, :apptype, :lname, :fname, :mname, :grade, :dob, :lrn, :prevsch, :prevschcountry, :uniqid, :status, :strand, :nationality, :guardianname, :guardianemail, :guardianphone, :referral, :visa, :tos, :earlybird, :modelrelease, :feepolicy, :refund )";
									$studqry = $DB_con->prepare($newstudent);
									$studqry->execute(array(
										':position' => $_POST['applicationtype'],
										':sy' => '2024-25',
										':gender' => ucwords(strtolower($_POST['gender'])),
										// str_replace(' ', '', strtolower($_POST['lastname'] . $_POST['firstname']))
										':username' => $newStudent,
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
										':status' => 1,
										':strand' => ucwords(strtolower($_POST['strand'])),
										':nationality' => ucwords(strtolower($_POST['nationalityName'])),
										':guardianname' => ucwords(strtolower($_POST['guardian'])),
										':guardianemail' => $_POST['guardianemail'],
										':guardianphone' => $_POST['guardianphone'],
										':referral' => ucwords(strtolower($_POST['referral'])),
										':visa' => $_POST['visa'],
										':tos' => $_POST['tos'],
										':earlybird' => $_POST['earlybird'],
										':modelrelease' => $_POST['modelrelease'],
										':feepolicy' => $_POST['feepolicy'],
										':refund' => $_POST['refundpolicy'],
									));

									$message = "
									<center>
										<img src='https://westfields.edu.ph/wp-content/uploads/2021/11/logo1x-1.png'>
										<h1>Congratulations!</h1>
										<h2>Your child's application has been received!</h2><br>
										<hr>
									</center>
									<p style='font-size:1.2em;'>
										Here are the details of your application:
										<br><br>
										Reference Number: <strong>" . $uniqid . "</strong>
										Name: <strong>" . strtoupper($_POST['lastname'] . ", " . $_POST['firstname'] . " " . $_POST['middlename']) . "</strong><br>
										
										<h4>Your Westfields Portal Account Details</h4>
										Username : <strong style='color:red;'>" . str_replace(' ', '', strtolower($_POST['lastname'] . $_POST['firstname'])) . "</strong><br>
										Password : <strong style='color:red;'>" . $uniqid . "</strong>
									</p>
									";

									$to = $_POST['guardianemail'];
									$subject = 'Congratulations on choosing Westfields!';
									$from = 'no-reply@westfields.edu.ph';

									$headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

									$headers .= 	'From: ' . $from . "\r\n" .
										'Reply-To: ' . $from . "\r\n" .
										'X-Mailer: PHP/' . phpversion();



									$log_enrollQuery = $DB_con->prepare('INSERT INTO logs_enroll (ern,stage,usertouch,touch,notes) VALUES (?, ?, ?, ?, ? )');
									$log_enrollQuery->execute([$uniqid, "Verification", $_SESSION['username'], date("Y-m-d H:i:s"), "Application Form"]);

										
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
											<div class="row">
												<div class="col-lg-12">
													<h1>
														<?php
														if (mail($to, $subject, $message, $headers, '-f no-reply@westfields.edu.ph -F "Westfields Admissions"')) {
															echo 'A confirmation email has been sent to ' . $_POST['guardianemail'];
															die();
														} else {
															echo 'Cannot reach you at ' . $_POST['guardianemail'];
															die();
														}
														?>
													</h1>
												</div>
											</div>
										</div>
										<div class="card-footer text-center"><span class="icon-holder"><i class="anticon anticon-loading"></i></span> Redirecting in 5 seconds...</div>
									</div>
								<?php
								}

								?>
								<script>
									function pageRedirect() {
										var delay = 3000;
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