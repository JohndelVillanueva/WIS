<?php
include_once "includes/css.php";
include_once "includes/config.php";
session_start();

if (!isset($_SESSION['id'])) {
    header("location: login.php");
    exit();
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>1st Quarter Grade</title>
    <style>
        .vertical-text {
            transform: rotate(270deg);
        }
    </style>
</head>


<body class="reportCard">
    <!--container-->
    <div class="container-fluid p-3 mb-2 bg-light text-dark reportCardbg">
        <div class="layout text-center mt-5">
            <div class="row">
                <div class="col-lg-12">
                    <div> <img style=" max-width: 150px; margin-top: 2px  " src="assets/images/logo/west.png"></div>
                    <div>Primary School</div>
                    <div>Progress Report Card</div>
                    <div>School Year 2022-2023</div>
                </div>
            </div>
            <?php

            $infoStudent = $DB_con->prepare("SELECT 
            independence,
            confidence,
            respect,
            empathy,
            appreciation,
            tolerance,
            enthusiasm,
            conduct
            FROM s_studentcv WHERE sid = :sid AND qtr = 1");
            $infoStudent->execute(array(":sid" => $_SESSION["username"]));
            $displayStudentInfo = $infoStudent->fetchAll(PDO::FETCH_OBJ);

            $student_data = [];
            // var_dump($displayStudentInfo);
            foreach ($displayStudentInfo as $studentgrade) {

                $coreTableQuery = $DB_con->prepare("SELECT `start`,`end`,`grade` FROM s_coretable");
                $coreTableQuery->execute();
                $coreTables = $coreTableQuery->fetchAll(PDO::FETCH_OBJ);

                foreach ($coreTables as $coreTable) {

                    if ($studentgrade->independence >= $coreTable->start && $studentgrade->independence <= $coreTable->end) {
                        $student_data['independence'][] = $coreTable->grade;
                    }
                    if ($studentgrade->confidence >= $coreTable->start && $studentgrade->confidence <= $coreTable->end) {
                        $student_data['confidence'][] = $coreTable->grade;
                    }
                    if ($studentgrade->respect >= $coreTable->start && $studentgrade->respect <= $coreTable->end) {
                        $student_data['respect'][] = $coreTable->grade;
                    }
                    if ($studentgrade->empathy >= $coreTable->start && $studentgrade->empathy <= $coreTable->end) {
                        $student_data['empathy'][] = $coreTable->grade;
                    }
                    if ($studentgrade->appreciation >= $coreTable->start && $studentgrade->appreciation <= $coreTable->end) {
                        $student_data['appreciation'][] = $coreTable->grade;
                    }

                    if ($studentgrade->tolerance >= $coreTable->start && $studentgrade->tolerance <= $coreTable->end) {
                        $student_data['tolerance'][] = $coreTable->grade;
                    }
                    if ($studentgrade->enthusiasm >= $coreTable->start && $studentgrade->enthusiasm <= $coreTable->end) {
                        $student_data['enthusiasm'][] = $coreTable->grade;
                    }
                    if ($studentgrade->conduct >= $coreTable->start && $studentgrade->conduct <= $coreTable->end) {
                        $student_data['conduct'][] = $coreTable->grade;
                    }
                }
            ?>
                <div class="row mt-5">
                    <div class="col-lg-6 font-primary">
                        <div>Name: <?= $_SESSION['fname'] . " " . $_SESSION['mname'] . " " . $_SESSION['lname'] ?> </div>
                        <div>Level: <?= $_SESSION['grade'] ?></div>
                        <div>Cambridge Level: 7</div>
                    </div>
                    <div class="col-lg-6 font-primary">
                        <div>LRN: <?= $_SESSION['lrn'] ?></div>
                        <div>Gender:<?= $_SESSION['gender'] ?> </div>
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col-lg-6">
                        <div class="text-black-50 font-size-29 font-primary">Scholastic Performance</div>
                        <table class="table table-bordered mt-3 font-primary">
                            <thead>
                                <tr>
                                    <th class="font-size-18 text-black-50 font-weight-normal">Subject</th>
                                    <th>1st</th>
                                    <th>2nd</th>
                                    <th>3rd</th>
                                    <th>4th</th>
                                    <th>Final</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-size-18 text-black-50 font-weight-normal"></td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td colspan="6" class="text-center">Get General Average</td>
                                    <td>Get Ge</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-black-50 font-size-29 font-primary ">Core Values</div>
                        <table class="table table-bordered mt-3 font-primary" style="width:300px; max-width:300px">
                            <thead>
                                <tr>
                                    <th class="vertical-text font-weight-normal text-center" style="width: 130px;" height=130>Independence</th>
                                    <th class="vertical-text">Confidence</th>
                                    <th class="vertical-text">Respect</th>
                                    <th class="vertical-text">Empathy</th>
                                    <th class="vertical-text">Appreciation</th>
                                    <th class="vertical-text">Tolerance</th>
                                    <th class="vertical-text">Enthusiasm</th>
                                    <th class="vertical-text">Conduct</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= implode(", ", $student_data['independence']) ?></td>
                                    <td><?= implode(", ", $student_data['confidence']) ?></td>
                                    <td><?= implode(", ", $student_data['respect']) ?></td>
                                    <td><?= implode(", ", $student_data['empathy']) ?></td>
                                    <td><?= implode(", ", $student_data['appreciation']) ?></td>
                                    <td><?= implode(", ", $student_data['tolerance']) ?></td>
                                    <td><?= implode(", ", $student_data['enthusiasm']) ?></td>
                                    <td><?= implode(", ", $student_data['conduct']) ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="col-form-label text-black-50 mt-5 font-size-22">None-Numeric Descriptor</div>
                        <div class=" text-black-50">E = Exemplary</div>
                        <div class="text-black-50">HS = Highly Satisfactory</div>
                        <div class="text-black-50">S = Satisfactory</div>
                        <div class="text-black-50">Ng = Needs Guidance</div><br>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 bg-light">
                        <table class="table table-bordered mt-3 font-primary">
                            <thead class="thead-white text-center">
                                <th colspan="4">Attendance</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>Mark</td>
                                    <td>Mark</td>
                                    <td>Mark</td>


                                </tr>
                                <tr>
                                    <th>1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th>2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th>3</th>
                                    <td>Larry the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mt-4 font-size-17 text-left">Promote to grade: __________ Retain in grade: _______</div>
                        <div class="mt-4 font-size-17 mr-5 text-left">Eligible for Admission to Grade:________ </div>
                        <div class="mt-4 font-size-17 mr-5 text-left">Date:________</div><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 ">
                        <div class="adviser">
                            <div class="mt-3 text-black-50"> Name of the adviser </div>
                            <div class="font-size-23"> Adviser</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="adviser">
                            <div class="mt-3 text-black-50"> Name of the headMaster </div>
                            <div class="font-size-23"> Primary School Headmaster</div>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <?php include_once "includes/footer.php"; ?>
            <?php include_once "includes/scripts.php"; ?>

        </div>
    </div>
</body>



</html>