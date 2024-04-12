<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}

$attendance = $DB_con->prepare("INSERT INTO afterschool_records (sid, asid, attend) VALUES (:sid, :asid, NOW())");
$attendance->execute(array(
    ":sid" => $_GET["sid"],
    ":asid" => $_GET["asid"]
));

header("location: other-attendance.php?id=".$_GET["asid"]);
