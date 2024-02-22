<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}

$subjects = $DB_con->prepare("SELECT * FROM s_subjects WHERE code = :code");
$subjects->execute(array(":code" => $_GET["code"]));
$result = $subjects->fetchAll();

foreach($result as $subjrow) {

?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>
<link href="assets/vendors/select2/select2.css" rel="stylesheet">

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
                                <form method="post" action="process-activity.php">
                                <div class="card-header bg-warning rounded-top pt-2">
                                    <h4><span class="icon-holder"><i class="anticon anticon-diff"></i></span> Create New Activity - <?php echo $subjrow["subjdesc"]." ".$subjrow["subjlevel"]." (".$_GET["code"].")"; ?></h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <input type="text" class="form-control" name="actdesc" placeholder="Activity Name / Description" autofocus required>
                                        </div>
                                        <div class="col-lg-2">
                                            <input type="text" class="form-control" name="maxscore" placeholder="Maximum Score" required>
                                        </div>
                                        <div class="col-lg-3">
                                            <select class="form-control" name="acttype" required>
                                                <option value="0" selected disabled>Select Activity Type</option>
                                                <option value="1">Written Work</option>
                                                <option value="2">Performance Task</option>
                                                <option value="3">Quarterly Exam</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <select class="form-control" name="actqtr" required>
                                                <option value="0" selected disabled>Select Quarter</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>
                                            <input type="hidden" name="section" value="<?php echo $_GET["section"]; ?>">
                                            <input type="hidden" name="subjcode" value="<?php echo $_GET["code"]; ?>">
                                            <input type="hidden" name="subjlvl" value="<?php echo $subjrow["subjlevel"]; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-light text-center">
                                    <button type="submit" class="btn btn-success btn-block">Add Activity</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <!-- form ends !-->
            </div>
        <?php include_once "includes/footer.php"; ?>
    </div>
<?php include_once "includes/scripts.php";?>
</div>
</div>
<?php } ?>
</body>
<script src="assets/vendors/select2/select2.min.js"></script>
<script>
    new DataTable('#datatabel', {
    });
</script>
</html>