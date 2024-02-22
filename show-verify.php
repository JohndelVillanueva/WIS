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
	
<form>

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
                                <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-book"></i></span> Registrar Verification</h3>
                            </div>
                             <div class="card-body">
                                 <div class="row">
                                 <?php
                                    $gradelevels = $DB_con->prepare("SELECT DISTINCT section, grade FROM user WHERE position = 'Student' ORDER BY LENGTH(grade), grade ASC");
                                    $gradelevels->execute();
                                    $gradelevel = $gradelevels->fetchAll();

                                    foreach($gradelevel as $graderow){ ?>
                                        <div class="col-lg-2">
                                            <div class="card alert-primary">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <p class="m-b-0">Year Level</p>
                                                            <h3 class="m-b-0">
                                                                <span><a href="show-class-subjects.php?grade=<?php echo $graderow["grade"]; ?>&section=<?php echo $graderow["section"]; ?>" class="link-primary"><?php echo $graderow["grade"]." - ".$graderow["section"];?></a></span>
                                                            </h3>
                                                        </div>
                                                        <div class="avatar avatar-icon avatar-lg avatar-blue">
                                                            <i class="anticon anticon-idcard"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                 ?>
                                 </div>
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