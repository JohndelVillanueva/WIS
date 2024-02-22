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
                                <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-book"></i></span> Registrar Verification - <?php echo $_GET["grade"]." - ".$_GET["section"]; ?></h3>
                            </div>
                             <div class="card-body">
                                 <div class="row">
                                     <table class="table table-hover table-bordered table-condensed">
                                         <tbody>
                                         <tr>
                                             <td class="alert-success text-center font-size-14 bold" style="width:250px!important;">Subject ID</td>
                                             <td class="alert-success text-center font-size-14 bold">Subject Descriptioni
                                             <td class="alert-success text-center font-size-14 bold">Subject Teacher</td>
                                             <td class="alert-success text-center font-size-14 bold" style="width:250px!important;">Action</td>
                                         </tr>
                                         <?php
                                             $subject = $DB_con->prepare("SELECT * FROM s_subjects INNER JOIN user ON s_subjects.tid = user.username WHERE s_subjects.subjlevel = :subjlevel");
                                             $subject->execute(array(":subjlevel"=>$_GET["grade"]));
                                             $subjects = $subject->fetchAll();

                                             foreach($subjects as $srow) { ?>
                                                 <tr>
                                                     <td><?php echo $srow["code"];?></td>
                                                     <td><?php echo $srow["subjdesc"];?></td>
                                                     <td><?php echo $srow["fname"]." ".$srow["lname"];?></td>
                                                     <td>
                                                         <?php
                                                            $submitted = $DB_con->prepare("SELECT * FROM s_scores WHERE flag = 1 AND subjcode = :code");
                                                            $submitted->execute(array(":code"=>$srow["code"]));

                                                            if ($submitted->rowCount() != 0) {
                                                                ?>
                                                                <a href="show-class-grades.php?code=<?php echo $srow["code"];?>&section=<?php echo $_GET["section"]?>" class="btn btn-rounded btn-success"><span class="icon-holder"><i class="anticon anticon-database"></i></span> Verify Submission</a>
                                                                <?php
                                                            } else {
                                                                echo "<button type='button' class= 'btn btn-rounded btn-default' disabled><span class='icon-holder'><i class='anticon anticon-question-circle'></i></span> Pending Submission</button>";
                                                            }
                                                         ?>

                                                     </td>
                                                 </tr>
                                             <?php }
                                         ?>
                                         </tbody>
                                     </table>
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