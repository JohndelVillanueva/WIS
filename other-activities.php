<?php
include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["activity"])) {
    $addactivity = $DB_con->prepare("INSERT INTO afterschool_activities (activity, coach, max, rate) VALUES (:activity, :coach, :sessions, :rate)");
    $addactivity->execute([
        ":activity" => $_POST["activity"],
        ":coach" => $_POST["coach"],
        ":sessions" => $_POST["sessions"],
        ":rate" => $_POST["rate"],
    ]);
    header("location: other-activities.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "includes/css.php"; ?>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        body {
            background-image: url('assets/images/others/bg.jpg'); /* You'll need to add your background image to this path */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
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
    </style>
</head>

<body>
    <div class="app is-folded">
        <div class="layout">
            <?php include_once "includes/heading.php"; ?>
            <?php include_once "includes/sidemenu.php"; ?>
            <div class="page-container">
                <div class="main-content">
                    <div class="row flex-nowrap overflow-auto">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-warning">
                                    <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-calendar"></i></span> Other Activities</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-lg-12">
                                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addActivity">
                                                <i class="anticon anticon-file-add"></i> Add Activity
                                            </button>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="activitiesTable" class="table table-hover table-bordered text-center">
                                            <thead class="thead-purple">
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Activity</th>
                                                    <th>Coach</th>
                                                    <th>Sessions</th>
                                                    <th>Rate</th>
                                                    <th style="width:10%">Actions</th>
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
                                                        <td><?php echo $row["id"]; ?></td>
                                                        <td><?php echo $row["activity"]; ?></td>
                                                        <td><?php echo $row["coach"]; ?></td>
                                                        <td><?php echo $row["max"]; ?></td>
                                                        <td>P <?php echo $row["rate"]; ?></td>
                                                        <td class="action-buttons">
                                                            <button class="btn btn-success" data-toggle="modal" data-target="#editActivityModal<?php echo $row['id']; ?>">
                                                                <i class="anticon anticon-edit"></i> Edit
                                                            </button>
                                                            <a class="btn btn-primary" href="show-others.php?id=<?php echo $row["id"]; ?>&activity=<?php echo $row["activity"]; ?>">
                                                                <i class="anticon anticon-eye"></i> Show Students
                                                            </a>
                                                            <a class="btn btn-danger" href="delete-other.php?id=<?php echo $row["id"]; ?>">
                                                                <i class="anticon anticon-delete"></i> Remove
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once "includes/footer.php"; ?>
            </div>
        </div>
    </div>
    <!-- Modal For editing the activity -->
    <?php foreach ($result as $row) { ?>
        <div class="modal fade" id="editActivityModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editActivityModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="edit-activity.php" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editActivityModalLabel<?php echo $row['id']; ?>">
                                <span class="icon-holder"><i class="anticon anticon-edit"></i></span> Edit Activity
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Hidden input to pass the activity ID -->
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            
                            <div class="form-group">
                                <label for="editActivityName<?php echo $row['id']; ?>">Activity Name</label>
                                <input type="text" name="activity" class="form-control" id="editActivityName<?php echo $row['id']; ?>" value="<?php echo $row['activity']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editCoachName<?php echo $row['id']; ?>">Coach Name</label>
                                <input type="text" name="coach" class="form-control" id="editCoachName<?php echo $row['id']; ?>" value="<?php echo $row['coach']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editSessions<?php echo $row['id']; ?>">Sessions</label>
                                <input type="number" name="sessions" class="form-control" id="editSessions<?php echo $row['id']; ?>" value="<?php echo $row['max']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="editRate<?php echo $row['id']; ?>">Rate</label>
                                <input type="number" name="rate" class="form-control" id="editRate<?php echo $row['id']; ?>" value="<?php echo $row['rate']; ?>" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- Modal for Adding Activity -->
    <div class="modal fade" id="addActivity" tabindex="-1" role="dialog" aria-labelledby="addActivityTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="other-activities.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addActivityTitle">
                            <span class="icon-holder"><i class="anticon anticon-file-add"></i></span> Add New Activity
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="activityName">Activity Name</label>
                            <input type="text" name="activity" class="form-control" id="activityName" placeholder="Activity Name or Description" required>
                        </div>
                        <div class="form-group">
                            <label for="coachName">Coach Name</label>
                            <input type="text" name="coach" class="form-control" id="coachName" placeholder="Coach Name (Put TBA if no coach yet)" required>
                        </div>
                        <div class="form-group">
                            <label for="maxSession">Sessions</label>
                            <input type="number" name="sessions" class="form-control" id="maxSession" placeholder="Max Sessions" required>
                        </div>
                        <div class="form-group">
                            <label for="sessionRate">Rate</label>
                            <input type="number" name="rate" class="form-control" id="sessionRate" placeholder="Rate" required>
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

    <?php include_once "includes/scripts.php"; ?>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#activitiesTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true
            });
        });
    </script>
</body>

</html>