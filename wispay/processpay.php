<?php
require_once("config/config.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("location: index.php");
    exit();
}

// Check if the form is submitted and required fields are not empty
if (isset($_POST['submit']) && !empty($_POST['rfid']) && !empty($_POST['product']) && !empty($_POST['amount'])) {
    $processedby = $_SESSION['fname'] . " " . $_SESSION['lname'];
    $refcode = uniqid("WIS-");

    // Get user details
    try {
        $user_details = $DB_con->prepare('SELECT fname, lname FROM user WHERE rfid = :rfid');
        $user_details->execute([':rfid' => $_POST['rfid']]);
        $user = $user_details->fetch(PDO::FETCH_OBJ);

        if ($user) {
            $firstname = $user->fname;
            $lastname = $user->lname;

            // Check the current balance
            $balanceQuery = $DB_con->prepare("SELECT sum(credit) - sum(debit) as ctot FROM wispay WHERE rfid = :rfid");
            $balanceQuery->execute([':rfid' => $_POST['rfid']]);
            $remainingBalance = $balanceQuery->fetch(PDO::FETCH_ASSOC);

            // var_dump($remainingBalance);
            // die();

            if ($remainingBalance) {
                // Calculate the total amount
                $remainingBalance = floatval($remainingBalance['ctot']);
                $totalAmount = array_sum($_POST['amount']);
                // var_dump([
                //     "Total Amount" => $totalAmount,
                //     "Remaining Balance" => $remainingBalance,
                //     "Total" => $remainingBalance - $totalAmount
                // ]);
                // Check if the new balance would be -1000 or higher
                if ($remainingBalance - $totalAmount >= 0 ) {
                    // Insert each product and amount into the database
                    $pay = "INSERT INTO wispay (product, debit, rfid, refcode, empid, transdate, processedby) 
                            VALUES (:product, :debit, :rfid, :refcode, :empid, NOW(), :processedby)";
                    $pay_statement = $DB_con->prepare($pay);

                    for ($i = 0; $i < count($_POST['product']); $i++) {
                        $pay_statement->execute([
                            ':product' => $_POST['product'][$i],
                            ':debit' => $_POST['amount'][$i],
                            ':rfid' => $_POST['rfid'],
                            ':refcode' => $refcode,
                            ':empid' => $firstname . " " . $lastname,
                            ':processedby' => $processedby
                        ]);
                    }
                    // die("Success!");
                    header("Location: pay.php?success=1");
                    exit();
                } else {
                    // die("fail!");
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
    } catch (PDOException $e) {
        // Log the error and show a generic error message
        error_log($e->getMessage());
        header("Location: pay.php?error=database_error");
        exit();
    }
} else {
    header("Location: pay.php?error=missing_data");
    exit();
}
?>
