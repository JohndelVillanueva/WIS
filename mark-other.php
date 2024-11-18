<?php

use GrahamCampbell\ResultType\Success;

include_once "includes/config.php";
session_start();

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

if (!$sid || !$asid || !$activity) {
    die("Error: Missing or invalid GET parameters.");
}

// Debug: Print sanitized inputs
var_dump($sid, $asid, $activity);

// Check student information
$getStudentInformation = $DB_con->prepare("SELECT fname, lname FROM afterschool_students WHERE id = :sid");
$getStudentInformation->execute([':sid' => $sid]);
$getInformation = $getStudentInformation->fetch(PDO::FETCH_OBJ);

if (!$getInformation) {
    die("Error: Student not found in the database.");
}

// Debug: Check student data
var_dump($getInformation);

// Insert attendance record
$process_by = $_SESSION['lname'] . " " . $_SESSION['fname'];
$attendance = $DB_con->prepare("
    INSERT INTO afterschool_records (sid, asid, s_name, as_name, attend, process_by) 
    VALUES (:sid, :asid, :s_name, :as_name, NOW(), :process_by)
");
$success = $attendance->execute([
    ":sid" => $sid,
    ":asid" => $asid,
    ":s_name" => $getInformation->lname . " " . $getInformation->fname,
    ":as_name" => $activity,
    ":process_by" => $process_by
]);

if (!$success) {
    $errorInfo = $attendance->errorInfo();
    die("Error recording attendance: " . $errorInfo[2]);
}

// Redirect
header("location: other-attendance.php?id=" . urlencode($asid) . "&activity=" . urlencode($activity). "&action=success" );
exit();
