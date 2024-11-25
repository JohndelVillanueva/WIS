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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<style></style>
<style>
    body {
        background-image: url('assets/images/others/bg.jpg');
        /* You'll need to add your background image to this path */
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        background-repeat: no-repeat;
    }

    .dataTables_wrapper .dataTables_length select {
        min-width: 60px;
    }

    .dataTables_wrapper .dataTables_filter input {
        margin-left: 5px;
    }

    .table td {
        vertical-align: middle;
    }

    /* Add a semi-transparent overlay to improve content readability */
    .app {
        background-color: rgba(255, 255, 255, 0.9);
        min-height: 100vh;
    }

    /* Center buttons in the Actions column */
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    /* Make cards slightly transparent to show background */
    .card {
        background-color: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(5px);
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    /* Style the card header */
    .card-header.bg-warning {
        background-color: rgba(255, 193, 7, 0.9) !important;
        border-bottom: none;
    }

    /* Style the table */
    .table {
        background-color: rgba(255, 255, 255, 0.95);
    }

    .thead-purple {
        background-color: rgba(102, 51, 153, 0.9);
        color: white;
    }

    /* Style the modals */
    .modal-content {
        background-color: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
    }

    /* Modal styles */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Fixed position to the screen */
        top: 50%;
        /* Position from top 50% of the screen */
        left: 50%;
        /* Position from left 50% of the screen */
        transform: translate(-50%, -50%);
        /* Move the modal by half its width and height to center it */
        z-index: 9999;
        /* Ensure modal appears on top of other content */
        width: 80%;
        /* Modal width (adjustable) */
        max-width: 400px;
        /* Maximum width of the modal */
        padding: 10px;
        border-radius: 10px;
    }
    /* Modal content styling */
    .modal-content {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        text-align: center;
        color: white;
        /* Change text color to white */
        box-shadow: none;
    }

    /* Success style (green background) */
    .success {
        background-color: #81C784;
        /* Softer green background */
        color: white;
    }

    /* Delete style (red background) */
    .delete {
        background-color: #D32F2F;
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
                                            <div class="mb-3">
                                            <a href="other-activities.php" class="btn btn-secondary back-button" style="background-color: purple; border-color: purple;">
                                                <i class="anticon anticon-arrow-left"></i> Back
                                            </a>
                                            </div>
                                            <table id="studentsTable" class="table table-hover table-bordered text-center">
                                                <thead class="thead-purple">
                                                    <tr>
                                                        <th>Last Name</th>
                                                        <th>First Name</th>
                                                        <th>Middle Name</th>
                                                        <th>Payment</th>
                                                        <th>Attendance</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $getenrolled = $DB_con->prepare("
                                                            SELECT 
                                                                a.*, 
                                                                b.*,
                                                                r.payment_status,
                                                                r.attend,
                                                                (SELECT COUNT(*) FROM afterschool_records 
                                                                WHERE sid = a.id AND asid = b.asid) as attendance_count
                                                            FROM afterschool_students AS a 
                                                            INNER JOIN afterschool_enrolled AS b ON a.id = b.sid
                                                            LEFT JOIN afterschool_records AS r ON a.id = r.sid 
                                                                AND b.asid = r.asid 
                                                                AND DATE(r.attend) = CURRENT_DATE()
                                                            WHERE b.asid = :id
                                                        ");
                                                    $getenrolled->execute(array(":id" => $_GET["id"]));
                                                    $enrolled = $getenrolled->fetchAll();

                                                    foreach ($enrolled as $students) {
                                                        // Get total sessions for the activity
                                                        $getTotalSessions = $DB_con->prepare("SELECT max FROM afterschool_activities WHERE id = :asid");
                                                        $getTotalSessions->execute([":asid" => $students["asid"]]);
                                                        $activity = $getTotalSessions->fetch(PDO::FETCH_OBJ);
                                                        $totalSessions = $activity ? (int)$activity->max : 0;

                                                        // Check if student has reached max sessions
                                                        $isFinished = $students['attendance_count'] >= $totalSessions;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $students["lname"]; ?></td>
                                                            <td><?php echo $students["fname"]; ?></td>
                                                            <td><?php echo $students["mname"]; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($students["attend"]) {
                                                                    echo '<span class="badge ' .
                                                                        ($students["payment_status"] == 'Paid' ? 'badge-success' : 'badge-danger') .
                                                                        '">' . htmlspecialchars($students["payment_status"]) . '</span>';
                                                                } elseif (!$isFinished) {
                                                                ?>
                                                                    <label for="paid_<?php echo $students["id"]; ?>">
                                                                        <input type="checkbox" id="paid_<?php echo $students["id"]; ?>"
                                                                            name="payment_status" value="Paid"
                                                                            onchange="handlePaymentCheckbox(this, 'unpaid_<?php echo $students["id"]; ?>')"> Paid
                                                                    </label>
                                                                    <label for="unpaid_<?php echo $students["id"]; ?>" style="margin-left: 10px;">
                                                                        <input type="checkbox" id="unpaid_<?php echo $students["id"]; ?>"
                                                                            name="payment_status2" value="Unpaid"
                                                                            onchange="handlePaymentCheckbox(this, 'paid_<?php echo $students["id"]; ?>')"> Unpaid
                                                                    </label>
                                                                <?php
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($isFinished) {
                                                                ?>
                                                                    <button class="btn btn-success btn-lg" disabled>
                                                                        <span class="icon-holder"><i class="anticon anticon-check"></i> Finished</span>
                                                                    </button>
                                                                    <?php
                                                                } else {
                                                                    if (!$students["attend"]) {
                                                                    ?>
                                                                        <a href="#" class="btn btn-primary btn-lg"
                                                                            onclick="return markAttendance('<?php echo $students["id"]; ?>', 
                               '<?php echo $students["asid"]; ?>', 
                               '<?php echo urlencode($_GET['activity']); ?>');">
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
                    <!-- <div id="myModal" class="modal">
                        <div class="modal-content <?php echo $dialogClass; ?>">
                            <p><?php echo $message; ?></p>
                        </div>
                    </div> -->

                    <?php include_once "includes/footer.php"; ?>
                </div>
                <?php include_once "includes/scripts.php"; ?>
            </div>
        </div>
    </div>
</form>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

<script>
    // Function to handle payment checkbox changes
    function handlePaymentCheckbox(checkbox, oppositeCheckboxId) {
        if (checkbox.checked) {
            document.getElementById(oppositeCheckboxId).checked = false;
        }
    }

    // Function to mark attendance with payment status
    function markAttendance(sid, asid, activity, coach) {
        // Get the payment status from the checkbox
        var paidCheckbox = document.getElementById('paid_' + sid);
        var unpaidCheckbox = document.getElementById('unpaid_' + sid);
        var paymentStatus = '';

        if (paidCheckbox.checked) {
            paymentStatus = 'Paid';
        } else if (unpaidCheckbox.checked) {
            paymentStatus = 'Unpaid';
        } else {
            alert('Please select a payment status');
            return false;
        }

        if (confirm('Are you sure you want to mark this Student?')) {
            window.location.href = `mark-other.php?sid=${sid}&asid=${asid}&coach=${coach}&activity=${activity}&payment_status=${paymentStatus}&action=success`;
        }
        return false;
    }

    // Modal logic
    var modal = document.getElementById('myModal');

    <?php if ($message) { ?>
        modal.style.display = "block";
        setTimeout(function() {
            modal.style.display = "none";
        }, 5000);
    <?php } ?>

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    $(document).ready(function() {
        $('#studentsTable').DataTable({
            responsive: true,
            "pageLength": 10,
            "order": [
                [0, "asc"]
            ], // Sort by last name by default
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ students",
                "infoEmpty": "Showing 0 to 0 of 0 students",
                "emptyTable": "No students found",
                "zeroRecords": "No matching students found"
            },
            "columnDefs": [{
                "targets": [3, 4], // Payment and Attendance columns
                "orderable": false, // Disable sorting for these columns
                "searchable": false
            }],
            "drawCallback": function(settings) {
                // Re-initialize any tooltips or other plugins after draw
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
    });
</script>

</body>

</html>