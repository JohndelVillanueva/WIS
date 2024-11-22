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
        .modal-content {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1.5rem;
        }

        .form-group label {
            margin-bottom: 0.5rem;
            color: #444;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: rgba(102, 51, 153, 0.5);
        }

        .required::after {
            content: " *";
            color: red;
        }

        .btn-primary {
            background-color: rgba(102, 51, 153, 0.9);
            border-color: rgba(102, 51, 153, 0.9);
        }

        .btn-primary:hover {
            background-color: rgba(102, 51, 153, 1);
            border-color: rgba(102, 51, 153, 1);
        }

        .form-control.is-valid,
        .was-validated .form-control:valid {
            border-color: #28a745;
            background-image: none;
        }

        .form-control.is-invalid,
        .was-validated .form-control:invalid {
            border-color: #dc3545;
            background-image: none;
        }

        /* Animation for modal */
        .modal.fade .modal-dialog {
            transform: scale(0.8);
            transition: transform 0.3s ease-in-out;
        }

        .modal.show .modal-dialog {
            transform: scale(1);
        }

        body {
            background-image: url('assets/images/others/bg.jpg');
            /* You'll need to add your background image to this path */
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

        /* Spinner styles */
        .spinner {
            border: 5px solid #f3f3f3;
            /* Light grey */
            border-top: 5px solid #007bff;
            /* Blue */
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        /* Keyframe for spinning */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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

                                                if (count($result) > 0) {
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
                                                                <a class="btn btn-primary" href="show-others.php?id=<?php echo $row['id']; ?>&activity=<?php echo $row['activity']; ?>">
                                                                <!-- &coach=<?php echo $row['coach']; ?> -->
                                                                    <i class="anticon anticon-eye"></i> Show Students
                                                                </a>
                                                                <a class="btn btn-danger" href="delete-other.php?id=<?php echo $row['id']; ?>"
                                                                    onclick="return confirm('Are you sure you want to delete this item?');">
                                                                    <i class="anticon anticon-delete"></i> Remove
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <tr>
                                                        <td colspan="6" class="text-muted font-italic" style="font-size: 18px; padding: 20px;">
                                                            No records yet. Add a new activity to get started.
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
                <?php include_once "includes/footer.php"; ?>
            </div>
        </div>
    </div>
    <?php foreach ($result as $row) { ?>
        <div class="modal fade" id="editActivityModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editActivityModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="editActivityForm<?php echo $row['id']; ?>" action="edit-activity.php" method="post" novalidate>
                        <div class="modal-header bg-purple text-white" style="background-color: rgba(102, 51, 153, 0.9);">
                            <h5 class="modal-title d-flex align-items-center" id="editActivityModalLabel<?php echo $row['id']; ?>">
                                <span class="icon-holder mr-2">
                                    <i class="anticon anticon-edit"></i>
                                </span>
                                Edit Activity
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                            <!-- Activity Name Field -->
                            <div class="form-group mb-4">
                                <label for="editActivityName<?php echo $row['id']; ?>" class="font-weight-semibold required">
                                    Activity Name
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="anticon anticon-flag"></i>
                                        </span>
                                    </div>
                                    <input
                                        type="text"
                                        name="activity"
                                        class="form-control"
                                        id="editActivityName<?php echo $row['id']; ?>"
                                        value="<?php echo htmlspecialchars($row['activity']); ?>"
                                        required
                                        minlength="3"
                                        pattern="[A-Za-z0-9\s-]+"
                                        placeholder="Enter activity name">
                                    <div class="invalid-feedback">
                                        Please enter a valid activity name (minimum 3 characters)
                                    </div>
                                </div>
                            </div>

                            <!-- Coach Name Field -->
                            <div class="form-group mb-4">
                                <label for="editCoachName<?php echo $row['id']; ?>" class="font-weight-semibold required">
                                    Coach Name
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="anticon anticon-user"></i>
                                        </span>
                                    </div>
                                    <input
                                        type="text"
                                        name="coach"
                                        class="form-control"
                                        id="editCoachName<?php echo $row['id']; ?>"
                                        value="<?php echo htmlspecialchars($row['coach']); ?>"
                                        required
                                        pattern="[A-Za-z\s.]+"
                                        minlength="2"
                                        placeholder="Enter coach name">
                                    <div class="invalid-feedback">
                                        Please enter a valid coach name
                                    </div>
                                </div>
                            </div>

                            <!-- Sessions Field -->
                            <div class="form-group mb-4">
                                <label for="editSessions<?php echo $row['id']; ?>" class="font-weight-semibold required">
                                    Number of Sessions
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="anticon anticon-calendar"></i>
                                        </span>
                                    </div>
                                    <input
                                        type="number"
                                        name="sessions"
                                        class="form-control"
                                        id="editSessions<?php echo $row['id']; ?>"
                                        value="<?php echo $row['max']; ?>"
                                        required
                                        min="1"
                                        max="100"
                                        placeholder="Enter number of sessions">
                                    <div class="invalid-feedback">
                                        Please enter a valid number of sessions (1-100)
                                    </div>
                                </div>
                            </div>

                            <!-- Rate Field -->
                            <div class="form-group mb-4">
                                <label for="editRate<?php echo $row['id']; ?>" class="font-weight-semibold required">
                                    Rate
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="anticon anticon-dollar"></i>
                                        </span>
                                    </div>
                                    <input
                                        type="number"
                                        name="rate"
                                        class="form-control"
                                        id="editRate<?php echo $row['id']; ?>"
                                        value="<?php echo $row['rate']; ?>"
                                        required
                                        min="0"
                                        step="0.01"
                                        placeholder="Enter rate amount">
                                    <div class="invalid-feedback">
                                        Please enter a valid rate
                                    </div>
                                </div>
                            </div>

                            <!-- Alert for validation messages -->
                            <div class="alert alert-danger d-none" id="formErrors<?php echo $row['id']; ?>" role="alert">
                                Please correct the errors before submitting.
                            </div>
                        </div>

                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="anticon anticon-close mr-2"></i>
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="anticon anticon-save mr-2"></i>
                                Save Changes
                            </button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('editActivityForm<?php echo $row['id']; ?>');
            const errorAlert = document.getElementById('formErrors<?php echo $row['id']; ?>');

            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    errorAlert.classList.remove('d-none');
                } else {
                    errorAlert.classList.add('d-none');
                }
                form.classList.add('was-validated');
            });

            // Real-time validation
            const inputs = form.querySelectorAll('input[required]');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.checkValidity()) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    }
                });
            });

            // Clear validation states when modal is hidden
            $(`#editActivityModal<?php echo $row['id']; ?>`).on('hidden.bs.modal', function() {
                form.classList.remove('was-validated');
                errorAlert.classList.add('d-none');
                inputs.forEach(input => {
                    input.classList.remove('is-invalid', 'is-valid');
                });
            });
        });
        document.getElementById('showStudentsBtn').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent default anchor behavior

            // Display the loading animation
            const animation = document.getElementById('loadingAnimation');
            animation.style.display = 'block';

            // URL for redirection
            const targetUrl = "";

            // Delay and then redirect
            setTimeout(() => {
                window.location.href = targetUrl;
            }, 2000); // Adjust the delay as needed
        });
    </script>
</body>

</html>