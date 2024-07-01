<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("location: index.php");
    exit();
}

if (isset($_POST['submit']) && !empty($_POST['amount']) && !empty($_POST['rfid'])) {
    $processedby = $_SESSION['fname'] . " " . $_SESSION['lname'];
    $refcode = uniqid("WIS-");

    // Get user details
    $user_details = $DB_con->prepare('SELECT fname, lname FROM user WHERE rfid = :rfid');
    $user_details->execute([
        ':rfid' => $_POST['rfid']
    ]);
    $user = $user_details->fetch(PDO::FETCH_OBJ);

    if ($user) {
        $firstname = $user->fname;
        $lastname = $user->lname;
        
        // Check if the new balance is at least -1000
        $balanceQuery = $DB_con->prepare("SELECT sum(debit)-sum(credit) as ctot FROM wispay WHERE rfid = :rfid");
        $balanceQuery->execute([
            ':rfid' => $_POST['rfid']
        ]);
        $remainingBalance = $balanceQuery->fetch(PDO::FETCH_ASSOC);

        if ($remainingBalance) {
            // inserting to wispay if success
            if ($remainingBalance['ctot'] >= $_POST['amount'] || $remainingBalance['ctot'] <= -1000) {
                $pay = "INSERT INTO wispay (credit, rfid, refcode, empid, transdate, processedby) 
                        VALUES (:credit, :rfid, :refcode, :empid, NOW(), :processedby)";
                $pay_statement = $DB_con->prepare($pay);
                $pay_statement->execute([
                    ':credit' => $_POST['amount'],
                    ':rfid' => $_POST['rfid'],
                    ':refcode' => $refcode,
                    ':empid' => $firstname . " " . $lastname,
                    ':processedby' => $processedby
                ]);
                header("Location: pay.php?success=1");
                exit();
            } else {
                header("Location: pay.php?success=0");
                exit();
            }
        } else {
            header("Location: pay.php?error=no_balance");
            exit();
        }
    } else {
        header("Location: pay.php?error=user_not_found");
        exit();
    }
}