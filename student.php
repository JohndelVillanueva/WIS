<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}
?>
<!DOCTYPE html>
<html lang="en">

    <?php include_once "includes/css.php"; ?>

    <body>
        <div class="app">
            <div class="layout">
                <?php include_once "includes/heading.php"; ?>
                <?php include_once "includes/sidemenu.php"; ?>
                <div class="page-container">
                    <div class="main-content d-flex">
                        <!-- form starts !-->
                        <div class="div w-40">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-warning rounded-top pt-2">
                                            <div class="row">
                                                <div class="col-lg-12"><h4><span class="icon-holder"><i class="anticon anticon-idcard"></i></span> Student Profile</h4></div>
                                            </div>
                                        </div>
                                        <div class="card-body  ">
                                            <div class="row">
                                                <div class="col-lg-4"><img class="rounded" style="max-width: 128px!important;" src="assets/images/avatars/
                                                    <?php
                                                        if(empty($_SESSION["photo"]))	{
                                                            echo "avatar.jpg";
                                                        } else {
                                                            echo $_SESSION["photo"] . ".jpg";
                                                        }
                                                    ?>">
                                                </div>
                                                <div class="col-lg-8">
                                                    <h1><?php echo $_SESSION["lname"].", ".$_SESSION["fname"]." ".$_SESSION["mname"] ?></h1>
                                                    <hr>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card border-1 border-light">
                                        <div class="card-footer d-flex align-items-center rounded bg-warning border-light">
                                            <h4><span class="icon-holder"><i class="anticon anticon-read"></i></span> Grades</h4>
                                        </div><br>
                                    </div>
                                </div>
                            </div>
                            <!--Name of School-->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-center font-primary">
                                        <div>Westfield Internation School</div><br>
                                        <div>Primary School</div>
                                        <div>Progress Report Card</div>
                                        <div>School Year 2022-2023</div>
                                    </div>
                                </div>
                            </div><br>
                            <!--query here-->
                            <!--use foreach to view specific student-->
                            <!--Student Info-->
                            <?php 
                                $infoStudent = $DB_con->prepare("SELECT * FROM user u
                                LEFT JOIN s_subjects sub ON u.level = sub.subjlevel  WHERE u.id = :id ");
                                $infoStudent->execute(array(":id" => $_SESSION["id"]));
                                $displayStudentInfo = $infoStudent->fetchAll(PDO::FETCH_OBJ);

                                foreach($displayStudentInfo as $student){ 


                                    
                            ?>
                            <div class="row">
                                <div class="col-lg-6 font-primary" >
                                    <div>Name: <?=  $student->fname ." ". $student->mname ." ". $student->lname ?></div>
                                    <div>Level: <?= $student->grade ?> </div>
                                    <div>Cambridge Level: 7</div>
                                </div>
                                <div class="col-lg-6 font-primary">
                                    <div>LRN: <?= $student->lrn?> </div>
                                    <div>Gender:<?= $student->gender?></div>
                                </div>
                                <?php 
                                }
                                ?>
                            </div><br>
                            <!--Student Card-->
                            <div class="text-center  lead">Click what QUARTER you want to visit below:</div>
                            <div class="row p-l-80 mt-4 ">
                                <div><a href="studentGrade1st.php" class="btn btn-outline-dark link-secondary font-primary font-size-12">1st Quarter</a></div>
                                <div class="pl-4"><a href="studentGrade2nd.php" class="btn btn-outline-dark link-secondary font-primary font-size-12">2nd Quarter</a></div>
                                <div class="pl-4"><a href="studentGrade3rd.php" class="btn btn-outline-dark link-secondary font-primary font-size-12">3rd Quarter</a></div>
                                <div class="pl-4"><a href="studentGrade4th.php" class="btn btn-outline-dark link-secondary font-primary font-size-12">4th Quarter</a></div>
                            </div>

                        </div>
                        <div class="div w-60">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-warning rounded-top pt-2">
                                        <div class="row">
                                            <div class="col-lg-12"><h4><span class="icon-holder"><i class="anticon anticon-bulb"></i></span> Enrollment Status</h4></div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3>Your Enrollment Progress</h3>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="progress" style="height: 50px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated font-size-20" role="progressbar" aria-valuenow="<?php echo $_SESSION['status']*10;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $_SESSION['status']*10;?>%">
                                                    <?php
                                                        switch($_SESSION['status']){
                                                            case 1:
                                                                echo "Pending Verification";
                                                                $status = "Waiting for Document Verification";
                                                                break;
                                                            case 2:
                                                                echo "Pending Application Fee";
                                                                $status = "Waiting for Application Fee Payment";
                                                                break;
                                                            case 3:
                                                                echo "Pending Admissions";
                                                                $status = "Waiting for Admissions Examination Schedule";
                                                                break;
                                                            case 4:
                                                                echo "Pending Examination";
                                                                $status = "Waiting for Entrance Examination Results";
                                                                break;
                                                            case 5:
                                                                echo "Pending Interview";
                                                                $status = "Waiting for Entrance Interview Results";
                                                                break;
                                                            case 6:
                                                                echo "Pending Required Documents";
                                                                $status = "Waiting for Required Documents Submission and Verification";
                                                                break;
                                                            case 7:
                                                                echo "Pending Enrollment Fees";
                                                                $status = "Waiting for Payment of Enrollment Fees";
                                                                break;
                                                            default:
                                                                break;
                                                        }
                                                    ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="alert alert-success" role="alert">
                                                    <h4 class="alert-heading">Status Details:</h4>
                                                    <p class="mb-0">
                                                        <?php
                                                            echo $_SESSION ['status'];
                                                        ?></p>

                                                    <?php
                                                        $sname = $DB_con->prepare("SELECT * FROM schedule WHERE title = :title");
                                                        $sname->execute(array( ':title'=>$_SESSION['fname']." ".$_SESSION['lname']));
                                                        $snameres = $sname->fetchAll();
                                                        foreach($snameres as $snr) {
                                                            echo "Exam Schedule : <strong>".$snr['start']."</strong>";
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="alert alert-warning" role="alert">
                                                    <h4 class="alert-heading">Process History:</h4>
                                                    <p>
                                                        <?php
                                                            $logs = $DB_con->prepare("SELECT * FROM logs_enroll WHERE ern = :ern");
                                                            $logs->execute(array( ':ern'=>$_SESSION['ern']));
                                                            $logsresult = $logs->fetchAll();
                                                            foreach($logsresult as $log) {
                                                                ?>
                                                                    <p><?php echo $log['usertouch']; ?></p>
                                                                    <p>Log Time : <?php echo $log['touch']; ?></p>
                                                                    <p>Notes : <?php echo $log['notes']; ?></p>
                                                                    <hr>
                                                        <?php
                                                            }
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div>
                        </div>
                        <!-- form ends !-->
                    </div>
                    <?php include_once "includes/footer.php"; ?>
                </div>
                <?php include_once "includes/scripts.php";?>
            </div>
        </div>
    </body>

</html>