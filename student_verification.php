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
                                        Student Verification - Pending Student Grade
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
                                                    <th scope="col">Grade</th>
                                                    <th scope="col">Section</th>
                                                    <th scope="col">Subject</th>
                                                    <th scope="col">Teacher</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $verifyInformationQuery = $DB_con->prepare("SELECT * FROM s_activities 
                                                WHERE flag = 1 ORDER BY id");
                                                $verifyInformationQuery->execute();
                                                $informations = $verifyInformationQuery->fetchAll(PDO::FETCH_OBJ);
                                                foreach ($informations as $information) {
                                                ?>
                                                    <tr>
                                                        <td><?= $information->actlvl ?></td>
                                                        <td><?= $information->actsection ?></td>
                                                        <td><?= $information->subjcode ?></td>
                                                        <td><?= $information->actcreate ?></td>
                                                        <td><a href="https://example.com" class="btn btn-primary">
                                                        <i class="fas fa-eye"></i>
                                                        </a></td>

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
            <?php include_once "includes/scripts.php"; ?>
        </div>
    </div>
</body>

</html>