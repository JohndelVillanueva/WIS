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
                                <form method="post" action="process-cv.php" id="processgrades">
                                    <div class="card-header bg-warning">
                                        <h4 class="pt-2"><span class="icon-holder"><i class="anticon anticon-diff"></i></span> Core Values - <?php echo $_GET["grade"] . " - " . $_GET["section"] . " Quarter " . $_GET["qtr"]; ?></h4>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $corevalues = $DB_con->prepare("SELECT * FROM s_subjects SS
                                        WHERE code = :code");
                                        $corevalues->execute(array(":code" => $_GET["code"]));
                                        $result = $corevalues->fetchAll();

                                        foreach ($result as $row) {
                                            $getstudents = $DB_con->prepare("SELECT * FROM user WHERE section = :section ORDER BY lname ASC");
                                            $getstudents->execute(array(":section" => $_GET["section"]));
                                            $studres = $getstudents->fetchAll();

                                            if ($getstudents->errorInfo()[0] != "00000") {
                                                var_dump($getstudents->errorInfo());
                                            }
                                        ?>
                                            <table class="table table-hover ">
                                                <thead>
                                                    <tr>
                                                        <th>Student Name</th>
                                                        <th>Quarter</th>
                                                        <th>Independence</th>
                                                        <th>confidence</th>
                                                        <th>Respect</th>
                                                        <th>Empathy</th>
                                                        <th>Appreciation</th>
                                                        <th>Tolerance</th>
                                                        <th>Enthusiasm</th>
                                                        <th>Conduct</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($studres as $studrow) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $studrow["lname"] . ", " . $studrow["fname"] . " " . $studrow["mname"]; ?></td>
                                                            <td><input type="hidden"> <?= $_GET["qtr"] ?> </td>
                                                            <td><input type="number" class="form-control" name="independence[]" max="4"></td>
                                                            <td><input type="number" class="form-control" name="confidence[]" max="4"></td>
                                                            <td><input type="number" class="form-control" name="respect[]" max="4"></td>
                                                            <td><input type="number" class="form-control" name="empathy[]" max="4"></td>
                                                            <td><input type="number" class="form-control" name="appreciation[]" max="4"></td>
                                                            <td><input type="number" class="form-control" name="tolerance[]" max="4"></td>
                                                            <td><input type="number" class="form-control" name="enthusiasm[]" max="4"></td>
                                                            <td><input type="number" class="form-control" name="conduct[]" max="4"></td>
                                                            <input type="hidden" name="sid[]" value="<?= $studrow["username"]; ?>">
                                                            <input type="hidden" name="subjid[]" value="<?= $row["code"]; ?>">
                                                            <input type="hidden" name="qtr[]" value="<?= $_GET["qtr"]; ?>">
                                                            
                                                        </tr>
                                                <?php
                                                    } // second foreach
                                                } // first foreach
                                                ?>
                                                </tbody>
                                            </table>
                                            <p class="lead text-center">
                                                “Always go with your passions. Never ask yourself if it's realistic or not.” <br>
                                            <p class="text-center"><em>- Westfields International School</em></p>
                                            </p>
                                    </div>
                                    <div class="card-footer text-center"><button class="btn btn-success btn-block" type="submit">Register Core Values</button> </div>
                                </form>
                            </div>
                            <script>
                            </script>
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