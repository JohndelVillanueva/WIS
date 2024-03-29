<?php include_once "includes/config.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Westfields International School - WISPortal 0.1a</title>
    <link rel="shortcut icon" href="assets/images/logo/favicon.png">
    <link href="assets/css/app.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <header class="text-center"><img src="assets/images/logo/logo-fold.png">
                    <h3>Westfields International School</h3>
                </header>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php
                $checkrecord = "SELECT id FROM users24 WHERE fname LIKE ? AND lname LIKE ?";
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
                    $uniqid = uniqid('WNS-');
                    $newstudent = "INSERT INTO users24 ( position, sy, gender, username, password, apptype, lname, fname, mname, grade, dob, lrn, prevsch, prevschcountry, uniqid, status, strand, nationality, guardianname, guardianemail, guardianphone, referral, visa, tos, earlybird, modelrelease, feepolicy, refund ) VALUES ( :position, :sy, :gender, :username, :password, :apptype, :lname, :fname, :mname, :grade, :dob, :lrn, :prevsch, :prevschcountry, :uniqid, :status, :strand, :nationality, :guardianname, :guardianemail, :guardianphone, :referral, :visa, :tos, :earlybird, :modelrelease, :feepolicy, :refund )";
                    $studqry = $DB_con->prepare($newstudent);
                    $studqry->execute(array(
                        ':postion' => $_POST['applicationtype'],
                        ':sy' => '2024-25',
                        ':gender' => ucwords(strtolower($_POST['gender'])),
                        ':username' => str_replace(' ', '', strtolower($_POST['lastname'] . $_POST['firstname'])),
                        ':password' => password_hash($uniqid, PASSWORD_DEFAULT),
                        ':apptype' => ucwords(strtolower($_POST['applicationtype'])),
                        ':lname' => ucwords(strtolower($_POST['lastname'])),
                        ':fname' => ucwords(strtolower($_POST['firstname'])),
                        ':mname' => ucwords(strtolower($_POST['middlename'])),
                        ':grade' => $_POST['gradelevel'],
                        ':dob' => $_POST['dob'],
                        ':lrn' => $_POST['lrn'],
                        ':prevsch' => ucwords(strtolower($_POST['oldschool'])),
                        ':prevschcountry' => ucwords(strtolower($_POST['oldschoolctry'])),
                        ':uniqid' => $uniqid,
                        ':status' => 1,
                        ':strand' => ucwords(strtolower($_POST['strand'])),
                        ':nationality' => ucwords(strtolower($_POST['nationality'])),
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

                    $headers .=     'From: ' . $from . "\r\n" .
                        'Reply-To: ' . $from . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();



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
                        <div class="card-footer text-center"><span class="icon-holder"><i class="anticon anticon-loading"></i></span> Redirecting in 3 seconds...</div>
                    </div>
                <?php
                }

                ?>
                <script>
                    function pageRedirect() {
                        var delay = 3000;
                        setTimeout(function() {
                            window.location = "application.php";
                        }, delay);
                    }
                    pageRedirect();
                </script>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="footer-content text-center">
            <p class="m-b-0">Copyright © 2023 WIS ICT. All rights reserved.</p>
            <span class="px-5">
                <a href="login.php" class="text-gray m-r-15">Login</a>
            </span>
        </div>
    </footer>
    <script src="assets/js/vendors.min.js"></script>
    <script src="assets/vendors/chartjs/Chart.min.js"></script>
    <script src="assets/js/pages/dashboard-default.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>