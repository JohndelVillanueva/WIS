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

<div class="app is-folded">
    <div class="layout">
        <?php include_once "includes/heading.php"; ?>
        <?php include_once "includes/sidemenu.php"; ?>
        <div class="page-container">
            <div class="main-content">
                <!-- form starts !-->
                <div class="row flex-nowrap overflow-auto">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-warning">
                                <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-book"></i></span> Edit Grade - <?php echo $_GET["subjcode"]; ?></h3>
                            </div>
                            <div class="card-body">
                                <form method="post" action="process-score.php">
                                    <?php
                                    $student = $DB_con->prepare("SELECT * FROM user WHERE username = :username");
                                    $student->execute(array(":username" => $_GET["sid"]));
                                    $studentdetails = $student->fetchAll();

                                    foreach ($studentdetails as $studentrow) {
                                    ?>
                                        <div class="row">
                                            <div class="col-lg-3"><input class="form-control" value="<?php echo $studentrow["lname"] . ", " . $studentrow["fname"] . " " . $studentrow["mname"]; ?>" disabled></div>
                                            <div class="col-lg-1"><input class="form-control" value="<?php echo $studentrow["grade"] . " - " . $studentrow["section"]; ?>" disabled></div>
                                            <?php
                                            $grade = $DB_con->prepare("SELECT * FROM s_activities INNER JOIN s_scores ON s_activities.actid = s_scores.actid WHERE s_activities.actid = :code AND s_scores.sid = :sid");
                                            $grade->execute(array(":code" => $_GET["actid"], ":sid" => $_GET["sid"]));
                                            $egrade = $grade->fetchAll();

                                            foreach ($egrade as $graderow) {
                                                switch ($graderow["acttype"]) {
                                                    case 1:
                                                        $type = "Written Work";
                                                        break;
                                                    case 2:
                                                        $type = "Performance Task";
                                                        break;
                                                    case 3:
                                                        $type = "Quarterly Exam";
                                                        break;
                                                }
                                            ?>
                                                <div class="col-lg-2"><input class="form-control" value="Quarter <?php echo $graderow["actqtr"] . " - " . $type; ?>" disabled></div>
                                                <div class="col-lg-2"><input class="form-control" value="<?php echo $graderow["actdesc"]; ?>" disabled></div>
                                                <div class="col-lg-1"><input class="form-control" name="score" type="number" min="0" max="<?php echo $graderow["maxscore"]; ?>" value="<?php echo $graderow["score"]; ?>" autofocus></div>
                                                <div class="col-lg-1"><input class="form-control" type="text" value="/ <?php echo $graderow["maxscore"]; ?>" disabled></div>
                                                <div class="col-lg-2"><button type="submit" class="btn btn-primary btn-tone btn-rounded btn-block"><i class="anticon anticon-lock"></i>Submit Changes</button></div>
                                                <input type="hidden" name="sid" value="<?php echo $_GET["sid"]; ?>">
                                                <input type="hidden" name="actid" value="<?php echo $_GET["actid"]; ?>">
                                                <input type="hidden" name="section" value="<?php echo $_GET["section"]; ?>">
                                                <input type="hidden" name="subjcode" value="<?php echo $_GET["subjcode"]; ?>">
                                            <?php }

                                            ?>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </form>
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
</div>

</body>

</html>