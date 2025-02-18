<?php
include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once "includes/css.php"; ?>
    <style>
        .modal-content-custom {
            background-color: #f8f9fa;
            border-radius: 20px;
        }

        .modal-dialog-custom {
            max-width: 80%;
        }

        .form-control-custom:focus {
            box-shadow: 0px 0px 10px rgba(0, 123, 255, 0.5);
            border-color: #007bff;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.0/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.1/css/buttons.dataTables.min.css">
</head>

<body>
    <div class="app">
        <div class="layout">
            <?php include_once "includes/heading.php"; ?>
            <?php include_once "includes/sidemenu.php"; ?>
            <div class="page-container">
                <div class="main-content">
                    <!-- form starts -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-warning rounded-top pt-2">
                                    <h4>
                                        <span class="icon-holder">
                                            <i class="anticon anticon-idcard"></i>
                                        </span>
                                        Student Medical Records
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="modal fade" tabindex="-1" id="add" data-bs-backdrop="static" data-bs-keyboard="false">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-custom">
                                            <div class="modal-content modal-content-custom">
                                                <form method="POST" action="addClinicProcess.php">
                                                    <div class="modal-header">
                                                        <div class="modal-title text-black">
                                                            <b>Add New Student Health Record</b>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table text-center">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <h3>Fullname</h3>
                                                                    </th>
                                                                    <th>
                                                                        <h3>Grade And Section</h3>
                                                                    </th>
                                                                    <th>
                                                                        <h3>Complaint</h3>
                                                                    </th>
                                                                    <th>
                                                                        <h3>Diagnosis</h3>
                                                                    </th>
                                                                    <th>
                                                                        <h3>Treatment</h3>
                                                                    </th>
                                                                    <th>
                                                                        <h3>Vital Signs</h3>
                                                                    </th>
                                                                    <th>
                                                                        <h3>Time-in</h3>
                                                                    </th>
                                                                    <th>
                                                                        <h3>Time-out</h3>
                                                                    </th>
                                                                    <th>
                                                                        <h3>Date</h3>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><input type="text" class="form-control border-dark form-control-custom" name="name" placeholder="Juan Tamad" required></td>
                                                                    <td><input type="text" class="form-control border-dark form-control-custom" name="grade" placeholder="13 - Mabuti" required></td>
                                                                    <td><input type="text" class="form-control border-dark form-control-custom" name="complaint" placeholder="Headache" required></td>
                                                                    <td><input type="text" class="form-control border-dark form-control-custom" name="diagnose" placeholder="N/a" required></td>
                                                                    <td><input type="text" class="form-control border-dark form-control-custom" name="treatment" placeholder="Example" required></td>
                                                                    <td><input type="text" class="form-control border-dark form-control-custom" name="vital_signs" placeholder="Example" required></td>
                                                                    <td><input type="time" class="form-control border-dark form-control-custom" name="time_in" placeholder="Example" required></td>
                                                                    <td><input type="time" class="form-control border-dark form-control-custom" name="time_out" placeholder="Example" required></td>
                                                                    <td><input type="date" class="form-control border-dark form-control-custom" name="date"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- Remarks input moved outside the table -->
                                                        <div class="form-group mt-3">
                                                            <label for="remark" class="text-center d-block">
                                                                <h3>Remarks</h3>
                                                            </label>
                                                            <input type="text" class="form-control border-dark form-control-custom" name="remark" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Save changes</button>
                                                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" id="reset">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary float-right">Add New</button><br><br><br>
                                    </div>
                                </div>
                                <?php
                                $selectAllStudents = $DB_con->prepare("SELECT * FROM clinic_history ORDER BY date DESC");
                                $selectAllStudents->execute();
                                $students = $selectAllStudents->fetchAll(PDO::FETCH_OBJ);
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table id="userlist" class="display table table-stripped table-fluid">
                                            <thead class="text-center">
                                                <tr>
                                                    <th scope="col" class="text-center">Full Name</th>
                                                    <th scope="col" class="text-center">Grade And Section</th>
                                                    <th scope="col" class="text-center">Complaint</th>
                                                    <th scope="col" class="text-center">Diagnose</th>
                                                    <th scope="col" class="text-center">Treatment</th>
                                                    <th scope="col" class="text-center">Vital Signs</th>
                                                    <th scope="col" class="text-center">Time-in</th>
                                                    <th scope="col" class="text-center">Time-out</th>
                                                    <th scope="col" class="text-center">Date</th>
                                                    <th scope="col" class="text-center">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center fs-1">
                                                <?php
                                                foreach ($students as $student):
                                                ?>
                                                    <tr style="padding-top:10px!important; padding-bottom:10px!important;">
                                                        <td><?= $student->name ?></td>
                                                        <td><?= $student->grade ?></td>
                                                        <td><?= $student->complaint ?></td>
                                                        <td><?= $student->diagnose ?></td>
                                                        <td><?= $student->treatment ?></td>
                                                        <td><?= $student->vital_signs ?></td>
                                                        <td><?= $student->time_in ?></td>
                                                        <td><?= $student->time_out ?></td>
                                                        <td><?= $student->date ?></td>
                                                        <td><?= $student->remarks ?></td>
                                                    </tr>
                                                <?php
                                                endforeach;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light text-center"></div>
                        </div>
                    </div>
                </div>
                <!-- form ends -->
            </div>
            <?php include_once "includes/footer.php"; ?>
        </div>
        <?php include_once "script.php"; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userlist').DataTable({
                dom: 'frtipB',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                    'print'
                ],
                pageLength: 15
            });
        });
    </script>
</body>

</html>