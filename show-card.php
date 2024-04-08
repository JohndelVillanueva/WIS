<?php
include_once "includes/config.php";
include "includes/dbconfig.php";
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
                                <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-user"></i></span> <?php echo $_SESSION["fname"]." ".$_SESSION["lname"]; ?></h3>
                            </div>
                             <div class="card-body">
                                 <table class="table table-bordered table-hover">
                                     <thead>
                                        <tr class="text-center bg-dark">
                                            <th class="text-white font-size-16">Subject</th>
                                            <th class="text-white font-size-16">1st Quarter</th>
                                            <th class="text-white font-size-16">2nd Quarter</th>
                                            <th class="text-white font-size-16">3rd Quarter</th>
                                            <th class="text-white font-size-16">4th Quarter</th>
                                            <th class="text-white font-size-16">Final Grade</th>
                                            <th class="text-white font-size-16">Remarks</th>
                                        </tr>
                                     </thead>
                                     <tbody>
                                 <?php
                                    $subjects = $DB_con->prepare("SELECT * FROM s_subjects WHERE subjlevel = :subjlevel");
                                    $subjects->execute(array(":subjlevel"=>$_SESSION["grade"]));
                                    $subject = $subjects->fetchAll();

                                    foreach($subject as $subjrow) {
                                        ?>
                                            <tr>
                                                <td><?php echo $subjrow["subjdesc"];?></td>
                                                <td>
                                                    <?php

                                                        $wwq1 = new DB;
                                                        $wwq1->getScores($subjrow["code"],1,1,$_SESSION["username"]);
                                                        $wwq1->close();

                                                        if(!empty($wwq1)) {
                                                            foreach ($wwq1 as $wwq1score) {
                                                                var_dump($wwq1score);
                                                            }
                                                        }

                                                    ?>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php
                                    }

                                 ?>
                                     </tbody>
                                 </table>
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