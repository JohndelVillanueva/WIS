<?php
include_once "includes/config.php";
session_start();

if(!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

// Ensure RFID fields are filled
if(empty($_POST['oldRFID']) || empty($_POST['newRFID'])) {
    echo "Both old and new RFID must be provided.";
    ?>
    <script>
        window.location.replace("update-rfid.php?success=0");
    </script>
    <?php
    exit;
}

// Sanitize inputs to prevent SQL injection
$oldRFID = htmlspecialchars(trim($_POST['oldRFID']));
$newRFID = htmlspecialchars(trim($_POST['newRFID']));

$checkuser = $DB_con->prepare("SELECT rfid FROM user WHERE rfid = :rfid");
$checkuser->execute(array(":rfid" => $oldRFID));
if($checkuser->rowCount() != 0) {
    // Update RFID in 'user' table
    $updateuserdb = $DB_con->prepare("UPDATE user SET rfid = :newrfid WHERE rfid = :oldrfid");
    $updateuserdb->execute(array(":newrfid" => $newRFID, ":oldrfid" => $oldRFID));

    // Update RFID in 'wispay' table
    $updateWISPay = $DB_con->prepare("UPDATE wispay SET rfid = :newrfid WHERE rfid = :oldrfid");
    $updateWISPay->execute(array(":newrfid" => $newRFID, ":oldrfid" => $oldRFID));

    ?>
    <script>
        window.location.replace("update-rfid.php?success=1&rfid=<?php echo $newRFID; ?>");
    </script>
    <?php
} else {
    echo "No user found with that RFID.";
    ?>
    <script>
        window.location.replace("update-rfid.php?success=0&rfid=<?php echo $oldRFID; ?>");
    </script>
    <?php
}
?>
