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
                                        $getWrittenWorkQuery = $DB_con->prepare("SELECT SUM(`score`) as totalScore, SUM(`maxscore`) as totalMaxscore FROM s_scores 
                                        WHERE  subjcode = :subjcode AND qtr = :qtr AND sid = :sid AND acttype = :acttype");
                                        $getWrittenWorkQuery->execute([":subjcode" => $studentSubject->code , ":qtr" => 1, ":sid" => $_SESSION['username'], ":acttype" => 1 ]);
                                        $writtenGrades = $getWrittenWorkQuery->fetch(PDO::FETCH_OBJ);
                                        $wwScore = $writtenGrades->totalScore;
                                        $wwMaxscore = $writtenGrades->totalMaxscore;

                                        // foreach ($writtenGrades as $writtenGrade) {
                                        //     $wwScore += $writtenGrade['totalScore'];
                                        //     $wwMaxscore += $writtenGrade['totalActivity'];
                                        // }

                                        $performanceTaskQuery = $DB_con->prepare("SELECT SUM(`score`) as ptTotalScore, SUM(`maxscore`) as ptTotalActivity FROM s_scores 
                                        WHERE  acttype = :acttype");
                                        $performanceTaskQuery->execute([":acttype" => 2 ]);
                                        $performanceTaskGrade = $performanceTaskQuery->fetchAll(PDO::FETCH_ASSOC);
                                        $ptScore = 0;
                                        $ptMaxscore = 0;

                                        foreach($performanceTaskGrade as $performanceTask){
                                            $ptScore += $performanceTask['ptTotalScore'];
                                            $ptMaxscore += $performanceTask['ptTotalActivity'];
                                        }

                                        $quarterlyQuery = $DB_con->prepare("SELECT SUM(`score`) as qtTotalScore, SUM(`maxscore`) as qtTotalActivity FROM s_scores 
                                        WHERE  acttype = :acttype");
                                        $quarterlyQuery->execute([":acttype" => 3 ]);
                                        $QuarterlyGrade = $quarterlyQuery->fetchAll(PDO::FETCH_ASSOC);
                                        $qtScore = 0;
                                        $qtMaxscore = 0;

                                            foreach($QuarterlyGrade as $quarterly){
                                                $qtScore += $quarterly['qtTotalScore'];
                                                $qtMaxscore += $quarterly['qtTotalActivity'];
                                            }

                                
                                            if ($wwMaxscore != 0 && $ptMaxscore != 0 && $qtMaxscore != 0) {
                                                $writtenWorkTotal = ($wwScore / $wwMaxscore) * 100;
                                                $wwGetTotalGrade = round($writtenWorkTotal, 2);
                                                $getFinalGrade = round(round($wwGetTotalGrade, 2) * $studentSubject->percentww, 2);

                                                $performanceTaskTotal = ($ptScore / $ptMaxscore) * 100;
                                                $ptGetTotalGrade = round($performanceTaskTotal, 2);
                                                $ptgetFinalGrade = round(round($ptGetTotalGrade, 2) * $studentSubject->percentpt, 2);

                                                $quarterlyTotal = ($qtScore / $qtMaxscore) * 100;
                                                $qaGetTotalGrade = round($quarterlyTotal, 2);
                                                $qagetFinalGrade = round(round($qaGetTotalGrade, 2) * $studentSubject->percentqt, 2);


                                                
                                                $totalGrade = round(round($wwGetTotalGrade, 2) * $studentSubject->percentww + round($ptGetTotalGrade, 2) * $studentSubject->percentpt + round($qaGetTotalGrade, 2) * $studentSubject->percentqt, 2);

                                                    $finalgrade = $DB_con->prepare("SELECT * FROM s_transmute WHERE :transmuted BETWEEN lowerl AND upperl");
                                                    $finalgrade->execute(array(":transmuted" => $totalGrade));
                                                    $finalg = $finalgrade->fetchAll(PDO::FETCH_ASSOC);

                                                    $totalGrade = round(round($wwGetTotalGrade, 2) * $studentSubject->percentww + round($ptGetTotalGrade, 2) * $studentSubject->percentpt + round($qaGetTotalGrade, 2) * $studentSubject->percentqt, 2);

                                                    $finalgrade = $DB_con->prepare("SELECT * FROM s_transmute WHERE :transmuted BETWEEN lowerl AND upperl");
                                                    $finalgrade->execute(array(":transmuted" => $totalGrade));
                                                    $finalg = $finalgrade->fetchAll(PDO::FETCH_ASSOC);

                                                    foreach($finalg as $final){

                                                    }

                                                ?>
                                                <td class="text-center" ><?= $final['transmuted'];?></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            <?php
                                            } else {
                                                // Handle the case where $wwMaxscore is zero
                                                echo "<td colspan='5' class='text-center'> No Grades</td>";
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