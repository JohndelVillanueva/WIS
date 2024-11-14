<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

// Retrieve the student ID and activity ID from the URL
$sid = $_GET["sid"];
$asid = $_GET["asid"];
$activity = $_GET["activity"];

// Query to fetch the specific student and activity information
$getStudentInformation = $DB_con->prepare("SELECT ast.fname, ast.lname FROM afterschool_students ast WHERE ast.id = :sid");
$getStudentInformation->execute([
    ":sid" => $sid
]);
$getInformation = $getStudentInformation->fetch(PDO::FETCH_OBJ);

// Check if the student information was retrieved
if ($getInformation) {
    // Insert attendance record
    $attendance = $DB_con->prepare("INSERT INTO afterschool_records (sid, asid, s_name, as_name, attend,process_by) VALUES (:sid, :asid, :s_name, :as_name, NOW(),:process_by)");
    $attendance->execute(array(
        ":sid" => $sid,
        ":asid" => $asid,
        ":s_name" => $getInformation->lname . " " . $getInformation->fname,
        ":as_name" => $activity,
        ":process_by" => $_SESSION['lname'] . " " . $_SESSION['fname']
    ));

    // Debug information (optional)
    // var_dump([
    //     "id" => $sid,
    //     "asid" => $asid,
    //     "Fname" => $getInformation->fname,
    //     "Lname" => $getInformation->lname,
    //     "Activity" => $activity
    // ]);
    // die();

    // Redirect after attendance is recorded
    header("location: other-attendance.php?id=".$asid."&activity=".$activity);
    exit();
} else {
    echo "Student not found.";
}
?>
