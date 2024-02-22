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
                                <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-book"></i></span> Registrar Verification - <?php echo $_GET["section"]; ?></h3>
                            </div>
                             <div class="card-body">
                                 <div class="row">
                                     <table class="table table-hover table-bordered table-condensed">
                                         <tbody>
                                         <tr>
                                             <td class="alert-success text-center font-size-14 bold" style="width:250px!important;">Student </td>
                                             <td class="alert-success text-center font-size-14 bold">Subject Description</td>
                                             <td class="alert-success text-center font-size-14 bold">Subject Teacher</td>
                                         </tr>
                                         <?php
                                            $student = $DB_con->prepare("SELECT * FROM user WHERE section = :section AND position = 'Student'");
                                            $student->execute(array(":section"=>$_GET["section"]));
                                            $students = $student->fetchAll();

                                             foreach($students as $srow) { ?>
                                                 <tr>
                                                     <td><?php echo $srow["code"];?></td>
                                                     <td><?php echo $srow["subjdesc"];?></td>
                                                     <td><?php echo $srow["fname"]." ".$srow["lname"];?></td>
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