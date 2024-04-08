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
                <?php
                $getactivity = $DB_con->prepare("SELECT * FROM afterschool_activities WHERE id = :id");
                $getactivity->execute(array(":id"=>$_GET["id"]));
                $result = $getactivity->fetchAll();

                foreach($result as $row) {

                ?>
                <!-- form starts !-->
                <div class="row flex-nowrap overflow-auto">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-warning">
                                <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-calendar"></i></span> Enrolled Students - <?php echo $row['activity']; ?> - Coach <?php echo $row['coach']; ?></h3>
                            </div>
                             <div class="card-body">
                                 <div class="row">
                                    <table class="table table-hover table-bordered text-center">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Last Name</th>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Session</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $getstudents = $DB_con->prepare("SELECT * FROM afterschool_students AS a INNER JOIN afterschool_enrolled AS b ON a.id = b.sid WHERE b.asid = :asid");
                                                $getstudents->execute(array(":asid"=>$_GET["id"]));
                                                $students = $getstudents->fetchAll();

                                                foreach($students as $rec) {
                                            ?>
                                            <tr>
                                                <td><?php echo $rec["id"]; ?></td>
                                                <td><?php echo $rec["lname"]; ?></td>
                                                <td><?php echo $rec["fname"]; ?></td>
                                                <td><?php echo $rec["mname"]; ?></td>
                                                <th><?php echo $getrecords->rowCount()."/".$row["max"]; ?></th>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                 </div>
                            </div>
                        </div>
                    </div>
                <!-- form ends !-->
                <?php } ?>
                </div>
            <?php include_once "includes/footer.php"; ?>
            </div>
        <?php include_once "includes/scripts.php";?>
        </div>
    </div>
</div>

</body>

</html>