<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}

?><!DOCTYPE html>
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
                                        New Student Application - Pending Documents
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if(isset($_GET['ern'])){
                                        ?>
                                        <div class="row" id="alertmsg">
                                            <div class="col-lg-12">
                                                <div class="alert alert-success" role="alert">
                                                    Successfully processed ERN <?php echo $_GET['ern'];?>
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
                                                <th scope="col">Gender</th>
                                                <th scope="col">Previous School</th>
                                                <!-- <th scope="col">LRN</th> -->
                                                <th scope="col">Notes</th>
                                                <th scope="col">Completed</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                        <?php
                                            $pdo_statement = $DB_con->prepare("SELECT * FROM users24 WHERE status = 1 ORDER BY id");
                                            $pdo_statement->execute();
                                            $result = $pdo_statement->fetchAll();
                                            foreach($result as $row) {
                                            ?>
                                                <tr>
                                                    <form id="myForm" method="post" action="process.php">
                                                        <th scope="row">
                                                            <div class="col-lg-6">
                                                            <p><a class="btn btn-primary" data-toggle="collapse" href="#collapseExample<?php echo $row['uniqid'];?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $row['uniqid'];?>"><?php echo $row["uniqid"];?></a></p>
                                                            <?php
                                                            $logs = $DB_con->prepare("SELECT * FROM logs_enroll WHERE ern = :ern");
                                                            $logs->execute(array( ':ern'=>$row['uniqid']));
                                                            $logsresult = $logs->fetchAll();
                                                            foreach($logsresult as $log) {
                                                                    include "log.php";
                                                                }
                                                            ?>
                                                            </div>
                                                        </th>
                                                        <td><?php echo $row["lname"].", ".$row["fname"]." ".$row["mname"];?></td>
                                                        <td><?php echo $row["gender"];?></td>
                                                        <td><?php echo $row["prevsch"];?></td>
                                                        <!-- <td><?php echo $row["lrn"];?></td> -->
                                                        <td>
                                                            <input class="form-control" type="text" id="notes" name="notes" placeholder="Type notes here" required>
                                                            <input type="hidden" name="stage" id="stage" value="2">
                                                            <input type="hidden" name="ern" id="ern" value="<?php echo $row["uniqid"];?>">
                                                        </td>
                                                        <td><button type="submit" class="btn btn-success rounded" onclick="return confirmSubmission()"><span class="icon-holder"><i class="anticon anticon-check"></i></span></button></td>
                                                    </form>
                                                </tr>
                                        <?php
                                        }
                                        ?>
                                                    </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php 

                                ?>
                                <div class="card-footer bg-light text-center"></div>
                            </div>
                        </div>
                    </div>
                    <script>
                        function confirmSubmission(){
                            if(confirm("Are you sure you want to submit?")){
                                return true;
                            }else {
                                return false;
                            }
                        }
                    </script>
                <!-- form ends !-->
            </div>
        <?php include_once "includes/footer.php"; ?>
        </div>
    <?php include_once "includes/scripts.php";?>
</div>
</div>
</body>

</html>