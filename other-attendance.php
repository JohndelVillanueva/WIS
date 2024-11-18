<?php
include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-Type: text/html; charset=UTF-8");

$message = '';
$dialogClass = '';  // Default dialog class (empty)
if (isset($_GET['action'])) {
    if ($_GET['action'] == 'success') {
        $message = 'Attendance successfully marked!';
        $dialogClass = 'success';  // Green background for success
    } elseif ($_GET['action'] == 'delete') {
        $message = 'Attendance successfully deleted!';
        $dialogClass = 'delete';  // Red background for delete
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>
<style>
/* Modal styles */
/* Modal styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Fixed position to the screen */
    top: 50%; /* Position from top 50% of the screen */
    left: 50%; /* Position from left 50% of the screen */
    transform: translate(-50%, -50%); /* Move the modal by half its width and height to center it */
    z-index: 9999; /* Ensure modal appears on top of other content */
    width: 80%; /* Modal width (adjustable) */
    max-width: 400px; /* Maximum width of the modal */
    padding: 10px;
    border-radius: 10px;
}

/* Modal content styling */
.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
    color: white; /* Change text color to white */
    box-shadow: none;
}

/* Success style (green background) */
.success {
    background-color: #81C784   ; /* Softer green background */
    color: white;
}

/* Delete style (red background) */
.delete {
    background-color: #D32F2F    ;
    color: white;
}


</style>
<form>
<div class="app is-folded">
    <div class="layout">
        <?php include_once "includes/heading.php"; ?>
        <?php include_once "includes/sidemenu.php"; ?>
        <div class="page-container">
            <div class="main-content">
                <div class="row flex-nowrap overflow-auto">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-warning">
                                        <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-calendar"></i></span> Attendance - <?= $_GET['activity'] ?></h3>
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
                                                $getenrolled->execute(array(":id" => $_GET["id"]));
                                                $enrolled = $getenrolled->fetchAll();
                                                foreach ($enrolled as $students) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $students["lname"]; ?></td>
                                                        <td><?php echo $students["fname"]; ?></td>
                                                        <td><?php echo $students["mname"]; ?></td>
                                                        <td>
                                                            <?php
                                                            $today = date("Y-m-d");

                                                            // Get total sessions for the activity
                                                            $getTotalSessions = $DB_con->prepare("SELECT max FROM afterschool_activities WHERE id = :asid");
                                                            $getTotalSessions->execute([":asid" => $students["asid"]]);
                                                            $activity = $getTotalSessions->fetch(PDO::FETCH_OBJ);
                                                            
                                                            if ($activity) {
                                                                $totalSessions = (int)$activity->max;
                                                            
                                                                // Get attendance count for the student (check for all attendance, not just today)
                                                                $getAttendanceCount = $DB_con->prepare("SELECT COUNT(*) as attendance_count FROM afterschool_records WHERE asid = :asid AND sid = :sid");
                                                                $getAttendanceCount->execute([":asid" => $students["asid"], ":sid" => $students["id"]]);
                                                                $attendanceData = $getAttendanceCount->fetch(PDO::FETCH_OBJ);
                                                            
                                                                $currentAttendance = (int)$attendanceData->attendance_count;
                                                            
                                                                // Check if the student has already marked attendance for today
                                                                $checkTodayAttendance = $DB_con->prepare("SELECT * FROM afterschool_records WHERE asid = :asid AND sid = :sid AND DATE(attend) = :today");
                                                                $checkTodayAttendance->execute([":asid" => $students["asid"], ":sid" => $students["id"], ":today" => $today]);
                                                                $todayAttendance = $checkTodayAttendance->fetch();
                                                            
                                                                if ($currentAttendance >= $totalSessions) {
                                                                    ?>
                                                                    <button class="btn btn-success btn-lg" disabled>
                                                                        <span class="icon-holder"><i class="anticon anticon-check"></i> Finished</span>
                                                                    </button>
                                                                    <?php
                                                                } else {
                                                                    if (!$todayAttendance) {
                                                                        ?>
                                                                        <a href="mark-other.php?sid=<?php echo $students["id"]; ?>&asid=<?php echo $students["asid"]; ?>&activity=<?php echo $_GET['activity']; ?>&action=success" 
                                                                           class="btn btn-primary btn-lg" onclick="return confirm('Are you sure you want to mark this Student?');">
                                                                            <span class="icon-holder"><i class="anticon anticon-check"></i></span>
                                                                        </a>
                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <button class="btn btn-success btn-lg" disabled>
                                                                            <span class="icon-holder"><i class="anticon anticon-check"></i> Completed</span>
                                                                        </button>
                                                                        <a href="delete-attendance.php?sid=<?php echo $students["id"]; ?>&asid=<?php echo $students["asid"]; ?>&activity=<?php echo $_GET['activity']; ?>&action=delete" 
                                                                           class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to delete this attendance?');">
                                                                            <span class="icon-holder"><i class="anticon anticon-delete"></i> Delete</span>
                                                                        </a>
                                                                        <?php
                                                                    }
                                                                }
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
                </div>

                <!-- Modal -->
                <div id="myModal" class="modal">
                    <div class="modal-content <?php echo $dialogClass; ?>">
                        <p><?php echo $message; ?></p>
                    </div>
                </div>

            <?php include_once "includes/footer.php"; ?>
            </div>
        <?php include_once "includes/scripts.php"; ?>
        </div>
    </div>
</div>
</form>

<script>
    // Modal logic
    var modal = document.getElementById('myModal');

    // If a message is set (action parameter exists), display the modal
    <?php if ($message) { ?>
        modal.style.display = "block";
        // Hide the modal after 5 seconds
        setTimeout(function() {
            modal.style.display = "none";
        }, 5000); // 5000 milliseconds = 5 seconds
    <?php } ?>

    // Close the modal when the user clicks anywhere outside of the modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>
