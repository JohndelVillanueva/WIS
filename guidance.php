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
                                        New Student Application - Entrance Examination
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($_GET['ern'])) {
                                    ?>
                                        <div class="row" id="alertmsg">
                                            <div class="col-lg-12">
                                                <div class="alert alert-success" role="alert">
                                                    Successfully processed ERN <?php echo $_GET['ern']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="row">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Reference Number</th>
                                                    <th scope="col">Full Name</th>
                                                    <th scope="col">Grade Level</th>
                                                    <th scope="col">Exam Date</th>
                                                    <th scope="col">Interview Date</th>
                                                    <th scope="col">Recommendations</th>
                                                    <th scope="col">Notes</th>
                                                    <th scope="col">Approval</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $pdo_statement = $DB_con->prepare("SELECT * FROM users24 WHERE status = 4");
                                                $pdo_statement->execute();
                                                $result = $pdo_statement->fetchAll();
                                                foreach ($result as $row) {
                                                ?>
                                                    <tr>
                                                        <form id="myForm" method="post" action="process.php">
                                                            <th scope="row">
                                                                <div class="col-lg-12">
                                                                    <p><a class="btn btn-primary" data-toggle="collapse" href="#collapseExample<?php echo $row['uniqid']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $row['uniqid']; ?>"><?php echo $row["uniqid"]; ?></a></p>
                                                                    <?php
                                                                    $logs = $DB_con->prepare("SELECT * FROM logs_enroll WHERE ern = :ern");
                                                                    $logs->execute(array(':ern' => $row['uniqid']));
                                                                    $logsresult = $logs->fetchAll();
                                                                    foreach ($logsresult as $log) {
                                                                        include "log.php";
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </th>
                                                            <td><?php echo $row["lname"] . ", " . $row["fname"] . " " . $row["mname"]; ?></td>
                                                            <td><?php echo $row["grade"]; ?></td>
                                                            <td>
                                                                <?php
                                                                        $checksched = $DB_con->prepare("SELECT * FROM schedule WHERE title LIKE :name");
                                                                        $checksched->execute(array(":name" => "%".$row["fname"]." ".$row["lname"]."%"));
                                                                        $sched = $checksched->fetchAll();

                                                                        foreach($sched as $sked) {
                                                                            echo $sked["start"];
                                                                        }
                                                                ?>
                                                            </td>
                                                            <td><input class="form-control" type="datetime-local" id="esched" name="esched" required></td>
                                                            <td><input type="checkbox" id="esl" name="esl" value="1">
                                                                <label for="ESL">ESL</label><br>
                                                                <input type="checkbox" id="star" name="star" value="1">
                                                                <label for="STAR">STAR</label><br>
                                                                <input type="checkbox" id="completion" name="completion" value="1">
                                                                <label for="COMPLETION">COMPLETION</label><br></td>
                                                            <td>
                                                                <input class="form-control" type="text" id="notes" name="notes" placeholder="Type notes here" required>
                                                                <input type="hidden" name="sname" id="sname" value="<?php echo $row['fname'] . " " . $row['lname']; ?>">
                                                                <input type="hidden" name="stage" id="stage" value="5">
                                                                <input type="hidden" name="ern" id="ern" value="<?php echo $row["uniqid"]; ?>">
                                                                <input type="hidden" name="username" id="username" value="<?php echo $row["username"]; ?>">
                                                            </td>
                                                            <td><button type="submit" class="btn btn-success rounded"><span class="icon-holder" onclick="return confirmSubmission()" ><i class="anticon anticon-check"></i></span></button></td>
                                                        </form>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer bg-light text-center"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-warning rounded-top pt-2">
                                    <h4>
                                        <span class="icon-holder">
                                            <i class="anticon anticon-wechat"></i>
                                        </span>
                                        New Student Application - For Interview
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if (isset($_GET['ern'])) {
                                        ?>
                                        <div class="row" id="alertmsg">
                                            <div class="col-lg-12">
                                                <div class="alert alert-success" role="alert">
                                                    Successfully processed ERN <?php echo $_GET['ern']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="row">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Reference Number</th>
                                                <th scope="col">Full Name</th>
                                                <th scope="col">Interview Date</th>
                                                <th scope="col">Recommendation(s)</th>
                                                <th scope="col">Previous School</th>
                                                <th scope="col">Country</th>
                                                <!-- <th scope="col">Notes</th> -->
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $pdo_statement = $DB_con->prepare("SELECT * FROM users24 WHERE status = 5");
                                            $pdo_statement->execute();
                                            $result = $pdo_statement->fetchAll();
                                            foreach ($result as $row) {
                                                ?>
                                                <tr>
                                                    <form method="post" action="process.php">
                                                        <th scope="row">
                                                            <div class="col-lg-12">
                                                                <p><a class="btn btn-primary" data-toggle="collapse" href="#collapseExample<?php echo $row['uniqid']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $row['uniqid']; ?>"><?php echo $row["uniqid"]; ?></a></p>
                                                                <?php
                                                                $logs = $DB_con->prepare("SELECT * FROM logs_enroll WHERE ern = :ern");
                                                                $logs->execute(array(':ern' => $row['uniqid']));
                                                                $logsresult = $logs->fetchAll();
                                                                foreach ($logsresult as $log) {
                                                                    include "log.php";
                                                                }
                                                                ?>
                                                            </div>
                                                        </th>
                                                        <td>
                                                                <?php 
                                                                    if ($row['is_situation'] == "Early Bird") {
                                                                        echo '<i class="anticon anticon-star" style="color: gold; font-size: 0.9em; margin-right: 4px;"></i>';
                                                                    }
                                                                    echo $row["lname"].", ".$row["fname"]." ".$row["mname"];
                                                                ?>
                                                            </td>
                                                        <td>
                                                            <?php
                                                            $checksched = $DB_con->prepare("SELECT * FROM schedule WHERE title LIKE :name");
                                                            $checksched->execute(array(":name" => "%".$row["fname"]." ".$row["lname"]."%"));
                                                            $sched = $checksched->fetchAll();

                                                            foreach($sched as $sked) {
                                                                echo $sked["start"];
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $checkrec = $DB_con->prepare("SELECT DISTINCT * FROM s_recommendations WHERE user_id = :userid");
                                                            $checkrec->execute(array(":userid" => $row["username"]));
                                                            $recs = $checkrec->fetchAll();

                                                            foreach($recs as $reco) {
                                                                if (!empty($reco["esl"])) {
                                                                    echo "<span class='text-danger'>&check; ESL Required</span><br>";
                                                                }

                                                                if (!empty($reco["star"])) {
                                                                    echo "<span class='text-danger'>&check; STAR Required</span><br>";
                                                                }

                                                                if (!empty($reco["completion"])) {
                                                                    echo "<span class='text-danger'>&check; Completion</span>";
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row["prevsch"]; ?></td>
                                                        <td><?php echo $row["prevschcountry"]; ?></td>
                                                        <td>
                                                            <!-- <input class="form-control" type="text" id="notes" name="notes" placeholder="Type notes here"> -->
                                                            <input type="hidden" name="stage" id="stage" value="6">
                                                            <input type="hidden" name="sname" id="sname" value="<?php echo $row['fname'] . " " . $row['lname']; ?>">
                                                            <input type="hidden" name="ern" id="ern" value="<?php echo $row["uniqid"]; ?>">
                                                        </td>
                                                    </form>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <script>
                            function confirmSubmission(){
                                if(confirm('Are you sure you want to submit')){
                                    return true;
                                }else {
                                    return false;
                                }
                            }
                        </script>
                                </div>
                                <div class="card-footer bg-light text-center"></div>
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
</body>

</html>