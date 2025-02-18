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
                                        New Student Application - Pending Payment
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
                                                    <th scope="col">Payables</th>
                                                    <th scope="col">Notes</th>
                                                    <th scope="col">Payment</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $pdo_statement = $DB_con->prepare("SELECT * FROM users24 WHERE status = 2");
                                                $pdo_statement->execute();
                                                $result = $pdo_statement->fetchAll();
                                                foreach ($result as $row) {
                                                ?>
                                                    <tr>
                                                        <form id="myForm" method="post" action="pay.php">
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
                                                                // Fetch records from the database
                                                                $checkRecord = $DB_con->prepare("SELECT * FROM s_payables WHERE user_id = :userid");
                                                                $checkRecord->execute(array(":userid" => $row["uniqid"]));
                                                                $records = $checkRecord->fetchAll();

                                                                ?>
                                                                <div class="row">
                                                                    <?php foreach ($records as $record) : ?>
                                                                        <div class="col-4">
                                                                            <?php if (!empty($record["assessment_fee"])) : ?>
                                                                                <input class="form-check-input" type="checkbox" name="assessmentFee" id="assessmentFee">
                                                                                <label class="form-check-label" for="assessmentFee">Assessment Fee</label>
                                                                            <?php else : ?>
                                                                                <label class="text-danger"> Assessment Fee</label>
                                                                            <?php endif; ?>
                                                                            <div class="form-check">
                                                                                <?php if (!empty($record["tuition_fee"])) : ?>
                                                                                    <input class="form-check-input" type="checkbox" name="afTuitionFee" id="afTuitionFee">
                                                                                    <label class="form-check-label" for="afTuitionFee">Tuition Fee</label>
                                                                                <?php else : ?>
                                                                                    <label class="text-danger"> Tuition Fee</label>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <?php if (!empty($record["other_fee"])) : ?>
                                                                                    <input class="form-check-input" type="checkbox" name="afTfOtherFees" id="afTfOtherFees">
                                                                                    <label class="form-check-label" for="afTfOtherFees">Other Fees</label>
                                                                                <?php else : ?>
                                                                                    <label class="text-danger">Other Fees</label>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <?php if (!empty($record["reservation_fee"])) : ?>
                                                                                    <input class="form-check-input" type="checkbox" name="applicationFee" id="applicationFee">
                                                                                    <label class="form-check-label" for="applicationFee">Reservation Fee</label>
                                                                                <?php else : ?>
                                                                                    <label class="text-danger"> Reservation Fee</label>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <?php if (!empty($record["pta"])) : ?>
                                                                                    <input class="form-check-input" type="checkbox" name="pta" id="pta">
                                                                                    <label class="form-check-label" for="pta">PTA</label>
                                                                                <?php else : ?>
                                                                                    <label class="text-danger">PTA</label>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-check">
                                                                                <?php if (!empty($record["registration_fee"])) : ?>
                                                                                    <input class="form-check-input" type="checkbox" name="registrationFee" id="registrationFee">
                                                                                    <label class="form-check-label" for="registrationFee">Registration Fee</label>
                                                                                <?php else : ?>
                                                                                    <label class="text-danger"> Registration Fee</label>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <?php if (!empty($record["special_permit"])) : ?>
                                                                                    <input class="form-check-input" type="checkbox" name="specialPermit" id="sspValidIcard">
                                                                                    <label class="form-check-label" for="specialPermit">SSP special study permit</label>
                                                                                <?php else : ?>
                                                                                    <label class="text-danger"> SSP special study permit</label>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <?php if (!empty($record["international_fee_old"])) : ?>
                                                                                    <input class="form-check-input" type="checkbox" name="internationalFeeOld" id="internationalFee">
                                                                                    <label class="form-check-label" for="internationalFee">int'l student fee OLD</label>
                                                                                <?php else : ?>
                                                                                    <label class="text-danger"> int'l student fee OLD</label>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <div class="form-check">
                                                                                <?php if (!empty($record["international_fee_new"])) : ?>
                                                                                    <input class="form-check-input" type="checkbox" name="internationalFeeNew" id="internationalFee">
                                                                                    <label class="form-check-label" for="internationalFee">int'l student fee NEW</label>
                                                                                <?php else : ?>
                                                                                    <label class="text-danger"> int'l student fee NEW</label>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4"></div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" id="notes" name="notes" placeholder="Type notes here" required>
                                                                <input type="hidden" name="stage" id="stage" value="<?php echo $row['status']?>">
                                                                <input type="hidden" name="ern" id="ern" value="<?php echo $row["uniqid"]; ?>">
                                                            </td>
                                                            <td>
                                                                <button type="submit" class="btn btn-success rounded" name="approve" value="approve" onclick="return confirmSubmission()">
                                                                    <span class="icon-holder"><i class="anticon anticon-check"></i></span>
                                                                </button>
                                                                <!-- <button type="submit" class="btn btn-danger rounded" name="downgrade" value="downgrade" onclick="return confirmDowngrade()">
                                                                    <span class="icon-holder"><i class="anticon anticon-minus"></i></span>
                                                                </button> -->
                                                            </td>
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
                        <script>
                            function confirmSubmission() {
                                if (confirm("Are you sure you want to submit?")) {
                                    console.log("Are you sure you want to submit?");
                                    return true;
                                } else {
                                    return false
                                }
                            }
                            function confirmDowngrade() {
                                return confirm('Are you sure you want to downgrade this student\'s status?');
                            }
                        </script>
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