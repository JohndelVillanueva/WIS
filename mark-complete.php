<?php
include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

$updatedocuments = $DB_con->prepare("UPDATE users24 SET isofficial = 1 WHERE uniqid = :uniqid");
$updatedocuments->execute(array(":uniqid" => $_GET["id"]));

header("Location: completed.php");
die();