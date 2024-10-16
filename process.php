<?php
include_once "includes/config.php";
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

session_start();

function configureMailer()
{
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $_ENV['SMTP_PORT'];

    return $mail;
}

function sendEmail($mail, $to, $subject, $body)
{
    $mail->setFrom('no-reply@westfields.edu.ph', 'Westfields International School');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;
    $mail->send();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['ern'];

    // Fetch the current values from the database
    $query = $DB_con->prepare("SELECT * FROM s_payables WHERE user_id = :userId");
    $query->execute([':userId' => $userId]);
    $currentValues = $query->fetch(PDO::FETCH_ASSOC);

    if ($currentValues) {
        // Prepare the new values, falling back to the current values if no checkbox is checked
        $assessmentFee = isset($_POST['assessmentFee']) ? 1 : $currentValues['assessment_fee'];
        $tuitionFee = isset($_POST['afTuitionFee']) ? 1 : $currentValues['tuition_fee'];
        $otherFee = isset($_POST['afTfOtherFees']) ? 1 : $currentValues['other_fee'];
        $reservationFee = isset($_POST['applicationFee']) ? 1 : $currentValues['reservation_fee'];
        $registrationFee = isset($_POST['registrationFee']) ? 1 : $currentValues['registration_fee'];
        $specialPermit = isset($_POST['specialPermit']) ? 1 : $currentValues['special_permit'];
        $internationalFeeOld = isset($_POST['internationalFeeOld']) ? 1 : $currentValues['international_fee_old'];
        $internationalFeeNew = isset($_POST['internationalFeeNew']) ? 1 : $currentValues['international_fee_new'];
        $pta = isset($_POST['pta']) ? 1 : $currentValues['pta'];

        // Update the corresponding fields in the database
        $updateQuery = $DB_con->prepare("
            UPDATE s_payables 
            SET 
                assessment_fee = :assessmentFee, 
                tuition_fee = :tuitionFee, 
                other_fee = :otherFee, 
                reservation_fee = :reservationFee, 
                registration_fee = :registrationFee, 
                special_permit = :specialPermit, 
                international_fee_old = :internationalFeeOld, 
                international_fee_new = :internationalFeeNew,
                pta = :pta
            WHERE user_id = :userId
        ");

        // Execute the query with the provided data
        $updateQuery->execute([
            ':assessmentFee' => $assessmentFee,
            ':tuitionFee' => $tuitionFee,
            ':otherFee' => $otherFee,
            ':reservationFee' => $reservationFee,
            ':registrationFee' => $registrationFee,
            ':specialPermit' => $specialPermit,
            ':internationalFeeOld' => $internationalFeeOld,
            ':internationalFeeNew' => $internationalFeeNew,
            ':pta' => $pta,
            ':userId' => $userId
        ]);
    }
}
// var_dump($_POST);
// die();

if ($_POST['stage'] <= 9) {

    $getSpecificUser = $DB_con->prepare("SELECT * FROM users24 WHERE uniqid = :uniqid");
    $getSpecificUser->execute([':uniqid' => $_POST['ern']]);
    $student = $getSpecificUser->fetch(PDO::FETCH_OBJ);

    $studentFname = htmlspecialchars($student->fname);
    $studentLname = htmlspecialchars($student->lname);

    // Stage 2: Update status and send email to cashier
    if ($_POST['stage'] == '2') {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute([':status' => $_POST['stage'], ':uniqid' => $_POST['ern']]);


        try {
            // Load environment variables
            $mail = configureMailer();

            $cashier = $_ENV['CASHIER'];

            // Prepare email content
            $displayName = $DB_con->prepare("SELECT * FROM user WHERE email = :email");
            $displayName->execute([':email' => $cashier]);
            $user = $displayName->fetch(PDO::FETCH_OBJ);

            $fname = htmlspecialchars($user->fname);
            $lname = htmlspecialchars($user->lname);

            $message = "
                <center>
                    <img src='assets/images/logo/logo.png'>
                    <h1>Stage 2: Cashier</h1>
                    <p> {$fname}  {$lname}  </p>
                    <h2>Time for payment!</h2><br>
                    <hr>
                </center>
                <p style='font-size:1.2em;'>
                    Name: <strong>" . strtolower($studentFname . ", " . $studentLname) . "</strong><br>
                </p>
            ";

            sendEmail($mail, $cashier, 'Stage 1: Completed!', $message);
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // Stage 3: Update status with additional field
    // if ($_POST['stage'] == '3') {
    //     $process = "UPDATE users24 SET status = :status, tf = :tf WHERE uniqid = :uniqid";
    //     $process_statement = $DB_con->prepare($process);
    //     $process_statement->execute([':status' => $_POST['stage'], ':tf' => $_POST['tf'], ':uniqid' => $_POST['ern']]);
    // }

    // Stage 4: Update status and schedule an exam
    if ($_POST['stage'] == '4') {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute([':status' => $_POST['stage'], ':uniqid' => $_POST['ern']]);

        // Schedule an exam
        $date = date("Y-m-d H:i:s", strtotime($_POST["esched"]));
        $sched = "INSERT INTO schedule (title, start, end) VALUES (?, ?, ?)";
        $sched_process = $DB_con->prepare($sched);
        $sched_process->execute([$_POST['sname'] . " - EXAM", $date, $date]);

        // Send email to guidance

        try {
            $mail = configureMailer();
            $guidance = $_ENV['GUIDANCE']; // Admin email
            $parentEmail = $student->guardianemail; // Parent email from the form
        
            // Fetch admin's display name if needed
            $displayName = $DB_con->prepare("SELECT * FROM user WHERE email = :email");
            $displayName->execute([':email' => $guidance]);
            $user = $displayName->fetch(PDO::FETCH_OBJ);
        
            // Message for the admin (guidance)
            $adminMessage = "
                <center>
                    <img src='assets/images/logo/logo.png'>
                    <h1>Stage 4: Examination</h1>
                    <p>Student Examination for <strong>" . strtoupper($studentFname . ', ' . $studentLname) . "</strong></p>
                    <p>Please ensure the examination is conducted on time.</p>
                    <strong>Examination Date: " . $_POST['esched'] . "</strong>
                </center>
            ";
        
            // Message for the parents
            $parentMessage = "
                <center>
                    <img src='assets/images/logo/logo.png'>
                    <h1>Stage 4: Examination Notification</h1>
                    <p>Dear Parent/Guardian,</p>
                    <p>We would like to inform you that your child <strong>" . strtoupper($studentFname . ', ' . $studentLname) . "</strong> will undergo the Stage 4 examination.</p>
                    <p>Please ensure your child is prepared for the examination.</p>
                    <strong>Examination Date: " . $_POST['esched'] . "</strong>
                </center>
            ";
        
            // Send to admin (guidance)
            sendEmail($mail, $guidance, 'Stage 4 Examination Notification', $adminMessage);
        
            // Send to parent
            sendEmail($mail, $parentEmail, 'Stage 4 Examination Notification', $parentMessage);
        
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // Stage 5: Update status and reschedule interview
    if ($_POST['stage'] == '5') {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute([':status' => $_POST['stage'], ':uniqid' => $_POST['ern']]);

        $date = date("Y-m-d H:i:s", strtotime($_POST["esched"]));
        $sched = "UPDATE schedule SET start = ?, end = ?, title = ? WHERE title LIKE ?";
        $sched_process = $DB_con->prepare($sched);
        $sched_process->execute([$date, $date, $_POST["sname"] . " - INTERVIEW", "%" . $_POST["sname"] . "%"]);

        // Send email to registrar

        try {
            $mail = configureMailer();
            $interview = $_ENV['INTERVIEW'];

            $displayName = $DB_con->prepare("SELECT * FROM user WHERE email = :email");
            $displayName->execute([':email' => $interview]);
            $user = $displayName->fetch(PDO::FETCH_OBJ);

            $message = "
                            <center>
                                <img src='assets/images/logo/logo.png'>
                                <h1>Stage 5: Time for Interview </h1>
                                <p>Name: <strong>" . strtoupper($studentFname . ', ' . $studentLname) . "</strong></p>
                            </center>
                        ";

            sendEmail($mail, $interview, 'Stage 4 Completed', $message);
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }

    if ($_POST['stage'] == '6') {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));

        $sched = "DELETE FROM schedule WHERE title LIKE ?";
        $sched_process = $DB_con->prepare($sched);
        $sched_process->execute(array("%" . $_POST['sname'] . "%"));


        try {
            $mail = configureMailer();
            $registrar = $_ENV['REGISTRAR'];

            $displayName = $DB_con->prepare("SELECT * FROM user WHERE email = :email");
            $displayName->execute([':email' => $registrar]);
            $user = $displayName->fetch(PDO::FETCH_OBJ);

            $message = "
            <center>
                <img src='assets/images/logo/logo.png'>
                <h1>Stage 6: Checking Documents </h1>
                <p>Name: <strong>" . strtoupper($studentFname . ', ' . $studentLname) . "</strong></p>
            </center>
        ";

            sendEmail($mail, $registrar, 'Stage 5 Completed', $message);
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }

    if ($_POST['stage'] == '7') {
        if (isset($_POST["official"])) {
            $process = "UPDATE users24 SET status = :status, isofficial = 1 WHERE uniqid = :uniqid";
            $process_statement = $DB_con->prepare($process);
            $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));
        } elseif (isset($_POST["unofficial"])) {
            $process = "UPDATE users24 SET status = :status, isofficial = 0 WHERE uniqid = :uniqid";
            $process_statement = $DB_con->prepare($process);
            $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));
        }

        try {
            $mail = configureMailer();
            $cashier = $_ENV['CASHIER'];

            $displayName = $DB_con->prepare("SELECT * FROM user WHERE email = :email");
            $displayName->execute([':email' => $cashier]);
            $user = $displayName->fetch(PDO::FETCH_OBJ);

            $message = "
            <center>
                <img src='assets/images/logo/logo.png'>
                <h1>Stage 7: Payments </h1>
                <p>Name: <strong>" . strtoupper($studentFname . ', ' . $studentLname) . "</strong></p>
            </center>
        ";
            sendEmail($mail, $cashier, 'Stage 6 Completed', $message);
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }

    if ($_POST['stage'] == '8') {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));

        $getstudentdetails = $DB_con->prepare("SELECT * FROM users24 WHERE uniqid = :uniqid");
        $getstudentdetails->execute(array(':uniqid' => $_POST['ern']));
        $result = $getstudentdetails->fetchAll();

        try {
            $mail = configureMailer();
            $registrar = $_ENV['REGISTRAR'];

            $displayName = $DB_con->prepare("SELECT * FROM user WHERE email = :email");
            $displayName->execute([':email' => $registrar]);
            $user = $displayName->fetch(PDO::FETCH_OBJ);

            $message = "
            <center>
                <img src='assets/images/logo/logo.png'>
                <h1>Stage 8: Checking Documents </h1>
                <p>Name: <strong>" . strtoupper($studentFname . ', ' . $studentLname) . "</strong></p>
            </center>
        ";
            sendEmail($mail, $registrar, 'Stage 7 Completed', $message);
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    }

    if ($_POST['stage'] == '9') {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));

        // echo "Update Successfully";

        $getstudentdetails = $DB_con->prepare("SELECT * FROM users24 WHERE uniqid = :uniqid");
        $getstudentdetails->execute(array(':uniqid' => $_POST['ern']));
        $result = $getstudentdetails->fetchAll();

        try {
            // Load environment variables
            $mail = configureMailer();

            // Sender and recipient
            $mail->setFrom('no-reply@westfields.edu.ph', 'Westfields International School');
            $enrolled = explode(',', $_ENV['ENROLLED']);

            foreach ($enrolled as $enroll) {
                $mail->addAddress($enroll);
            }
            // var_dump($enrolled);
            // die();

            // Fetch student details
            $displayName = $DB_con->prepare("SELECT * FROM user WHERE email = :email");
            $displayName->execute([':email' => $enrolled]);
            $user = $displayName->fetch(PDO::FETCH_OBJ);

            // Construct email content
            $message = "
            <center>
                <img src='assets/images/logo/logo.png'>
                <p>Name: <strong>" . strtoupper($studentFname . ', ' . $studentLname) . "</strong></p>
                <h1> is Finally Enrolled </h1>
            </center>
        ";

            // Email content settings
            $mail->isHTML(true);
            $mail->Subject = 'Stage 8 Completed';
            $mail->Body = $message;

            // Send the email
            $mail->send();
        } catch (Exception $e) {
            echo "Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));
    }

    // var_dump($recommendationQuery);
    // die();

    // Insert log into the database
    $logQuery = "INSERT INTO logs_enroll (ern, stage, usertouch, touch, notes) VALUES (:ern, :stage, :user, NOW(), :notes)";
    $logStmt = $DB_con->prepare($logQuery);
    $logStmt->execute([
        ':ern' => $_POST['ern'],
        ':stage' => $_POST['stage'],
        ':user' => $_SESSION['fname'] . " " . $_SESSION['lname'],
        ':notes' => $_POST['notes']
    ]);

    // Redirect based on stage
    $stageRedirects = [
        "2" => "cashier.php",
        "3" => "admissions.php",
        "4" => "guidance.php",
        "5" => "interview.php",
        "6" => "registrar.php",
        "7" => "payment.php",
        "8" => "registrar2.php"
    ];

    // Special handling for stage 5
    if ($_POST['stage'] == "5") {
        $esl = !empty($_POST['esl']) ? 1 : NULL;
        $star = !empty($_POST['star']) ? 1 : NULL;
        $completion = !empty($_POST['completion']) ? 1 : NULL;

        $recommendationQuery = $DB_con->prepare("INSERT INTO s_recommendations (user_id, esl, star, completion) VALUES (?, ?, ?, ?)");
        $recommendationQuery->execute([
            $_POST['username'],
            $esl,
            $star,
            $completion
        ]);
    }

    // Redirect to the appropriate page or default to index
    $redirectUrl = $stageRedirects[$_POST['stage']] ?? "index.php";
    header("Location: {$redirectUrl}?ern=" . $_POST['ern']);
    die();
} else {
    header("Location: cashier.php?ern=" . $_POST['ern']);
    die();
}
