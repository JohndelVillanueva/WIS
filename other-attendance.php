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
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-warning">
                                        <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-calendar"></i></span> Attendance</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-hover table-bordered text-center">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th>Last Name</th>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Attendance</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $getenrolled = $DB_con->prepare("SELECT * FROM afterschool_students AS a INNER JOIN afterschool_enrolled AS b ON a.id = b.sid WHERE b.asid = :id");
                                            $getenrolled->execute(array(
                                                ":id"=>$_GET["id"]
                                            ));
                                            $enrolled = $getenrolled->fetchAll();
                                            foreach($enrolled as $students) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $students["lname"]; ?></td>
                                                    <td><?php echo $students["fname"]; ?></td>
                                                    <td><?php echo $students["mname"]; ?></td>
                                                    <td>
                                                        <?php
                                                            $checkattendance = $DB_con->prepare("SELECT * FROM afterschool_records WHERE asid = :asid AND sid = :sid");
                                                            $checkattendance->execute(array(
                                                                ":asid"=> $students["asid"],
                                                                ":sid"=> $students["id"],
                                                            ));
                                                            $attendee = $checkattendance->fetchAll();
                                                            if($checkattendance->rowCount()==0) {
                                                                ?>
                                                                <a href="mark-other.php?sid=<?php echo $students["id"]; ?>&asid=<?php echo $students["asid"]; ?>&activity=<?php echo $_GET['activity']; ?>" class="btn btn-primary btn-lg"><span class="icon-holder"><i class="anticon anticon-check"></i></span></a>
                                                                <?php
                                                            } else {
                                                                ?><span class="icon-holder"><i class="anticon anticon-check text-success"></i></span><?php
                                                            }
                                                        ?>

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