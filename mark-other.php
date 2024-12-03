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

// Debug: Check session values
if (!isset($_SESSION['username'])) {
    die("Error: User is not logged in.");
}

if (!isset($_SESSION['lname']) || !isset($_SESSION['fname'])) {
    die("Error: Session details (lname, fname) are missing.");
}

// Sanitize GET values
$sid = filter_input(INPUT_GET, 'sid', FILTER_SANITIZE_NUMBER_INT);
$asid = filter_input(INPUT_GET, 'asid', FILTER_SANITIZE_NUMBER_INT);
$activity = filter_input(INPUT_GET, 'activity', FILTER_SANITIZE_STRING);
$payment_status = filter_input(INPUT_GET, 'payment_status', FILTER_SANITIZE_STRING);

if (!$sid || !$asid || !$activity) {
    die("Error: Missing or invalid GET parameters.");
}

// Validate payment status
if (!in_array($payment_status, ['Paid', 'Unpaid'])) {
    die("Error: Invalid payment status.");
}

// Check student information
$getStudentInformation = $DB_con->prepare("
    SELECT 
        s.fname, 
        s.lname, 
        s.email,
        a.activity,
        r.payment_status,
        a.max AS session,
        (SELECT count(r2.attend) 
         FROM afterschool_records r2 
         WHERE r2.sid = s.id) AS totalAttendance -- Subquery to count attendance
    FROM 
        afterschool_students s
    LEFT JOIN 
        afterschool_records r ON s.id = r.sid
    LEFT JOIN 
        afterschool_activities a ON r.asid = a.id
    WHERE 
        s.id = :sid
");
$getStudentInformation->execute([':sid' => $sid]);
$getInformation = $getStudentInformation->fetch(PDO::FETCH_OBJ);


if (!$getInformation) {
    die("Error: Student not found in the database.");
}

// Insert attendance record with payment status
$process_by = $_SESSION['lname'] . " " . $_SESSION['fname'];
$attendance = $DB_con->prepare("
    INSERT INTO afterschool_records (sid, asid, s_name, as_name, attend, process_by, payment_status)
    VALUES (:sid, :asid, :s_name, :as_name, NOW(), :process_by, :payment_status)
");

$success = $attendance->execute([
    ":sid" => $sid,
    ":asid" => $asid,
    ":s_name" => $getInformation->fname . " " . $getInformation->lname,
    ":as_name" => $activity,
    ":process_by" => $process_by,
    ":payment_status" => $payment_status
]);

if (!$success) {
    $errorInfo = $attendance->errorInfo();
    die("Error recording attendance: " . $errorInfo[2]);
}

// Send email notification
try {
    $mail = configureMailer();
    $to = $getInformation->email;
    $subject = "Attendance Recorded for Activity: $activity";
    $body = "
        <p>Hello {$getInformation->fname} {$getInformation->lname},</p>
        <p>Your child attendance for the activity '<strong>$activity</strong>' has been recorded successfully.</p>
        <p><strong>Payment Status:</strong> $payment_status</p>
        <p><strong>Processed By:</strong> $process_by</p>
        <p><strong>Attendance:</strong> $getInformation->totalAttendance</p>
        <p>Thank you.</p>
    ";
    sendEmail($mail, $to, $subject, $body);
} catch (Exception $e) {
    die("Error sending email notification: " . $mail->ErrorInfo);
}

// Redirect with success message
header("location: other-attendance.php?id=" . urlencode($asid) . "&activity=" . urlencode($activity) . "&action=success");
exit();
?>
