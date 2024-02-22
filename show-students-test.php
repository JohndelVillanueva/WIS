<?php
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}
?>
<!DOCTYPE html>
<html lang="en">

<?php
    include_once "includes/css.php";
    include_once "classes/subject.class.php";
    // include_once "classes/activity.class.php";
    include_once "includes/dbconfig.php";
    // get the subject details
    $getsubject = new DB;
    $getsubject->query("SELECT * FROM s_subjects WHERE code = :code");
    $getsubject->bind(":code",$_GET["code"]);
    $subjectdetails = $getsubject->resultSet();

    // $getsubject->close();
    // $subCodeResults = new Subject();
    // $code = $_GET['code'];
    // $subCodeResult = $subCodeResults->selectSubjectbyCode($code);

    if(!empty($subjectdetails)) {
        foreach ($subjectdetails as $sdetails) {
?>
<div class="app is-folded">
    <div class="layout">
        <?php include_once "includes/heading.php"; ?>
        <?php include_once "includes/sidemenu.php"; ?>
        <div class="page-container">
            <div class="main-content">
                <!-- form starts !-->
                    <div class="row flex-nowrap overflow-auto">
                        <div class="col-lg-12">
                            
                            <div class="card">
                                <div class="card-header bg-warning">
                                    <h3 class="py-2">
                                    <div class="float-right">
                                        <a class="btn btn-primary btn-tone btn-rounded" href="add-activity.php?code=<?php echo $_GET["code"]?>&section=<?php echo$_GET["section"];?>"><i class="anticon anticon-diff"></i> Add Activity</a>
                                        <?php
                                            if(isset($_GET["lock"])) {
                                                if($_GET["lock"]==1){
                                                    ?>
                                                    <a class="btn btn-primary btn-tone btn-rounded" href="#" onclick="confirmAction2()"><i class="anticon anticon-lock"></i> Request Unlock</a>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                                <a class="btn btn-primary btn-tone btn-rounded" href="#" onclick="confirmAction()"><i class="anticon anticon-lock"></i> Registrar Verification</a>
                                                <?php
                                            }
                                        ?>
                                        <script>
                                            const confirmAction = () => {
                                                const response = confirm("Are you sure you want submit this to the registrar?");
                                                if (response) {
                                                    window.location.replace("verify-grades.php?code=<?php echo $_GET["code"]?>&section=<?php echo$_GET["section"];?>");
                                                }
                                            }

                                            const confirmAction2 = () => {
                                                const response = confirm("Are you sure you want request unlock?");
                                                if (response) {
                                                    window.location.replace("request-unlock.php?code=<?php echo $_GET["code"]?>&section=<?php echo$_GET["section"];?>");
                                                }
                                            }
                                        </script>
                                    </div>
                                        <?php
                                            echo $sdetails["subjdesc"] ." ". $sdetails["subjlevel"];

                                            //GET ACTIVITIES
                                            // $code = $_GET["code"];
                                            // $qtr = $_GET["actqtr"];
                                            // $section = $_GET["section"];
                                            // $writtenWorkQuery = new Activity();
                                            // $getWrittenWorkResult = $writtenWorkQuery->getAllWrittenWork($code,$qtr,$section);

                                            // 1. GET ALL WRITTEN WORKS
                                            $getactivitiesww = new DB;
                                            $getactivitiesww->getActivity($_GET["code"],$_GET["qtr"],$_GET["section"],"%WW%");
                                            $getactivitiesww->close();

                                            // // 1. GET ALL PERFORMANCE TASK
                                            $getactivitiespt = new DB;
                                            $getactivitiespt->getActivity($_GET["code"],$_GET["qtr"],$_GET["section"],"%PT%");
                                            $getactivitiespt->close();

                                            // // 1. GET ALL QUARTERLY ASSESSMENTS WORKS
                                            $getactivitiesqa = new DB;
                                            $getactivitiesqa->getActivity($_GET["code"],$_GET["qtr"],$_GET["section"],"%QA%");
                                            $getactivitiesqa->close();

                                        ?>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-hover table-bordered table-condensed">
                                    <tr class="alert-primary text-center h5">
                                        <th colspan="">Learner's Name</th>
                                        <th colspan="<?php $rowWW = $getactivitiesww->rowCount() >= 0 ? $getactivitiesww->rowCount()+4 : $getactivitiesww->rowCount()+3; echo $rowWW; ?>">Written Works (<?php echo $sdetails["percentww"]*100;?>%)</th>
                                        <th colspan="<?php $rowPT = $getactivitiespt->rowCount() >= 0 ? $getactivitiespt->rowCount()+4 : $getactivitiespt->rowCount()+3; echo $rowPT; ?>">Performance Task (<?php echo $sdetails["percentpt"]*100;?>%)</th>
                                        <th colspan="<?php $rowQA = $getactivitiesqa->rowCount() >= 0 ? $getactivitiesqa->rowCount()+4 : $getactivitiesqa->rowCount()+3; echo $rowQA; ?>">Quarterly Assessment (<?php echo $sdetails["percentqt"]*100;?>%)</th>
                                        <th colspan="">Initial Grade</th>
                                        <th colspan="">Quarterly Grade</th>
                                    </tr>

                                        <tbody>
                                        <tr>
                                            <!-- TABLE HEADING !-->
                                            <td class="text-center">Male</td>
                                            <?php
                                                if (!empty($actdetailsww)) {
                                                    for ($ww = 1; $ww <= $WWcounter; $ww++) {
                                                        echo "<td class='text-center'>" . $ww . "</td>";
                                                    }
                                                } else {
                                                    echo "<td class='alert-warning text-center'>*** NO ACTIVITIES YET ***</td>";
                                                }
                                                ?>
                                                <td>Total</td>
                                                <td>PS</td>
                                                <td>WS</td>
                                                <?php

                                                if(!empty($actdetailspt)){
                                                    for($pt=1; $pt <= $PTcounter; $pt++) {
                                                        echo "<td class='text-center'>".$pt."</td>";
                                                    }
                                                } else {
                                                    echo "<td class='alert-warning text-center'>*** NO ACTIVITIES YET ***</td>";
                                                }
                                                ?>
                                                <td class="text-center">Total</td>
                                                <td class="text-center">PS</td>
                                                <td class="text-center">WS</td>
                                                <?php

                                                if(!empty($actdetailsqa)){
                                                    for($qa=1; $qa <= $QAcounter; $qa++) {
                                                        echo "<td class='text-center'>".$qa."</td>";
                                                    }
                                                } else {
                                                    echo "<td class='alert-warning text-center'>*** NO ACTIVITIES YET ***</td>";
                                                }
                                                ?>
                                            <td class="text-center">Total</td>
                                            <td class="text-center">PS</td>
                                            <td class="text-center">WS</td>
                                            <td class="text-center">0</td>
                                            <td class="text-center">0</td>
                                        </tr>
                                        <!-- STUDENTS !-->

                                            <?php
                                            $getstudents = new DB;
                                            $getstudents->query("SELECT * FROM user WHERE section = :section AND gender = :gender");
                                            // $getstudents->bind(":grade",$_GET["grade"]);
                                            $getstudents->bind(":section",$_GET["section"]);
                                            $getstudents->bind(":gender","M");
                                            $studentdetails = $getstudents->resultSet();

                                            $getstudents->close();

                                            if(!empty($studentdetails)) {
                                                foreach ($studentdetails as $details) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $details["lname"].", ".$details["fname"]." ".$details["mname"]; ?></td>
                                                        </tr>
                                                    <?php

                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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
    <?php
        }
}
?>

</body>

</html>