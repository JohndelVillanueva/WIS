<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}

$checkabsent = $DB_con->prepare("SELECT * FROM s_classattendance WHERE DATE(adate) = CURDATE() AND subjid = :subjid AND studid = :studid");
$checkabsent->execute(array(":subjid"=>$_GET["subjid"], ":studid"=>$_GET["studid"]));


if($checkabsent->rowCount() <= 0) {
    $markabsent = $DB_con->prepare("INSERT INTO s_classattendance (attendance, subjid, studid, adate, tid, notes) VALUES (:attendance, :subjid, :studid, :adate, :tid, :notes)");
    if($_GET["att"] == 0)
    {
        $notes = "Absent";
    } elseif ($_GET["att"] == 1) {
        $notes = "Tardy - ".date('H:i:s');
    } elseif ($_GET["att"] == 2) {
        $notes = "Excused";
    } elseif ($_GET["att"] == 3) {
        $notes = "Clinic";
    } elseif ($_GET["att"] == 4) {
        $notes = "PBIS";
    } else {
        $notes = "No Record";
    }
    $markabsent->execute(array(
        ":attendance" => $_GET["att"],
        ":subjid" => $_GET["subjid"],
        ":studid" => $_GET["studid"],
        ":adate" => date('Y-m-d H:i:s'),
        ":tid" => $_SESSION["username"],
        ":notes" => $notes
    ));
} else {
    $markabsent = $DB_con->prepare("UPDATE s_classattendance SET attendance = :attendance, adate=:adate, notes=:notes WHERE subjid = :subjid AND studid = :studid");
    if($_GET["att"] == 0)
    {
        $notes = "Absent";
    } elseif ($_GET["att"] == 1) {
        $notes = "Tardy - ".date('H:i:s');
    } elseif ($_GET["att"] == 2) {
        $notes = "Excused";
    } elseif ($_GET["att"] == 3) {
        $notes = "Clinic";
    } elseif ($_GET["att"] == 4) {
        $notes = "PBIS";
    } else {
        $notes = "No Record";
    }
    $markabsent->execute(array(
        ":attendance" => $_GET["att"],
        ":subjid" => $_GET["subjid"],
        ":studid" => $_GET["studid"],
        ":adate"=>date('Y-m-d H:i:s'),
        ":notes" => $notes
    ));
}
?>
<script>
   window.location.replace("check-attendance.php?code=<?php echo $_GET["subjid"]?>&section=<?php echo $_GET["section"]?>");
</script>
