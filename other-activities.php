<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}

if(isset($_GET["activity"])) {
    $addactivity = $DB_con->prepare("INSERT INTO afterschool_activities (activity, coach, max, rate) VALUES (:activity, :coach, :sessions, :rate)");
    $addactivity->execute(array(
        ":activity"=>$_GET["activity"],
        ":coach"=>$_GET["coach"],
        ":sessions"=>$_GET["sessions"],
        ":rate"=>$_GET["rate"],
    ));
    header("location: other-activities.php");
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
                                         <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addActivity"><i class="anticon anticon-file-add"></i> Add Activity</button>
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
                                                <th style="width:8.33%">Remove</th>
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
                                                 <a type="button" class="btn btn-primary" href="show-others.php?id=<?php echo $row["id"];?>"><i class="anticon anticon-eye"></i> Show Students</a>
                                             </td>
                                             <td>
                                                 <a type="button" class="btn btn-danger" href="delete-other.php?id=<?php echo $row["id"];?>"><i class="anticon anticon-delete"></i> Remove</a>
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


    <!-- Modal -->
    <div class="modal fade" id="addActivity" tabindex="-1" role="dialog" aria-labelledby="addActivityTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="addActivityTitle"><span class="icon-holder"><i class="anticon anticon-file-add"></i></span> Add New Activity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="activityName">Activity Name</label>
                            <input type="text" name="activity" class="form-control" id="activityName" placeholder="Activity Name or Description" required>
                        </div>
                        <div class="col-12">
                            <label for="activityName">Coach Name</label>
                            <input type="text" name="coach" class="form-control" id="coachName" placeholder="Coach Name (Put TBA if no coach yet)" required>
                        </div>
                        <div class="col-12">
                            <label for="activityName">Sessions</label>
                            <input type="number" name="sessions" class="form-control" id="maxSession" placeholder="Max Sessions" required>
                        </div>
                        <div class="col-12">
                            <label for="activityName">Rate</label>
                            <input type="number" name="rate" class="form-control" id="sessionRate" placeholder="Rate" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Activity</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>