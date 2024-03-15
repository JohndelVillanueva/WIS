<?php
include_once "includes/css.php";
include_once "includes/config.php";
include_once "includes/dbconfig.php";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="card.css">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <title>1st Quarter Grade</title>
</head>


<body class="reportCard">
    <!--container-->
    <div class="container-fluid p-3 mb-2 bg-light text-dark reportCardbg">

        <div class="layout text-center mt-5">
        <div class="col-lg-2 d-flex justify-content-center">
            <button class="return-btn"> <i class="fa-solid fa-arrow-left-long"></i><a href="student.php"> Back to dashboard </a></button>
        </div>
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
            FROM s_studentcv WHERE sid = :sid AND qtr = :qtr");
            $infoStudent->execute(array(":sid" => $_SESSION["username"], ":qtr" => $_GET["qtr"]));
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
                    <div class="col-lg-3"></div>
                    <div class="col-lg-3 font-primary d-flex flex-column align-items-start">
                        <div>Name: <span class="fw-bold"><?= $_SESSION['fname'] . " " . $_SESSION['mname'] . " " . $_SESSION['lname'] ?></span> </div>
                        <div>Level: <span class="fw-bold"><?= $_SESSION['grade'] ?></span></div>
                        <div>Cambridge Level: <span class="fw-bold">N/a</span></div>
                    </div>
                    <div class="col-lg-3 font-primary">
                        <div>LRN: <span class="fw-bold"><?= $_SESSION['lrn'] ?></span></div>
                        <div>Gender: <span class="fw-bold"><?= $_SESSION['gender'] ?> </span></div>
                    </div>
                    <div class="col-lg-3"></div>
                </div>

                <?php
                $getTheGradeOfaStudent = $DB_con->prepare("SELECT * FROM s_subjects WHERE subjlevel = :grade");
                $getTheGradeOfaStudent->execute([":grade" => $_SESSION['grade']]);
                $getAllSubjects = $getTheGradeOfaStudent->fetchAll(PDO::FETCH_OBJ);
                ?>

                <div class="row mt-4">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <div class="text-black-50 h1 font-weight-light">Scholastic Performance</div>
                        <table class="table table-bordered border-2 mt-3 font-primary">
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
                                <?php foreach ($getAllSubjects as $studentSubject) : ?>
                                    <tr>
                                        <td class="font-size-18 text-black-50 font-weight-normal"><?= $studentSubject->subjdesc ?></td>
                                        <?php
                                        // $studentScore = new DB();
                                        // $getScore = $studentScore->getScores($studentSubject->code, 1, $_SESSION['username']);
                                        $getWrittenWorkQuery = $DB_con->prepare("SELECT SUM(`score`) as totalScore, SUM(`maxscore`) as totalActivity, `percentww` FROM s_scores 
                                        LEFT JOIN s_subjects ss ON s_scores.subjcode = ss.code
                                        WHERE  subjcode = :subjcode AND qtr = :qtr AND sid = :sid AND acttype = :acttype");
                                        $getWrittenWorkQuery->execute([":subjcode" => $studentSubject->code , ":qtr" => $_GET['qtr'], ":sid" => $_SESSION['username'], ":acttype" => 1 ]);
                                        $writtenGrades = $getWrittenWorkQuery->fetchAll();
                                        $wwScore = 0;
                                        $wwMaxscore = 0;

                                        $getPerformanceTaskQuery = $DB_con->prepare("SELECT SUM(`score`) as totalScore, SUM(`maxscore`) as totalActivity, `percentww` FROM s_scores 
                                        LEFT JOIN s_subjects ss ON s_scores.subjcode = ss.code
                                        WHERE  subjcode = :subjcode AND qtr = :qtr AND sid = :sid AND acttype = :acttype");
                                        $getPerformanceTaskQuery->execute([":subjcode" => $studentSubject->code , ":qtr" => $_GET['qtr'], ":sid" => $_SESSION['username'], ":acttype" => 2 ]);
                                        $performanceTask = $getPerformanceTaskQuery->fetchAll();
                                        $wwScore = 0;
                                        $wwMaxscore = 0;


                                        if (!empty($writtenGrades)) {
                                            foreach ($writtenGrades as $writtenGrade) {
                                                $wwScore += $writtenGrade['totalScore'];
                                                $wwMaxscore += $writtenGrade['totalActivity'];
                                            }
                                
                                            if ($wwMaxscore != 0) {
                                                $totalGrade = ($wwScore / $wwMaxscore) * 100;
                                                $getTotalGrade = round($totalGrade, 2);
                                                $getFinalGrade = round(round($getTotalGrade, 2) * $writtenGrade['percentww'], 2)
                                                ?>
                                                <td class="text-center" ><?= $getFinalGrade ?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <?php
                                            } else {
                                                // Handle the case where $wwMaxscore is zero
                                                echo "<td colspan='5' class='text-center'> No Grades</td>";
                                            }
                                        } else {
                                            echo "<td colspan='5' class='text-center'> No Record Yet</td>";
                                        }
                                        ?>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Get General Average</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-2"></div>
                </div><br>
                <div class="row mt-4">
                    <div class="col-lg-2"></div>

                    <div class="col-lg-8">
                        <div class="text-black-50 h1 font-weight-light">Core Values</div>
                        <table class="table table-bordered mt-3 font-primary">
                            <thead>
                                <tr>
                                    <th class="font-weight-normal text-center">Independence</th>
                                    <th class="font-weight-normal text-center">Confidence</th>
                                    <th class="font-weight-normal text-center">Respect</th>
                                    <th class="font-weight-normal text-center">Empathy</th>
                                    <th class="font-weight-normal text-center">Appreciation</th>
                                    <th class="font-weight-normal text-center">Tolerance</th>
                                    <th class="font-weight-normal text-center">Enthusiasm</th>
                                    <th class="font-weight-normal text-center">Conduct</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><?= implode(", ", $student_data['independence']) ?></td>
                                    <td class="text-center"><?= implode(", ", $student_data['confidence']) ?></td>
                                    <td class="text-center"><?= implode(", ", $student_data['respect']) ?></td>
                                    <td class="text-center"><?= implode(", ", $student_data['empathy']) ?></td>
                                    <td class="text-center"><?= implode(", ", $student_data['appreciation']) ?></td>
                                    <td class="text-center"><?= implode(", ", $student_data['tolerance']) ?></td>
                                    <td class="text-center"><?= implode(", ", $student_data['enthusiasm']) ?></td>
                                    <td class="text-center"><?= implode(", ", $student_data['conduct']) ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="col-form-label text-black-50 mt-5 font-size-22">None-Numeric Descriptor</div>
                        <div class=" text-black-50">E = Exemplary</div>
                        <div class="text-black-50">HS = Highly Satisfactory</div>
                        <div class="text-black-50">S = Satisfactory</div>
                        <div class="text-black-50">Ng = Needs Guidance</div><br>

                    </div>
                    <div class="col-lg-2"></div>
                </div>
        </div>
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8 bg-light">
                <table class="table table-bordered mt-3 font-primary">
                    <thead class="thead-white text-center ">
                        <th class="h4 fw-light" colspan="4">Attendance</th>
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
        <div class="col-lg-2"></div>
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8 fw-light">
                <div class="mt-4 font-size-17 ">Promote to grade: __________ Retain in grade: _______</div>
                <div class="mt-2 font-size-17  pr-5">Eligible for Admission to Grade:________ </div>
                <div class="mt-2 font-size-17  pr-5">Date:________</div><br>
            </div>
        </div>
        <div class="col-lg-2"></div>
        <div class="row">
            <div class="col-lg-6 text-center">
                <div class="adviser">
                    <div class="mt-3 text-black-50"> Name of the adviser </div>
                    <div class="font-size-23"> Adviser</div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="adviser">
                    <div class="mt-3 text-black-50"> Name of the headMaster </div>
                    <div class="font-size-23"> Primary School Headmaster</div><br>
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