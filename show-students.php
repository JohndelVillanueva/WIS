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

<?php
$subjects = $DB_con->prepare("SELECT * FROM s_subjects 
WHERE code = :code");
$subjects->execute(array(":code" => $_GET["code"]));
$result = $subjects->fetchAll();

foreach ($result as $row) {
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
                                    <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-book"></i></span> <?php echo $row["subjdesc"] . " " . $row["subjlevel"] . " - " . $_GET["section"]; ?></h3>
                                </div>
                                <div class="card-body">
                                    <?php           
                                    if (isset($_GET["lock"])) {
                                        if ($_GET["lock"] == 1) {
                                    ?>
                                            <div class="alert alert-info" id="nagscreen">
                                                <h3 class="text-center pt-2">Successfully submitted to Registrar for Verification.</h3>
                                            </div>
                                            <script>
                                                setTimeout(function() {
                                                    $('#nagscreen').fadeOut('fast');
                                                }, 3000);
                                            </script>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <div class="float-right">
                                        <a class="btn btn-primary btn-tone btn-rounded" href="add-activity.php?code=<?php echo $_GET["code"] ?>&section=<?php echo $_GET["section"]?>&qtr=<?=$_GET['qtr']; ?>&grade=<?=$row['subjlevel']; ?>"><i class="anticon anticon-diff"></i> Add Activity</a>
                                        <?php
                                        if (isset($_GET["lock"])) {
                                            if ($_GET["lock"] == 1) {
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
                                                    window.location.replace("verify-grades.php?code=<?php echo $_GET["code"]; ?>&section=<?php echo $_GET["section"]; ?>&subjdesc=<?php echo $row["subjdesc"]; ?>&qtr=<?php echo $_GET["qtr"]; ?>&grade=<?=$row['subjlevel']; ?>");
                                                }
                                            }

                                            const confirmAction2 = () => {
                                                const response = confirm("Are you sure you want request unlock?");
                                                if (response) {
                                                    window.location.replace("request-unlock.php?code=<?php echo $_GET["code"] ?>&section=<?php echo $_GET["section"]; ?>");
                                                }
                                            }
                                        </script>
                                    </div>
                                    <br><br><br>
                                    <?php
                                    // Prepare the SQL statement
                                    $statement = "SELECT * FROM s_activities SA 
                                        LEFT JOIN s_scores SS ON SA.actid = SS.actid
                                        WHERE SA.actlvl = :glevel AND SA.actsection = :section AND SA.actqtr = :qtr AND SS.subjcode = :subjcode ";

                                    // for activities
                                    $activityQuery = $DB_con->prepare($statement . "AND SA.actid LIKE 'WW%'");
                                    $activityQuery->execute(array(
                                        ":glevel" => $row["subjlevel"],
                                        ":section" => $_GET["section"],
                                        ":qtr" => $_GET["qtr"],
                                        ":subjcode" => $row["code"]
                                    ));
                                    $activitiesResult = $activityQuery->fetch(PDO::FETCH_ASSOC);

                                    // for performance tasks
                                    $perftaskQuery = $DB_con->prepare($statement . "AND SA.actid LIKE 'PT%'");
                                    $perftaskQuery->execute(array(
                                        ":glevel" => $row["subjlevel"],
                                        ":section" => $_GET["section"],
                                        ":qtr" => $_GET["qtr"],
                                        ":subjcode" => $row["code"]
                                    ));
                                    $performanceTasksResult = $perftaskQuery->fetch(PDO::FETCH_ASSOC);

                                    // for per quarter
                                    $perQuarterQuery = $DB_con->prepare($statement . "AND SA.actid LIKE 'QT%'");
                                    $perQuarterQuery->execute(array(
                                        ":glevel" => $row["subjlevel"],
                                        ":section" => $_GET["section"],
                                        ":qtr" => $_GET["qtr"],
                                        ":subjcode" => $row["code"]
                                    ));
                                    $perQuartersResult = $perQuarterQuery->fetch(PDO::FETCH_ASSOC);

                                    $statement1 = "SELECT DISTINCT SS.actid FROM s_scores ss
                                         LEFT JOIN s_activities sa ON SS.actid = SA.actid
                                         WHERE SA.actsection = :section AND SA.actlvl = :glevel AND ss.subjcode = :subjcode";

                                    // Written work Statement
                                    $writtenWorkQuery = $DB_con->prepare($statement1 . " AND sa.actid LIKE 'WW%' AND sa.actqtr = :qtr");
                                    $writtenWorkQuery->execute(array(
                                        ":glevel" => $row["subjlevel"],
                                        ":section" => $_GET["section"],
                                        ":qtr" => $_GET["qtr"],
                                        ":subjcode" => $row["code"]
                                    ));

                                    // PerformTask statement 
                                    $performTaskQuery = $DB_con->prepare($statement1 . " AND sa.actid LIKE 'PT%' AND sa.actqtr = :qtr");
                                    $performTaskQuery->execute(array(
                                        ":glevel" => $row["subjlevel"],
                                        ":section" => $_GET["section"],
                                        ":qtr" => $_GET["qtr"],
                                        ":subjcode" => $row["code"]
                                    ));

                                    // perQuarter Task statements
                                    $perQuarterQuery = $DB_con->prepare($statement1 . " AND sa.actid LIKE 'QT%' AND sa.actqtr = :qtr");
                                    $perQuarterQuery->execute(array(
                                        ":glevel" => $row["subjlevel"],
                                        ":section" => $_GET["section"],
                                        ":qtr" => $_GET["qtr"],
                                        ":subjcode" => $row["code"]
                                    ));

                                    // Calculate number of Written work plus 3 (ww)
                                    $activitiesResult = $writtenWorkQuery->rowCount() + 3;
                                    // Calculate number of performance task plus 3 (pt)
                                    $performanceTasksResult = $performTaskQuery->rowCount() + 3;
                                    // Calculate number of quarters plus 2 (qt)
                                    $perQuartersResult = $perQuarterQuery->rowCount() + 2;


                                    ?>

                                    <table class="table table-hover table-bordered table-condensed">
                                        <tbody>
                                            <tr>
                                                <td class="alert-success text-center font-size-20 bold" rowspan="2" style="width:250px!important;">Student<br>Name</td>
                                                <td class="alert-success text-center font-size-20 bold" colspan="<?php echo $activitiesResult; ?>">Written Works (<?php echo $row["percentww"] * 100; ?>%)</td>
                                                <td class="alert-success text-center font-size-20 bold" colspan="<?php echo $performanceTasksResult; ?>">Performance Tasks (<?php echo $row["percentpt"] * 100; ?>%)</td>
                                                <td class="alert-success text-center font-size-20 bold" colspan="<?php echo $perQuartersResult; ?>">Quarterly Assessment (<?php echo $row["percentqt"] * 100; ?>%)</td>
                                                <td class="alert-success text-center font-size-20 bold" rowspan="2">Initial<br>Grade</td>
                                                <td class="alert-success text-center font-size-20 bold" rowspan="2">Final<br>Grade</td>
                                            </tr>

                                            <tr>
                                                <?php
                                                // Display cells for written work
                                                // Get the number of rows from $writtenWork
                                                $rowCount = $writtenWorkQuery->rowCount();
                                                // Create an array of numbers from 1 to rowCount
                                                $numbers = range(1, $rowCount);
                                                // Iterate over the array using foreach
                                                foreach ($numbers as $actno) {
                                                    echo "<td class='alert-secondary'>" . $actno . "</td>";
                                                }

                                                ?>
                                                <td class='alert-secondary'>TOTAL</td>
                                                <td class='alert-secondary'>PS</td>
                                                <td class='alert-secondary'>WS</td>

                                                <?php

                                                // Display cells for performance tasks
                                                foreach ($performTaskQuery  as $ptno => $task) {
                                                    echo "<td class='alert-secondary'>" . ($ptno + 1) . "</td>";
                                                }

                                                ?>
                                                <td class='alert-secondary'>TOTAL</td>
                                                <td class='alert-secondary'>PS</td>
                                                <td class='alert-secondary'>WS</td>

                                                <?php
                                                // Display cells for per quarter
                                                foreach ($perQuarterQuery  as $qtno => $task) {
                                                    echo "<td class='alert-secondary'>" . ($qtno + 1) . "</td>";
                                                }
                                                ?>
                                                <td class='alert-secondary'>PS</td>
                                                <td class='alert-secondary'>WS</td>
                                            </tr>

                                            <?php
                                            echo "<tr><td>MALE</td></tr>";

                                            $student = $DB_con->prepare("SELECT * FROM user WHERE grade = :grade AND section = :section AND position = :position AND gender = 'M' ORDER BY lname ASC");
                                            $student->execute(array(":grade" => $row["subjlevel"], ":section" => $_GET["section"], ":position" => "Student"));
                                            $stud = $student->fetchAll();
                                            foreach ($stud as $srow) {
                                            ?><tr>
                                                    <td><?php echo ucwords(strtolower($srow["lname"] . ", " . $srow["fname"] . " " . $srow["mname"])); ?></td>
                                                    <?php

                                                    // WRITTEN WORK
                                                    $qtr = $_GET['qtr'];
                                                    $wgrades = $DB_con->prepare("SELECT * FROM s_scores 
                                                    LEFT JOIN s_subjects ON s_scores.subjcode = s_subjects.code
                                                    WHERE sid = :sid AND subjcode = :subjcode AND acttype = 1 AND qtr = :qtr AND s_subjects.id = :id ");
                                                    $wgrades->execute(array(":sid" => $srow["username"], ":subjcode" => $_GET["code"], ":qtr" => $qtr, ":id" => $row['id']));
                                                    $rwgrade = $wgrades->fetchAll();
                                                    $wgsum = 0;
                                                    $wgmax = 0;
                                                    foreach ($rwgrade as $rrow) {
                                                    ?>
                                                        <td class='text-center font-weight-bold <?php if ($rrow["score"] == 0) {
                                                                                                    echo "alert-danger";
                                                                                                } ?>'>
                                                            <?php
                                                            if ($rrow["flag"] == 0) {
                                                            ?>
                                                                <a href="edit-score.php?sid=<?php echo $srow["username"]; ?>&subjcode=<?php echo $_GET["code"]; ?>&actid=<?php echo $rrow["actid"]; ?>&section=<?php echo $_GET["section"]; ?>">
                                                                    <?php
                                                                    echo $rrow["score"] . "/" . $rrow["maxscore"];
                                                                    ?>
                                                                </a>
                                                            <?php
                                                            } elseif ($rrow["flag"] == 1) {
                                                            ?>
                                                                <?php echo $rrow["score"] . "/" . $rrow["maxscore"]; ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    <?php
                                                        $wgsum += $rrow["score"];
                                                        $wgmax += $rrow["maxscore"];
                                                    }

                                                    switch ($wgrades->rowCount()) {
                                                        case 0:
                                                            $wgps = 0;
                                                            break;
                                                        default:
                                                            $wgps = ($wgsum / $wgmax) * 100;
                                                    }

                                                    if ($wgrades->rowCount() != 0) {
                                                        echo "<td class='text-center font-weight-bold'>" . $wgsum . "/" . $wgmax . "</td>";
                                                        echo "<td class='text-center font-weight-bold'>" . round($wgps, 2) . "</td>";
                                                        echo "<td class='text-center font-weight-bold text-success'>" . round(round($wgps, 2) * $row["percentww"], 2) . "</td>";
                                                    } else {
                                                        echo "<td class='alert-warning text-center text-gray font-size-10' colspan='" . $activitiesResult . "'>*** NO DATA ***</td>";
                                                    }

                                                    // END OF WRITTEN WORK

                                                    $qtr = $_GET['qtr'];
                                                    $pgrades = $DB_con->prepare("SELECT * FROM s_scores 
                                                    LEFT JOIN s_subjects ON s_scores.subjcode = s_subjects.code
                                                    WHERE sid = :sid AND subjcode = :subjcode AND acttype = 2 AND qtr = :qtr AND subjdesc = :subjdesc ");
                                                    $pgrades->execute(array(":sid" => $srow["username"], ":subjcode" => $_GET["code"], ":qtr" => $qtr, ":subjdesc" => $_GET['subjdesc']));
                                                    $rpgrade = $pgrades->fetchAll();
                                                    $pgsum = 0;
                                                    $pgmax = 0;
                                                    foreach ($rpgrade as $prow) {
                                                    ?>
                                                        <td class='text-center font-weight-bold <?php if ($prow["score"] == 0) {
                                                                                                    echo "alert-danger";
                                                                                                } ?>'>
                                                            <?php
                                                            if ($prow["flag"] == 0) {
                                                            ?>
                                                                <a href="edit-score.php?sid=<?php echo $srow["username"]; ?>&subjcode=<?php echo $_GET["code"]; ?>&actid=<?php echo $prow["actid"]; ?>&section=<?php echo $_GET["section"]; ?>"><?php echo $prow["score"] . "/" . $prow["maxscore"]; ?></a>
                                                            <?php
                                                            } elseif ($prow["flag"] == 1) {
                                                            ?>
                                                                <?php echo $prow["score"] . "/" . $prow["maxscore"]; ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    <?php
                                                        $pgsum += $prow["score"];
                                                        $pgmax += $prow["maxscore"];
                                                    }

                                                    switch ($pgrades->rowCount()) {
                                                        case 0:
                                                            $pgps = 0;
                                                            break;
                                                        default:
                                                            $pgps = ($pgsum / $pgmax) * 100;
                                                    }

                                                    if ($pgrades->rowCount() != 0) {
                                                        echo "<td class='text-center font-weight-bold '>" . $pgsum . "/" . $pgmax . "</td>";
                                                        echo "<td class='text-center font-weight-bold'>" . round($pgps, 2) . "</td>";
                                                        echo "<td class='text-center font-weight-bold text-success'>" . round(round($pgps, 2) * $row["percentpt"], 2) . "</td>";
                                                    } else {
                                                        echo "<td class='alert-warning text-center text-gray font-size-10' colspan='" . $performanceTasksResult . "'>*** NO DATA ***</td>";
                                                    }

                                                    //QUARTERLY EXAM

                                                    $qtr = $_GET['qtr'];
                                                    $qgrades = $DB_con->prepare("SELECT * FROM s_scores 
                                                    LEFT JOIN s_subjects ON s_scores.subjcode = s_subjects.code
                                                    WHERE sid = :sid AND subjcode = :subjcode AND acttype = 3 AND qtr = :qtr AND subjdesc = :subjdesc ");
                                                    $qgrades->execute(array(":sid" => $srow["username"], ":subjcode" => $_GET["code"], ":qtr" => $qtr, ":subjdesc" => $_GET['subjdesc']));
                                                    $qrpgrade = $qgrades->fetchAll();
                                                    $qgsum = 0;
                                                    $qgmax = 0;
                                                    foreach ($qrpgrade as $qrow) {
                                                    ?>
                                                        <td class='text-center font-weight-bold <?php if ($qrow["score"] == 0) {
                                                                                                    echo "alert-danger";
                                                                                                } ?>'>
                                                            <?php
                                                            if ($qrow["flag"] == 0) {
                                                            ?>
                                                                <a href="edit-score.php?sid=<?php echo $srow["username"]; ?>&subjcode=<?php echo $_GET["code"]; ?>&actid=<?php echo $qrow["actid"]; ?>&section=<?php echo $_GET["section"]; ?>"><?php echo $qrow["score"] . "/" . $qrow["maxscore"]; ?></a>
                                                            <?php
                                                            } elseif ($qrow["flag"] == 1) {
                                                            ?>
                                                                <?php echo $qrow["score"] . "/" . $qrow["maxscore"]; ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    <?php
                                                        $qgsum += $qrow["score"];
                                                        $qgmax += $qrow["maxscore"];
                                                    }

                                                    switch ($qgrades->rowCount()) {
                                                        case 0:
                                                            $qgps = 0;
                                                            break;
                                                        default:
                                                            $qgps = ($qgsum / $qgmax) * 100;
                                                    }

                                                    if ($qgrades->rowCount() != 0) {
                                                        echo "<td class='text-center font-weight-bold'>" . round($qgps, 2) . "</td>";
                                                        echo "<td class='text-center font-weight-bold text-success'>" . round(round($qgps, 2) * $row["percentqt"], 2) . "</td>";
                                                    } else {
                                                        echo "<td class='alert-warning text-center text-gray font-size-10' colspan='" . $perQuartersResult . "'>*** NO DATA ***</td>";
                                                    }

                                                    $initgrade = round(round($wgps, 2) * $row["percentww"] + round($pgps, 2) * $row["percentpt"] + round($qgps, 2) * $row["percentqt"], 2);

                                                    if ($initgrade != 0) {
                                                        echo "<td class='text-center font-weight-bold text-success'>" . $initgrade . "</td>";
                                                    } else {
                                                        echo "<td class='alert-warning text-center text-gray font-size-10'>*** NO DATA ***</td>";
                                                    }

                                                    $finalgrade = $DB_con->prepare("SELECT * FROM s_transmute WHERE :initgrade BETWEEN lowerl AND upperl");
                                                    $finalgrade->execute(array(":initgrade" =>  round($initgrade, 1)));
                                                    $finalg = $finalgrade->fetchAll();

                                                    foreach ($finalg as $finalrow) {
                                                        echo "<td class='text-center font-weight-bold alert-primary font-size-16'>" . $finalrow["transmuted"] . "</td>";
                                                    }
                                                }


                                                //female
                                                echo "<tr><td>FEMALE</td></tr>";
                                                $student = $DB_con->prepare("SELECT * FROM user WHERE grade = :grade AND section = :section AND position = :position AND gender = 'F' ORDER BY lname ASC");
                                                $student->execute(array(":grade" => $row["subjlevel"], ":section" => $_GET["section"], ":position" => "Student"));
                                                $stud = $student->fetchAll();
                                                foreach ($stud as $srow) {
                                                    ?>
                                                <tr>
                                                    <td><?php echo ucwords(strtolower($srow["lname"] . ", " . $srow["fname"] . " " . $srow["mname"])); ?></td>
                                                    <?php

                                                    // WRITTEN WORK
                                                    $qtr = $_GET['qtr'];
                                                    $wgrades = $DB_con->prepare("SELECT * FROM s_scores 
                                                    LEFT JOIN s_subjects ON s_scores.subjcode = s_subjects.code
                                                    WHERE sid = :sid AND subjcode = :subjcode AND acttype = 1 AND qtr = :qtr AND subjdesc = :subjdesc ");
                                                    $wgrades->execute(array(":sid" => $srow["username"], ":subjcode" => $_GET["code"], ":qtr" => $qtr, ":subjdesc" => $_GET['subjdesc']));
                                                    $rwgrade = $wgrades->fetchAll();
                                                    $wgsum = 0;
                                                    $wgmax = 0;
                                                    foreach ($rwgrade as $rrow) {
                                                    ?>
                                                        <td class='text-center font-weight-bold <?php if ($rrow["score"] == 0) {
                                                                                                    echo "alert-danger";
                                                                                                } ?>'>
                                                            <?php
                                                            if ($rrow["flag"] == 0) {
                                                            ?>
                                                                <a href="edit-score.php?sid=<?php echo $srow["username"]; ?>&subjcode=<?php echo $_GET["code"]; ?>&actid=<?php echo $rrow["actid"]; ?>&section=<?php echo $_GET["section"]; ?>">
                                                                    <?php
                                                                    echo $rrow["score"] . "/" . $rrow["maxscore"];
                                                                    ?>
                                                                </a>
                                                            <?php
                                                            } elseif ($rrow["flag"] == 1) {
                                                            ?>
                                                                <?php echo $rrow["score"] . "/" . $rrow["maxscore"]; ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    <?php
                                                        $wgsum += $rrow["score"];
                                                        $wgmax += $rrow["maxscore"];
                                                    }

                                                    switch ($wgrades->rowCount()) {
                                                        case 0:
                                                            $wgps = 0;
                                                            break;
                                                        default:
                                                            $wgps = ($wgsum / $wgmax) * 100;
                                                    }

                                                    if ($wgrades->rowCount() != 0) {
                                                        echo "<td class='text-center font-weight-bold'>" . $wgsum . "/" . $wgmax . "</td>";
                                                        echo "<td class='text-center font-weight-bold'>" . round($wgps, 2) . "</td>";
                                                        echo "<td class='text-center font-weight-bold text-success'>" . round(round($wgps, 2) * $row["percentww"], 2) . "</td>";
                                                    } else {
                                                        echo "<td class='alert-warning text-center text-gray font-size-10' colspan='" . $activitiesResult . "'>*** NO DATA ***</td>";
                                                    }

                                                    // END OF WRITTEN WORK
                                                    $qtr = $_GET['qtr'];
                                                    $pgrades = $DB_con->prepare("SELECT * FROM s_scores 
                                                    LEFT JOIN s_subjects ON s_scores.subjcode = s_subjects.code
                                                    WHERE sid = :sid AND subjcode = :subjcode AND acttype = 2 AND qtr = :qtr AND subjdesc = :subjdesc ");
                                                    $pgrades->execute(array(":sid" => $srow["username"], ":subjcode" => $_GET["code"], ":qtr" => $qtr, ":subjdesc" => $_GET['subjdesc']));
                                                    $rpgrade = $pgrades->fetchAll();
                                                    $pgsum = 0;
                                                    $pgmax = 0;
                                                    foreach ($rpgrade as $prow) {
                                                    ?>
                                                        <td class='text-center font-weight-bold <?php if ($prow["score"] == 0) {
                                                                                                    echo "alert-danger";
                                                                                                } ?>'>
                                                            <?php
                                                            if ($prow["flag"] == 0) {
                                                            ?>
                                                                <a href="edit-score.php?sid=<?php echo $srow["username"]; ?>&subjcode=<?php echo $_GET["code"]; ?>&actid=<?php echo $prow["actid"]; ?>&section=<?php echo $_GET["section"]; ?>"><?php echo $prow["score"] . "/" . $prow["maxscore"]; ?></a>
                                                            <?php
                                                            } elseif ($prow["flag"] == 1) {
                                                            ?>
                                                                <?php echo $prow["score"] . "/" . $prow["maxscore"]; ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    <?php
                                                        $pgsum += $prow["score"];
                                                        $pgmax += $prow["maxscore"];
                                                    }

                                                    switch ($pgrades->rowCount()) {
                                                        case 0:
                                                            $pgps = 0;
                                                            break;
                                                        default:
                                                            $pgps = ($pgsum / $pgmax) * 100;
                                                    }

                                                    if ($pgrades->rowCount() != 0) {
                                                        echo "<td class='text-center font-weight-bold '>" . $pgsum . "/" . $pgmax . "</td>";
                                                        echo "<td class='text-center font-weight-bold'>" . round($pgps, 2) . "</td>";
                                                        echo "<td class='text-center font-weight-bold text-success'>" . round(round($pgps, 2) * $row["percentpt"], 2) . "</td>";
                                                    } else {
                                                        echo "<td class='alert-warning text-center text-gray font-size-10' colspan='" . $performanceTasksResult . "'>*** NO DATA ***</td>";
                                                    }

                                                    //QUARTERLY EXAM
                                                    $qtr = $_GET['qtr'];
                                                    $qgrades = $DB_con->prepare("SELECT * FROM s_scores 
                                                    LEFT JOIN s_subjects ON s_scores.subjcode = s_subjects.code
                                                    WHERE sid = :sid AND subjcode = :subjcode AND acttype = 3 AND qtr = :qtr AND subjdesc = :subjdesc ");
                                                    $qgrades->execute(array(":sid" => $srow["username"], ":subjcode" => $_GET["code"], ":qtr" => $qtr, ":subjdesc" => $_GET['subjdesc']));
                                                    $qrpgrade = $qgrades->fetchAll();
                                                    $qgsum = 0;
                                                    $qgmax = 0;
                                                    foreach ($qrpgrade as $qrow) {
                                                    ?>
                                                        <td class='text-center font-weight-bold <?php if ($qrow["score"] == 0) {
                                                                                                    echo "alert-danger";
                                                                                                } ?>'>
                                                            <?php
                                                            if ($qrow["flag"] == 0) {
                                                            ?>
                                                                <a href="edit-score.php?sid=<?php echo $srow["username"]; ?>&subjcode=<?php echo $_GET["code"]; ?>&actid=<?php echo $qrow["actid"]; ?>&section=<?php echo $_GET["section"]; ?>"><?php echo $qrow["score"] . "/" . $qrow["maxscore"]; ?></a>
                                                            <?php
                                                            } elseif ($qrow["flag"] == 1) {
                                                            ?>
                                                                <?php echo $qrow["score"] . "/" . $qrow["maxscore"]; ?>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                <?php
                                                        $qgsum += $qrow["score"];
                                                        $qgmax += $qrow["maxscore"];
                                                    }

                                                    switch ($qgrades->rowCount()) {
                                                        case 0:
                                                            $qgps = 0;
                                                            break;
                                                        default:
                                                            $qgps = ($qgsum / $qgmax) * 100;
                                                    }

                                                    if ($qgrades->rowCount() != 0) {
                                                        echo "<td class='text-center font-weight-bold'>" . round($qgps, 2) . "</td>";
                                                        echo "<td class='text-center font-weight-bold text-success'>" . round(round($qgps, 2) * $row["percentqt"], 2) . "</td>";
                                                    } else {
                                                        echo "<td class='alert-warning text-center text-gray font-size-10' colspan='" . $perQuartersResult . "'>*** NO DATA ***</td>";
                                                    }

                                                    $initgrade = round(round($wgps, 2) * $row["percentww"] + round($pgps, 2) * $row["percentpt"] + round($qgps, 2) * $row["percentqt"], 2);

                                                    if ($initgrade != 0) {
                                                        echo "<td class='text-center font-weight-bold text-success'>" . $initgrade . "</td>";
                                                    } else {
                                                        echo "<td class='alert-warning text-center text-gray font-size-10'>*** NO DATA ***</td>";
                                                    }

                                                    $finalgrade = $DB_con->prepare("SELECT * FROM s_transmute WHERE :initgrade BETWEEN lowerl AND upperl");
                                                    $finalgrade->execute(array(":initgrade" => $initgrade));
                                                    $finalg = $finalgrade->fetchAll();

                                                    foreach ($finalg as $finalrow) {
                                                        echo "<td class='text-center font-weight-bold alert-primary font-size-16'>" . $finalrow["transmuted"] . "</td>";
                                                    }
                                                }

                                                ?>
                                                </tr>
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
            <?php include_once "includes/scripts.php"; ?>
        </div>
    </div>
<?php
}
?>

</body>

</html>