<?php
include_once "includes/config.php";
//ini_set('display_errors', 0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>

<body>
    <div class="app">
        <div class="layout">
            <?php include_once "includes/heading.php"; ?>
            <?php include_once "includes/sidemenu.php"; ?>
            <div class="page-container">
                <div class="main-content">
                    <!-- form starts !-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <?php
                                $checkrecord = $DB_con->prepare("SELECT * FROM s_activities WHERE acttype = :acttype ORDER BY actid DESC LIMIT 1");
                                $checkrecord->execute(array(":acttype" => $_POST["acttype"]));

                                if ($checkrecord->rowCount() > 0) {
                                    $checkresult = $checkrecord->fetchAll();
                                    foreach ($checkresult as $checkrow) {
                                        $numbers = preg_replace('/[^0-9]/', '', $checkrow["actid"]);
                                        $letters = preg_replace('/[^a-zA-Z]/', '', $checkrow["actid"]);
                                        $newserial = $letters . str_pad($numbers + 1, 5, '0', STR_PAD_LEFT);

                                        $insertact = $DB_con->prepare("INSERT INTO s_activities (actid, subjcode, actlvl, actsection, actdate, actcreate, actdesc, acttype, actqtr, maxscore)
                                        VALUES (:actid, :subjcode, :actlvl, :actsection, NOW(), :actcreate, :actdesc, :acttype, :actqtr, :maxscore)");
                                        $insertact->execute(array(":actid" => $newserial, ":subjcode" => $_POST["subjcode"], ":actlvl" => $_POST["subjlvl"], ":actsection" => $_POST["section"], ":actcreate" => $_SESSION["fname"] . 
                                        " " . $_SESSION["lname"], ":actdesc" => $_POST["actdesc"], ":acttype" => $_POST["acttype"], ":actqtr" => $_POST["actqtr"], ":maxscore" => $_POST["maxscore"]));
                                    }
                                } else {
                                    if ($_POST["acttype"] == 1) {
                                        $serial = "WW00001";
                                    } elseif ($_POST["acttype"] == 2) {
                                        $serial = "PT00001";
                                    } elseif ($_POST["acttype"] == 3) {
                                        $serial = "QT00001";
                                    }

                                    $insertact = $DB_con->prepare("INSERT INTO s_activities (actid, subjcode, actlvl, actsection, actdate, actcreate, actdesc, acttype, actqtr, maxscore) VALUES (:actid, :subjcode, :actlvl, :actsection, NOW(), :actcreate, :actdesc, :acttype, :actqtr, :maxscore)");
                                    $insertact->execute(array(":actid" => $serial, ":subjcode" => $_POST["subjcode"], ":actlvl" => $_POST["subjlvl"], ":actsection" => $_POST["section"], ":actcreate" => $_SESSION["fname"] . "
                                     " . $_SESSION["lname"], ":actdesc" => $_POST["actdesc"], ":acttype" => $_POST["acttype"], ":actqtr" => $_POST["actqtr"], ":maxscore" => $_POST["maxscore"]));

                                    ?>
                                    <script>
                                        window.location.replace("add-grades.php?actid=<?php echo $serial; ?>&subjcode=<?php echo $_POST["subjcode"]; ?>&section=<?php echo $_POST["section"]; ?>&acttype=<?php echo $_POST["acttype"]; ?>");
                                    </script>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- form ends !-->
                </div>
                <?php include_once "includes/footer.php"; ?>
            </div>
            <?php include_once "includes/scripts.php"; ?>
        </div>
    </div>
</body>

</html>
