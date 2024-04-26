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
                                        Class List - <?php echo $_POST["gradelevel"]." - ".$_POST["section"]; ?>
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
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="export.php" method="post" name="upload_excel" enctype="multipart/form-data">
                                                        <input type="hidden" name="gradelevel" value="<?php echo $_POST["gradelevel"]; ?>">
                                                        <input type="hidden" name="section" value="<?php echo $_POST["section"]; ?>">
                                                    <button type="submit" name="Export" class="btn btn-primary float-right">
                                                        Export
                                                    </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Last Name</th>
                                                    <th scope="col">First Name</th>
                                                    <th scope="col">Middle Name</th>
                                                    <th scope="col">Date of Birth</th>
                                                    <th scope="col">Gender</th>
                                                    <th scope="col">LRN</th>
                                                    <th scope="col">Previous School</th>
                                                    <th scope="col">Nationality</th>
                                                    <th scope="col">House</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $pdo_statement = $DB_con->prepare("SELECT * FROM users24 WHERE grade = :grade AND section = :section ORDER BY gender DESC, lname ASC");
                                                $pdo_statement->execute(array(":grade"=>$_POST["gradelevel"], ":section"=>$_POST["section"]));
                                                $result = $pdo_statement->fetchAll();
                                                foreach ($result as $row) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row["lname"]; ?></td>
                                                        <td><?php echo $row["fname"]; ?></td>
                                                        <td><?php echo $row["mname"]; ?></td>
                                                        <td><?php echo date("F j, Y", strtotime($row["dob"])); ?></td>
                                                        <td><?php echo $row["gender"]; ?></td>
                                                        <td><?php echo $row["lrn"]; ?></td>
                                                        <td><?php echo $row["prevsch"]; ?></td>
                                                        <td><?php echo $row["nationality"]; ?></td>
                                                        <td><?php echo $row["house"]; ?></td>
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