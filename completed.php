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
                                        New Students - Officially Enrolled
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
                                                <th scope="col">Date of Birth</th>
                                                <th scope="col">LRN</th>
                                                <th scope="col">Profile</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                        <?php
                                            $pdo_statement = $DB_con->prepare("SELECT * FROM user WHERE status = 8");
                                            $pdo_statement->execute();
                                            $result = $pdo_statement->fetchAll();
                                            foreach($result as $row) {
                                            ?>
                                                <tr>
                                                    <form>
                                                        <th scope="row">
                                                            <div class="col-lg-12">
                                                            <p><a class="btn btn-primary" data-toggle="collapse" href="#collapseExample<?php echo $row['uniqid'];?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $row['uniqid'];?>"><?php echo $row["uniqid"];?></a></p>
                                                            <?php
                                                            $logs = $DB_con->prepare("SELECT * FROM logs_enroll WHERE ern = :ern");
                                                            $logs->execute(array( ':ern'=>$row['uniqid']));
                                                            $logsresult = $logs->fetchAll();
                                                            foreach($logsresult as $log) {
                                                                ?>
                                                                <div class="collapse" id="collapseExample<?php echo $row['uniqid'];?>">
                                                                    <div class="card card-body">
                                                                        <?php echo $log['notes']." (".$log['usertouch']."@".$log['touch'].")"; ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                            ?>
                                                            </div>
                                                        </th>
                                                        <td><?php echo $row["lname"].", ".$row["fname"]." ".$row["mname"];?></td>
                                                        <td><?php echo $row["gender"];?></td>
                                                        <td><?php echo date("F j, Y",strtotime($row["dob"]));?></td>
                                                        <td><?php echo $row["lrn"];?></td>
                                                        <td>
                                                            <a type="button" href="profile.php?id=<?php echo $row["id"];?>" class="btn btn-success rounded"><span class="icon-holder"><i class="anticon anticon-eye"></i></span></a>
															<?php
																if($_SESSION['level'] == 9 OR $_SESSION['level'] == 2 OR $_SESSION['level'] == 4){
															?>
																 <a href="edit-profile.php?id=<?php echo $row['id'];?>" type="button" class="btn btn-primary rounded"><span class="icon-holder"><i class="anticon anticon-edit"></i></span></a>
															<?php
																}															
															?>
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