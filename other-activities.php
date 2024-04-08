<?php
include_once "includes/config.php";
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
                                <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-calendar"></i></span> Other Activities</h3>
                            </div>
                             <div class="card-body">
                                 <div class="row">
                                     <div class="col-lg-12">
                                         <button type="button" class="btn btn-primary float-right"><i class="anticon anticon-plus-square"></i> Add Activity</button>
                                     </div>
                                 </div>
                                 <div class="row pt-2">
                                     <table class="table table-hover table-bordered text-center">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Activity</th>
                                                <th>Coach</th>
                                                <th>Sessions</th>
                                                <th>Rate</th>
                                                <th style="width:8.33%">Actions</th>
                                                <th style="width:8.33%">Reports</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                         <?php
                                            $getactivities = $DB_con->prepare("SELECT * FROM afterschool_activities");
                                            $getactivities->execute();
                                            $result = $getactivities->fetchAll();
                                             foreach ($result as $row) {

                                         ?>

                                         <tr>
                                             <td><?php echo $row["id"];?></td>
                                             <td><?php echo $row["activity"];?></td>
                                             <td><?php echo $row["coach"];?></td>
                                             <td><?php echo $row["max"];?></td>
                                             <td>P <?php echo $row["rate"];?></td>
                                             <td>
                                                 <a type="button" class="btn btn-primary float-right" href="show-others.php?id=<?php echo $row["id"];?>"><i class="anticon anticon-eye"></i> Show Students</a>
                                             </td>
                                             <td>
                                                 <a type="button" class="btn btn-primary float-right" href="show-others-report.php?id=<?php echo $row["id"];?>"><i class="anticon anticon-area-chart"></i> Show Report</a>
                                             </td>
                                         </tr>
                                         <?php
                                             }
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