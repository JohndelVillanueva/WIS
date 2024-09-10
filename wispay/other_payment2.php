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

    try {
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
            $balanceQuery = $DB_con->prepare("SELECT SUM(credit) - SUM(debit) as ctot FROM wispay WHERE rfid = :rfid");
            $balanceQuery->execute([
                ':rfid' => $_POST['rfid']
            ]);
            $remainingBalance = $balanceQuery->fetch(PDO::FETCH_ASSOC);

            if ($remainingBalance) {
                $newBalance = $remainingBalance['ctot'];
                $notPaidAmount =  $_POST['amount'];
                // inserting to wispay if the new balance is greater than or equal to -1000
                if ($newBalance - $notPaidAmount >= 0) {
                    $pay = "INSERT INTO wispay (debit, rfid, refcode, product_name, empid, transdate, processedby) 
                            VALUES (:debit, :rfid, :refcode, :product_type, :empid, NOW(), :processedby)";
                    $pay_statement = $DB_con->prepare($pay);
                    $pay_statement->execute([
                        ':debit' => $notPaidAmount,
                        ':rfid' => $_POST['rfid'],
                        ':refcode' => $refcode,
                        ':product_type' => "Other Item",
                        ':empid' => $firstname . " " . $lastname,
                        ':processedby' => $processedby
                    ]);
                    header("Location: other_payment.php?success=1");
                    exit();
                } else {
                    header("Location: other_payment.php?success=0");
                    exit();
                }
            } else {
                header("Location: other_payment.php?error=no_balance");
                exit();
            }
        } else {
            header("Location: other_payment.php?error=user_not_found");
            exit();
        }
    } catch (PDOException $e) {
        // Log error and redirect to an error page
        error_log("Database error: " . $e->getMessage());
        header("Location: other_payment.php?error=db_error");
        exit();
    }
} else {
    header("Location: other_payment.php?error=missing_data");
    exit();
}
?>
