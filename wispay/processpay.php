<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("location: index.php");
}

    $processedby = $_SESSION['fname']." ".$_SESSION['lname'];
    $refcode = uniqid("WIS-");

    $bal = $DB_con->prepare("SELECT sum(credit)-sum(debit) as ctot FROM wispay WHERE rfid = :rfid");
    $bal->bindParam(':rfid', $_POST['rfid']);
    $bal->execute();
    $rbal = $bal->fetchAll();

    if(!empty($rbal)) {
        foreach($rbal as $brow) {
            if($brow['ctot']>$_POST['amount']){
                $pay = "INSERT INTO wispay ( debit, rfid, refcode, transdate, processedby) VALUES ( :debit, :rfid, :refcode, NOW(), :processedby )";
                $pay_statement = $DB_con->prepare( $pay );
                $pay_statement->execute( array( ':debit'=>$_POST['amount'], ':rfid'=>$_POST['rfid'], ':refcode'=>$refcode, ':processedby'=>$processedby) );
                header("location: pay.php?success=1");
            } else {
                header("location: pay.php?success=0");
            }
        }
    }