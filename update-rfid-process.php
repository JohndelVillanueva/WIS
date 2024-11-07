<?php
include_once "includes/config.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

// Ensure RFID fields are filled
$oldRFID = filter_input(INPUT_POST, 'oldRFID', FILTER_SANITIZE_STRING);
$newRFID = filter_input(INPUT_POST, 'newRFID', FILTER_SANITIZE_STRING);

if (empty($oldRFID) || empty($newRFID)) {
    header("location: update-rfid.php?success=0&message=" . urlencode("Both old and new RFID must be provided."));
    exit;
}

// Check if the old RFID exists in the database
$checkuser = $DB_con->prepare("SELECT rfid FROM user WHERE rfid = :rfid");
$checkuser->execute([':rfid' => $oldRFID]);

if ($checkuser->rowCount() != 0) {
    // Update RFID in 'user' table
    $updateuserdb = $DB_con->prepare("UPDATE user SET rfid = :newrfid WHERE rfid = :oldrfid");
    $updateuserdb->execute([':newrfid' => $newRFID, ':oldrfid' => $oldRFID]);

    // Update RFID in 'wispay' table
    $updateWISPay = $DB_con->prepare("UPDATE wispay SET rfid = :newrfid WHERE rfid = :oldrfid");
    $updateWISPay->execute([':newrfid' => $newRFID, ':oldrfid' => $oldRFID]);

    header("location: update-rfid.php?success=1&rfid=" . urlencode($newRFID));
    exit;
} else {
    header("location: update-rfid.php?success=0&message=" . urlencode("No user found with that RFID."));
    exit;
}
?>
