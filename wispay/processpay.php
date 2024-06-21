<?php
require_once("config/config.php");
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION["username"])) {
    header("location: index.php");
    exit;
}

$processedby = $_SESSION['fname'] . " " . $_SESSION['lname'];
$refcode = uniqid("WIS-");

// Calculate the current balance
$bal = $DB_con->prepare("SELECT SUM(credit) - SUM(debit) AS ctot FROM wispay WHERE rfid = :rfid");
$bal->execute([':rfid' => $_POST['rfid']]);
$rbal = $bal->fetchAll();

if (!empty($rbal)) {
    foreach ($rbal as $brow) {
        if ($brow['ctot'] > $_POST['amount']) {
            // Insert the payment record
            $pay = "INSERT INTO wispay (debit, rfid, refcode, transdate, processedby) 
                    VALUES (:debit, :rfid, :refcode, NOW(), :processedby)";
            $pay_statement = $DB_con->prepare($pay);
            $pay_statement->execute([
                ':debit' => $_POST['amount'],
                ':rfid' => $_POST['rfid'],
                ':refcode' => $refcode,
                ':processedby' => $processedby
            ]);
            header("location: pay.php?success=1");
            exit;
        } else {
            header("location: pay.php?success=0");
            exit;
        }
    }
}
?>
