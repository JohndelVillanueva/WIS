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
                                            <i class="anticon anticon-users"></i>
                                        </span>
                                    Students for Completion
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
                                <div class="row ">
                                    <div class="col-lg-12">
                                        <table id="userlist" class="display table table-stripped table-fluid"  >
                                            <thead>
                                            <tr>
                                                <th scope="col">Reference Number</th>
                                                <th scope="col">Full Name</th>
                                                <th scope="col">Grade / Section</th>
                                                <th scope="col">Recommendations</th>
                                                <th scope="col">Gender</th>
                                                <th scope="col">Date of Birth</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $pdo_statement = $DB_con->prepare("SELECT * FROM users24 INNER JOIN s_recommendations ON users24.username = s_recommendations.user_id  WHERE users24.position = :position AND users24.status = :status AND s_recommendations.completion = 1 ORDER BY users24.id DESC");
                                            $pdo_statement->execute([":position" => "Student" , ":status" => 8]);
                                            $result = $pdo_statement->fetchAll();
                                            foreach ($result as $row) {
                                                ?>
                                                <tr style="padding-top:10px!important; padding-bottom:10px!important;">
                                                    <form>
                                                        <th scope="row">
                                                            <div class="col-lg-12">
                                                                <p><a class="btn btn-primary" data-toggle="collapse" href="#collapseExample<?php echo $row['uniqid']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $row['uniqid']; ?>"><?php echo $row["uniqid"]; ?></a></p>
                                                                <?php
                                                                $logs = $DB_con->prepare("SELECT * FROM logs_enroll WHERE ern = :ern");
                                                                $logs->execute(array(':ern' => $row['uniqid']));
                                                                $logsresult = $logs->fetchAll();
                                                                foreach ($logsresult as $log) {
                                                                    ?>
                                                                    <div class="collapse" id="collapseExample<?php echo $row['uniqid']; ?>">
                                                                        <div class="card card-body">
                                                                            <?php echo $log['notes'] . " (" . $log['usertouch'] . "@" . $log['touch'] . ")"; ?>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </th>
                                                        <td><?php echo $row["lname"] . ", " . $row["fname"] . " " . $row["mname"]; ?></td>
                                                        <td><?php echo $row["grade"] . " - " . $row["section"]; ?></td>
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
                                                        <td><?php echo $row["gender"]; ?></td>
                                                        <td><?php echo date("F j, Y", strtotime($row["dob"])); ?></td>
                                                    </form>
                                                </tr>
                                                <?php
                                            }
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
    $(document).ready( function() {
        $('#userlist').DataTable( {
            dom: 'frtipB',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'print'
            ],
            "pageLength":15
        } );
    } );
</script>
</body>

</html>