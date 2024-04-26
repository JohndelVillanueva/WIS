<?php
include_once "includes/config.php";
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
                                <div class="card-header bg-warning rounded-top pt-2">
                                    <h4>
                                        <span class="icon-holder">
                                            <i class="anticon anticon-idcard"></i>
                                        </span>
                                        Edit Subject Assignment
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="assign.php">
                                        <?php
                                            $getsubject = $DB_con->prepare("SELECT * FROM s_subjects WHERE code = :code");
                                            $getsubject->execute(array(":code"=>$_GET["id"]));
                                            $subjects = $getsubject->fetchAll();

                                            foreach($subjects as $row) {
                                        ?>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="subjdesc">Subject Description</label>
                                                    <input type="text" class="form-control" id="subjdesc" name="subjdesc" value="<?php echo $row["subjdesc"]." - ".$row["subjlevel"]." ".$row["subjsection"]; ?>">
                                                    <input type="hidden" name="code" id="code" value="<?php echo $_GET["id"]; ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="subjdesc">Written Works</label>
                                                    <input type="text" class="form-control" id="percentww" name="percentww" value="<?php echo $row["percentww"];?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="subjdesc">Performance Task</label>
                                                    <input type="text" class="form-control" id="percentpt" name="percentpt" value="<?php echo $row["percentpt"];?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="subjdesc">Quarterly Exam</label>
                                                    <input type="text" class="form-control" id="percentqt" name="percentqt" value="<?php echo $row["percentqt"];?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="teacher">Teacher</label>
                                                    <select class="form-control form-select" id="teacher" name="teacher"  aria-label="Reassign">
                                                        <option value="<?php echo $row["tid"];?>" selected><?php echo $row["tid"];?></option>
                                                        <?php
                                                        $teacher = $DB_con->prepare("SELECT * FROM user WHERE position LIKE '%Teacher%' ORDER BY lname ASC");
                                                        $teacher->execute();
                                                        $tresult = $teacher->fetchAll();
                                                        foreach ($tresult as $trow) {
                                                            echo "<option value=\"" . $trow["username"] . "\">" . $trow["lname"] . ", " . $trow["fname"] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <div class="form-group">
                                                    <label for="submit">Actions</label>
                                                    <button type="submit"  id="submit" name="submit" class="btn btn-primary">Apply Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </form>
                                </div>
                                <div class="card-footer bg-light text-center"></div>
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
<script>
    new DataTable('#datatabel', {});
</script>

</html>