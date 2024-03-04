<?php
include_once "includes/config.php";
include_once "includes/css.php";


$checkuser = $DB_con->prepare("SELECT rfid FROM user WHERE rfid = :rfid");
$checkuser->execute(array(":rfid" => $_POST["oldRFID"]));


if ($checkuser->rowCount() != 0) {
    $updateuserdb = $DB_con->prepare("UPDATE user SET rfid = :newrfid WHERE rfid = :oldrfid");
    $updateuserdb->execute(array(":newrfid" => $_POST["newRFID"], ":oldrfid" => $_POST["oldRFID"]));

    $updateWISPay = $DB_con->prepare("UPDATE wispay SET rfid = :newrfid WHERE rfid = :oldrfid");
    $updateWISPay->execute(array(":newrfid" => $_POST["newRFID"], ":oldrfid" => $_POST["oldRFID"]));
?>
    <script>
        window.location.replace("dashboard.php?success=1&rfid=<?php echo $_POST["newRFID"]; ?>");
    </script>
<?php
} else {
    echo "No USER with that RFID found!";

?>
    <script>
        window.location.replace("dashboard.php?success=0&rfid=<?php echo $_POST["oldRFID"]; ?>");
    </script>
<?php

}


?>
<form method="post" action="dashboard.php">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <input type="oldRFID" class="form-control form-control-lg" name="oldRFID" aria-describedby="oldRFID" placeholder="OLD RFID" autofocus>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <input type="newRFID" class="form-control form-control-lg" name="newRFID" aria-describedby="newRFID" placeholder="NEW RFID">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <button type="submit" class="btn btn-lg btn-block btn-success">Submit Changes</button>
        </div>
    </div>
</form>