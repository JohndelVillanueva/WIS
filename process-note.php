<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}

$markabsent = $DB_con->prepare("UPDATE s_classattendance SET notes=:notes WHERE subjid = :subjid AND studid = :studid AND DATE(adate) = CURDATE()");
$markabsent->execute(array(
    ":notes"=>$_POST["notes"],
    ":subjid"=>$_POST["subjid"],
    ":studid"=>$_POST["studid"],
));
?>
<script>
    window.location.replace("check-attendance.php?code=<?php echo $_POST["subjid"]?>&section=<?php echo $_POST["section"]?>");
</script>