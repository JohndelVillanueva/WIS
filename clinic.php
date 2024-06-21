<?php
include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>

<head>
    <style>
        .modal-dialog-custom {
            max-width: 80%; /* Adjust the percentage as needed */
            width: 80%;
        }

    </style>
</head>

<body>
    <div class="app">
        <div class="layout">
            <?php include_once "includes/heading.php"; ?>
            <?php include_once "includes/sidemenu.php"; ?>
            <div class="page-container">
                <div class="main-content">
                    <!-- form starts !-->
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
                                                    <div class="modal-header float-center">
                                                        <div class="modal-title text-black ">
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
                                                                        <h3>Diagnose</h3>
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
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" class="form-control border-dark form-control-custom" name="name" required>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control border-dark form-control-custom" name="grade" required>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control border-dark form-control-custom" name="complaint" required>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control border-dark form-control-custom" name="diagnose" required>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control border-dark form-control-custom" name="treatment" required>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control border-dark form-control-custom" name="vital_signs" required>
                                                                </td>
                                                                <td>
                                                                    <input type="time" class="form-control border-dark form-control-custom" name="time_in" required>
                                                                </td>
                                                                <td>
                                                                    <input type="time" class="form-control border-dark form-control-custom" name="time_out" required>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" class="form-control border-dark form-control-custom" name="remark" required>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
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
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-primary float-right"> Add New</button>
                                    </div>
                                </div>
                                <?php
                                $selectAllStudents = $DB_con->prepare("SELECT * FROM clinic_history");
                                $selectAllStudents->execute();
                                $students = $selectAllStudents->fetchAll(PDO::FETCH_OBJ);
                                ?>
  
                                <div class="row ">
                                    <div class="col-lg-12">
                                        <table id="userlist" class="display table table-stripped table-fluid">
                                            <thead text-center>
                                                <tr>
                                                    <th scope="col" class="text-center">Full Name</th>
                                                    <th scope="col" class="text-center">Grade And Section</th>
                                                    <th scope="col" class="text-center">Complaint</th>
                                                    <th scope="col" class="text-center">Diagnose</th>
                                                    <th scope="col" class="text-center">Treatment</th>
                                                    <th scope="col" class="text-center">Vital Signs</th>
                                                    <th scope="col" class="text-center">Time-in</th>
                                                    <th scope="col" class="text-center">Time-out</th>
                                                    <th scope="col" class="text-center">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center fs-1">
                                                <?php 
                                                foreach ($students as $student): { 
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
                                                            <td><?= $student->remarks ?></td>
                                                    </tr>
                                                    <?php 
                                                } 
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
                <!-- form ends !-->
            </div>
            <?php include_once "includes/footer.php"; ?>
        </div>
        <?php include_once "script.php"; ?>

    </div>
    </div>
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
                "pageLength": 15
            });
        });
    </script>
</body>

</html>
