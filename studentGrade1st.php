<?php
    include_once "includes/css.php";
    include_once "includes/config.php";
    session_start();

if(!isset($_SESSION['id']))
{
    header("location: login.php");

}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>1st Quarter Grade</title>
</head>
<body class="reportCard">
    <!--container-->
    <div class="container p-3 mb-2 bg-light text-dark reportCardbg">
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

                $infoStudent = $DB_con->prepare("SELECT * FROM user u
                LEFT JOIN s_subjects sub ON u.level = sub.subjlevel  WHERE u.id = :id ");
                $infoStudent->execute(array(":id" => $_SESSION["id"]));
                $displayStudentInfo = $infoStudent->fetchAll(PDO::FETCH_ASSOC);

                foreach($displayStudentInfo as $student){ 


                    ?>
                    <div class="row mt-5">
                        <div class="col-lg-6 font-primary" >
                            <div >Name: <?php echo  $student["fname"] ." ". $student["mname"] ." ". $student["lname"] ?> </div>
                            <div>Level: <?php echo $student["grade"] ?></div>
                            <div>Cambridge Level: 7</div>
                        </div>
                        <div class="col-lg-6 font-primary">
                            <div>LRN: <?php echo $student["lrn"]?></div>
                            <div>Gender:<?php echo $student["gender"]?> </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-8">
                            <div class="text-black-50 font-size-29 font-primary">Scholastic Performance</div>
                                <table class="table table-bordered mt-3 font-primary">
                                    <thead>
                                    <tr>
                                        <th class="font-size-18 text-black-50 font-weight-normal"></th>
                                        <th >1st</th>
                                        <th >2nd</th>
                                        <th >3rd</th>
                                        <th >4th</th>
                                        <th >Final</th>
                                        <th >Remarks</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th class="font-size-18 text-black-50 font-weight-normal">English</th>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                        <td>1</td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-center" >Get General Average</td>
                                        <td>Get Ge</td>
                                    </tr>
                                    </tbody>
                                </table>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-black-50 font-size-29 font-primary">Core Values</div>
                                <table class="table table-bordered mt-3 font-primary">
                                    <thead>
                                        <tr>
                                            <th ></th>
                                            <th >1st</th>
                                            <th >2nd</th>
                                            <th >3rd</th>
                                            <th >4th</th>
                                            <th >Final</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            <tr>
                                                <th>1</th>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                            </tr>
                                            <tr>
                                                <th>2</th>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                            </tr>
                                            <tr>
                                                <th>3</th>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                            </tr>
                                            <tr>
                                                <th >4</th>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                                <td>1</td>
                                            </tr>

                                        </tbody>
                                </table>

                            <div class="col-form-label text-black-50 mt-5 font-size-22">None-Numeric Descriptor</div>
                            <div class=" text-black-50">E = Exemplary</div>
                            <div class="text-black-50">HS = Highly Satisfactory</div>
                            <div class="text-black-50">S = Satisfactory</div>
                            <div class="text-black-50">Ng = Needs Guidance</div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 bg-light">
                            <table class="table table-bordered mt-3 font-primary">
                                <thead  class="thead-white text-center">
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
                                    <th >3</th>
                                    <td >Larry the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mt-4 font-size-17 text-left">Promote to grade: __________  Retain in grade: _______</div>
                            <div class="mt-4 font-size-17 mr-5 text-left">Eligible for Admission to Grade:________ </div>
                            <div class="mt-4 font-size-17 mr-5 text-left">Date:________</div><br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 ">
                            <div class="adviser">
                                <div class="mt-3 text-black-50" > Name of the adviser </div>
                                <div class="font-size-23"> Adviser</div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="adviser">
                                <div class="mt-3 text-black-50" > Name of the headMaster </div>
                                <div class="font-size-23"> Primary School Headmaster</div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>


        </div>
    </div>
</body>
</html>