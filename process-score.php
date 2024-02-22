<?php
include_once "includes/config.php";
//ini_set('display_errors', 0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}
?><!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>

<script>
    window.location.replace("show-students.php?code=<?php echo $_POST["subjcode"]; ?>&section=<?php echo $_POST["section"];  ?>");
</script>
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
                                <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-book"></i></span> Edit Grade</h3>
                            </div>
                             <div class="card-body">
                                <?php
                                    $update = $DB_con->prepare("UPDATE s_scores SET score = :score WHERE actid = :actid AND sid = :sid");
                                    $update->execute(array(":score"=>$_POST["score"], ":actid"=>$_POST["actid"], ":sid"=>$_POST["sid"]));
                                ?>

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
</div>

</body>

</html>