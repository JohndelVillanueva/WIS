<?php
include_once "includes/config.php";
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

session_start();

if ($_POST['stage'] <= 9) {
    $getSpecificUser = $DB_con->prepare("SELECT * FROM users24 WHERE uniqid = :uniqid");
    $getSpecificUser->execute([':uniqid' => $_POST['ern']]);
    $student = $getSpecificUser->fetch(PDO::FETCH_OBJ);

    $studentFname = htmlspecialchars($student->fname);
    $studentLname = htmlspecialchars($student->lname);

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

    $mail = new PHPMailer(true);

    try {
        // Load environment variables
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        // Set up mail
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        $mail->setFrom('no-reply@westfields.edu.ph', 'Westfields International School');
        $cashier = $_ENV['CASHIER'];
        $mail->addAddress($cashier);

        // Prepare email content
        $displayName = $DB_con->prepare("SELECT * FROM user WHERE email = :email");
        $displayName->execute([':email' => $cashier]);
        $user = $displayName->fetch(PDO::FETCH_OBJ);

        $fname = htmlspecialchars($user->fname);
        $lname = htmlspecialchars($user->lname);

        $message = "
            <center>
                <img src='assets/images/logo/logo.png'>
                <h1>Hello ma'am $fname $lname</h1>
                <h2>New Student Arrived!</h2><br>
                <hr>
            </center>
            <p style='font-size:1.2em;'>
                Name: <strong>" . strtolower($studentFname . ", " . $studentLname) . "</strong><br>
            </p>
        ";

        $mail->isHTML(true);
        $mail->Subject = 'Stage 1: Completed!';
        $mail->Body = $message;

        // Send email
        $mail->send();
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}

// Stage 3: Update status with additional field
if ($_POST['stage'] == '3') {
    $process = "UPDATE users24 SET status = :status, tf = :tf WHERE uniqid = :uniqid";
    $process_statement = $DB_con->prepare($process);
    $process_statement->execute([':status' => $_POST['stage'], ':tf' => $_POST['tf'], ':uniqid' => $_POST['ern']]);
}

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
    $mail = new PHPMailer(true);

    try {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        $mail->setFrom('no-reply@westfields.edu.ph', 'Westfields International School');
        $guidance = $_ENV['GUIDANCE']; // Ensure this is set correctly
        $mail->addAddress($guidance);

        $displayName = $DB_con->prepare("SELECT * FROM user WHERE email = :email");
        $displayName->execute([':email' => $guidance]);
        $user = $displayName->fetch(PDO::FETCH_OBJ);

        $message = "
            <center>
                <img src='assets/images/logo/logo.png'>
                <h1>Stage 4: Examination</h1>
                <p>Student Examination</p>
                <p>Name: <strong>" . strtoupper($studentFname . ', ' . $studentLname) . "</strong></p>
            </center>
        ";

        $mail->isHTML(true);
        $mail->Subject = 'Stage 3 Completed';
        $mail->Body = $message;

        $mail->send();
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
    $mail = new PHPMailer(true);

    try {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        $mail->setFrom('no-reply@westfields.edu.ph', 'Westfields International School');
        $interview = $_ENV['INTERVIEW'];
        $mail->addAddress($interview);

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

        $mail->isHTML(true);
        $mail->Subject = 'Stage 4 Completed';
        $mail->Body = $message;

        $mail->send();
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

    $mail = new PHPMailer(true);

try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $mail->isSMTP();
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = $_ENV['SMTP_PORT'];

    $mail->setFrom('no-reply@westfields.edu.ph', 'Westfields International School');
    $registrar = $_ENV['REGISTRAR'];
    $mail->addAddress($registrar);

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

    $mail->isHTML(true);
    $mail->Subject = 'Stage 5 Completed';
    $mail->Body = $message;

    $mail->send();
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
    $mail = new PHPMailer(true);

    try {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        $mail->setFrom('no-reply@westfields.edu.ph', 'Westfields International School');
        $cashier = $_ENV['CASHIER'];
        $mail->addAddress($cashier);

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

        $mail->isHTML(true);
        $mail->Subject = 'Stage 6 Completed';
        $mail->Body = $message;

        $mail->send();
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
    $mail = new PHPMailer(true);

    try {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        $mail->setFrom('no-reply@westfields.edu.ph', 'Westfields International School');
        $registrar = $_ENV['REGISTRAR'];
        $mail->addAddress($registrar);

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

        $mail->isHTML(true);
        $mail->Subject = 'Stage 7 Completed';
        $mail->Body = $message;

        $mail->send();
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
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true); // <-- Initialize the PHPMailer object here

        // Server settings
        $mail->isSMTP();
        $mail->Host = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $_ENV['SMTP_PORT'];

        // Sender and recipient
        $mail->setFrom('no-reply@westfields.edu.ph', 'Westfields International School');
        $enrolled = $_ENV['ENROLLED'];
        $mail->addAddress($enrolled);

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

    $log = "INSERT INTO logs_enroll ( ern, stage, usertouch, touch, notes ) VALUES ( :ern, :stage, :user, NOW(), :notes )";
    $logstmt = $DB_con->prepare($log);
    $logstmt->execute(array(':ern' => $_POST['ern'], ':stage' => $_POST['stage'], ':user' => $_SESSION['fname'] . " " . $_SESSION['lname'], ':notes' => $_POST['notes']));

    switch ($_POST['stage']) {
        case "2":
            header("Location: cashier.php?ern=" . $_POST['ern']);
            die();
        case "3":
            header("Location: admissions.php?ern=" . $_POST['ern']);
            die();
        case "4":
            header("Location: guidance.php?ern=" . $_POST['ern']);
            die();
        case "5":
            // if check esl the value is 1 if not the value is null
            $esl = isset($_POST['esl']) ? 1 : NULL;

            // if check star the value is 1 if not the value is null
            $star = isset($_POST['star']) ? 1 : NULL;

            // if check completion the value is 1 if not the value is null
            $completion = isset($_POST['completion']) ? 1 : NULL;

            $recommendationQuery = $DB_con->prepare("INSERT INTO s_recommendations (user_id, esl, star, completion) VALUES (?, ?, ?, ?)");
            $recommendationQuery->execute([
                $_POST['username'],
                $esl,
                $star,
                $completion
            ]);
            header("Location: interview.php?ern=" . $_POST['ern']);
            die();
        case "6":
            header("Location: registrar.php?ern=" . $_POST['ern']);
            die();
        case "7":
            header("Location: payment.php?ern=" . $_POST['ern']);
            die();
        case "8":
            header("Location: registrar2.php?ern=" . $_POST['ern']);
            
        default:
            header("Location: index.php?ern=" . $_POST['ern']);
            die();
    }
} else {
    header("Location: cashier.php?ern=" . $_POST['ern']);
    die();
}
