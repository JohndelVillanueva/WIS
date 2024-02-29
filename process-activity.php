<?php
include_once "includes/config.php";
session_start();

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

include_once "includes/css.php";

$acttype = $_POST["acttype"];
$subjcode = $_POST["subjcode"];
$subjlvl = $_POST["subjlvl"];
$section = $_POST["section"];
$actdesc = $_POST["actdesc"];
$actqtr = $_POST["actqtr"];
$maxscore = $_POST["maxscore"];

$DB_con->beginTransaction();

try {
    $checkrecord = $DB_con->prepare("SELECT * FROM s_activities WHERE acttype = :acttype ORDER BY actid DESC LIMIT 1");
    $checkrecord->execute(array(":acttype" => $acttype));

    if ($checkrecord->rowCount() > 0) {
        $checkresult = $checkrecord->fetchAll();
        foreach ($checkresult as $checkrow) {
            $numbers = preg_replace('/[^0-9]/', '', $checkrow["actid"]);
            $letters = preg_replace('/[^a-zA-Z]/', '', $checkrow["actid"]);
            $newserial = $letters . str_pad($numbers + 1, 5, '0', STR_PAD_LEFT);
            $serial = ($acttype == 1) ? "WW" : (($acttype == 2) ? "PT" : "QT");
            $serial .= str_pad($numbers + 1, 5, '0', STR_PAD_LEFT);

            $insertact = $DB_con->prepare("INSERT INTO s_activities (actid, subjcode, actlvl, actsection, actdate, actcreate, actdesc, acttype, actqtr, maxscore) 
                                            VALUES (:actid, :subjcode, :actlvl, :actsection, NOW(), :actcreate, :actdesc, :acttype, :actqtr, :maxscore)");
            $insertact->execute(array(":actid" => $serial, ":subjcode" => $subjcode, ":actlvl" => $subjlvl, ":actsection" => $section, ":actcreate" => $_SESSION["fname"] 
            . " " . $_SESSION["lname"], ":actdesc" => $actdesc, ":acttype" => $acttype, ":actqtr" => $actqtr, ":maxscore" => $maxscore));
            header("location: add-grades.php?actid=" . urlencode($serial) . "&subjcode=$subjcode&section=$section&acttype=$acttype");
        }
    } else {
        // Set a default value for $numbers if no records are found
        $numbers = 0;
        
        $serial = ($acttype == 1) ? "WW" : (($acttype == 2) ? "PT" : "QT");
        $serial .= str_pad($numbers + 1, 5, '0', STR_PAD_LEFT);

        $insertact = $DB_con->prepare("INSERT INTO s_activities (actid, subjcode, actlvl, actsection, actdate, actcreate, actdesc, acttype, actqtr, maxscore) 
                                    VALUES (:actid, :subjcode, :actlvl, :actsection, NOW(), :actcreate, :actdesc, :acttype, :actqtr, :maxscore)");
        $insertact->execute(array(":actid" => $serial, ":subjcode" => $subjcode, ":actlvl" => $subjlvl, ":actsection" => $section, ":actcreate" => $_SESSION["fname"] 
        . " " . $_SESSION["lname"], ":actdesc" => $actdesc, ":acttype" => $acttype, ":actqtr" => $actqtr, ":maxscore" => $maxscore));
        header("location: add-grades.php?actid=" . urlencode($serial) . "&subjcode=$subjcode&section=$section&acttype=$acttype");
    }

    $DB_con->commit();
} catch (PDOException $e) {
    $DB_con->rollBack();
    echo "Error: " . $e->getMessage();
}



include_once "includes/footer.php";
include_once "includes/scripts.php";
?>
