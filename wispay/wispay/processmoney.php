<?php
include_once ("config/config.php");
session_start();
if(!isset($_SESSION["username"])) {
    header("location:index.php");
}
date_default_timezone_set("Asia/Manila");
$refcode = uniqid("WIS-");

$statement = $DB_con->prepare('INSERT INTO wispay (debit, credit, rfid, refcode, transdate, processedby) VALUES (:debit, :credit, :rfid, :refcode, :transdate, :processedby)');
$statement->execute([
    'debit' => $_POST['amount'],
    'credit' => '0',
    'rfid' => $_POST['rfid'],
    'refcode' => $refcode,
    'transdate' => date('Y-m-d H:i:s'),
    'processedby' => $_SESSION['fname']." ".$_SESSION['lname']
]);

header("Location: showhistory.php?success=1&rfid=".$_POST['rfid']."&refcode=".$refcode);
die();