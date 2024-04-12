<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}

$attendance = $DB_con->prepare("DELETE FROM afterschool_activities WHERE id = :id");
$attendance->execute(array(
    ":id" => $_GET["id"],
));

header("location: other-activities.php");
