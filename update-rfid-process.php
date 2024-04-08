<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}

$checkuser = $DB_con->prepare("SELECT rfid FROM user WHERE rfid = :rfid");
$checkuser->execute(array(":rfid"=>$_POST["oldRFID"]));

if($checkuser->rowCount() != 0) {
    $updateuserdb = $DB_con->prepare("UPDATE user SET rfid = :newrfid WHERE rfid = :oldrfid");
    $updateuserdb->execute(array(":newrfid"=>$_POST["newRFID"], ":oldrfid"=>$_POST["oldRFID"]));

    $updateWISPay = $DB_con->prepare("UPDATE wispay SET rfid = :newrfid WHERE rfid = :oldrfid");
    $updateWISPay->execute(array(":newrfid"=>$_POST["newRFID"], ":oldrfid"=>$_POST["oldRFID"]));

    ?>
    <script>
        window.location.replace("update-rfid.php?success=1&rfid=<?php echo $_POST["newRFID"]; ?>");
    </script>
    <?php
} else {
    echo "No USER with that RFID found!";

    ?>
    <script>
        window.location.replace("update-rfid.php?success=0&rfid=<?php echo $_POST["oldRFID"]; ?>");
    </script>
    <?php
}
?>