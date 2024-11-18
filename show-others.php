<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}

if (isset($_GET["asid"], $_GET["fname"], $_GET["mname"], $_GET["lname"])) {
    
    // Begin a transaction to ensure both inserts succeed or fail together
    $DB_con->beginTransaction();
    
    try {
        // Insert student details
        $addstudent = $DB_con->prepare("INSERT INTO afterschool_students (fname, mname, lname) VALUES (:fname, :mname, :lname)");
        $addstudent->execute(array(
            ":fname" => $_GET["fname"],
            ":mname" => $_GET["mname"],
            ":lname" => $_GET["lname"],
        ));
        
        // Retrieve last inserted ID directly from the PDO object
        $lastId = $DB_con->lastInsertId();
        
        // Insert into enrollment table
        $enrollstudent = $DB_con->prepare("INSERT INTO afterschool_enrolled (sid, asid, student_name, enrolldate) VALUES (:sid, :asid,:student_name, NOW())");
        $enrollstudent->execute(array(
            ":sid" => $lastId,
            ":asid" => $_GET["asid"],
            ":student_name" => $_GET["fname"]. " ". $_GET["lname"]
        ));
        
        // Commit the transaction
        $DB_con->commit();
        
        // Redirect to the specified page
        header("location: show-others.php?id=" . $_GET["asid"]);
        exit();
        
    } catch (PDOException $e) {
        // Roll back the transaction if any query fails
        $DB_con->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Required data is missing.";
}

?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>
	
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
                                     <div class="col-lg-12">
                                         <div class="dropdown float-right">
                                             <button class="btn btn-lg btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                 <span class="icon-holder"><i class="anticon anticon-contacts"></i></span> Actions
                                             </button>
                                             <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                 <a class="dropdown-item" type="button" data-toggle="modal" data-target="#addStudent"><span class="icon-holder"><i class="anticon anticon-user-add"></i></span> Add Student</a>
                                                 <a class="dropdown-item" href="other-attendance.php?id=<?php echo $_GET["id"];?>&activity=<?php echo $_GET["activity"];?>"><span class="icon-holder"><i class="anticon anticon-usergroup-add"></i></span> Check Attendance</a>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row pt-2">
                                    <table class="table table-hover table-bordered text-center">
                                        <thead class="thead-purple">
                                            <tr>
                                                <th>ID</th>
                                                <th>Last Name</th>
                                                <th>First Name</th>
                                                <th>Enroll Date</th>
                                                <th>Sessions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $getstudents = $DB_con->prepare("SELECT * FROM afterschool_students AS a INNER JOIN afterschool_enrolled AS b ON a.id = b.sid WHERE b.asid = :asid");
                                                $getstudents->execute(array(":asid"=>$_GET["id"]));
                                                $students = $getstudents->fetchAll();

                                                if($getstudents->rowCount()!=0) {
                                                foreach($students as $rec) {
                                            ?>
                                            <tr>
                                                <td><?php echo $rec["id"]; ?></td>
                                                <td><?php echo $rec["lname"]; ?></td>
                                                <td><?php echo $rec["fname"]; ?></td>
                                                <td><?php echo $rec["enrolldate"]; ?></td>
                                                <td style="width: 8.33%">
                                                    <?php
                                                        $getsessions = $DB_con->prepare("SELECT * FROM afterschool_records WHERE sid = :sid AND asid = :asid");
                                                        $getsessions->execute(array(":sid"=>$rec["id"], ":asid"=>$row["id"]));
                                                        $sessions = $getsessions->fetchAll();
                                                    ?>
                                                    <button class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample<?php echo $rec["id"]; ?>" aria-expanded="false" aria-controls="collapseExample">
                                                        <?php echo $getsessions->rowCount()." / ".$row["max"]; ?> <span class="icon-holder"><i class="anticon anticon-caret-down"></i></span>
                                                    </button>
                                                    <div class="collapse" id="collapseExample<?php echo $rec["id"]; ?>">
                                                        <div class="card card-body">
                                                            <?php
                                                            if($getsessions->rowCount()!=0) {
                                                            foreach($sessions as $srow) {
                                                                echo " ".$srow["attend"]." ". $_SESSION['fname']. "<br>";
                                                            } } else {
                                                                ?>
                                                                <div class="alert alert-warning" role="alert">
                                                                    No Record
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                                }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="6">
                                                            <div class="alert alert-warning" role="alert">
                                                                No Students Enrolled.
                                                            </div>
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
                <?php } ?>
                </div>
            <?php include_once "includes/footer.php"; ?>
            </div>
        <?php include_once "includes/scripts.php";?>
            <script>
                $(document).ready(function(){
                    $('[data-toggle="popover"]').popover();
                });
            </script>
        </div>
    </div>
</div>

    <!-- Modal -->
    <div class="modal fade" id="addStudent" tabindex="-1" role="dialog" aria-labelledby="addStudentTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStudentTitle"><span class="icon-holder"><i class="anticon anticon-file-add"></i></span> Add New Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="activityName">Last Name</label>
                                <input type="text" name="lname" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label for="activityName">First Name</label>
                                <input type="text" name="fname" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label for="activityName">Middle Name</label>
                                <input type="text" name="mname" class="form-control" value=" " required>
                                <input type="hidden" name="asid" value="<?php echo $_GET["id"];?>">
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Enroll Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>