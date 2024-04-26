<?php 
include_once("./includes/config.php");
session_start();

$update = $DB_con->prepare("UPDATE s_subjects SET tid = :tid, assignedby = :assignedby, assigndate = NOW(), percentww = :percentww, percentpt = :percentpt, percentqt = :percentqt WHERE code = :code");
$update->execute(array(
    ":tid" => $_POST["teacher"],
    ":assignedby" => $_SESSION["fname"]." ".$_SESSION["lname"],
    ":percentww" => $_POST["percentww"],
    ":percentpt" => $_POST["percentpt"],
    ":percentqt" => $_POST["percentqt"],
    ":code" => $_POST["code"]
));
header("Location: assignsubj.php");