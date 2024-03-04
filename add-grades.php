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
                                <form method="post" action="process-grades.php" id="processgrades">
                                    <div class="card-header bg-warning">
                                        <h4 class="pt-2"><span class="icon-holder"><i class="anticon anticon-diff"></i></span> Add Scores - <?php echo $_GET["subjcode"]; ?></h4>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        $subjects = $DB_con->prepare("SELECT * FROM s_activities WHERE actid = :actid");
                                        $subjects->execute(array(":actid" => $_GET["actid"]));
                                        $result = $subjects->fetchAll();

                                        foreach ($result as $row) {
                                            // code here
                                            $getstudents = $DB_con->prepare("SELECT * FROM user WHERE section = :section ORDER BY lname ASC");
                                            $getstudents->execute(array(":section" => $_GET["section"]));
                                            $studres = $getstudents->fetchAll();

                                            if ($getstudents->errorInfo()[0] != "00000") {
                                                var_dump($getstudents->errorInfo());
                                            }


                                        ?>
                                            <table class="table table-hover ">
                                                <thead>
                                                    <tr class="alert-warning">
                                                        <th>Student Name</th>
                                                        <th>Grade / Section</th>
                                                        <th>Activity</th>
                                                        <th>Score</th>
                                                        <th>Max Score</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    foreach ($studres as $studrow) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $studrow["lname"] . ", " . $studrow["fname"] . " " . $studrow["mname"]; ?></td>
                                                            <td><?php echo $studrow["grade"] . " " . $studrow["section"]; ?></td>
                                                            <td><?php echo $row["actdesc"]; ?></td>
                                                            <td><input type="number" class="form-control" name="score[]" required placeholder="Insert Score of <?php echo $studrow["lname"] . ", " . $studrow["fname"] . " " . $studrow["mname"]; ?>" max="<?php echo $row["maxscore"]; ?>"></td>
                                                            <td id="<?php echo $row["maxscore"]; ?>"><?php echo $row["maxscore"]; ?></td>
                                                        </tr>
                                                        <input type="hidden" name="acttype[]" value="<?php echo $_GET['acttype']; ?>">
                                                        <input type="hidden" name="actid[]" value="<?php echo $_GET["actid"]; ?>">
                                                        <input type="hidden" name="subjcode[]" value="<?php echo $_GET["subjcode"]; ?>">
                                                        <input type="hidden" name="section[]" value="<?php echo $_GET["section"]; ?>">
                                                        <input type="hidden" name="sid[]" value="<?php echo $studrow["username"]; ?>">
                                                        <input type="hidden" name="maxscore[]" value="<?php echo $row["maxscore"]; ?>">



                                                    <?php


                                                    }
                                                    ?>



                                                <?php
                                            }
                                                ?>

                                                </tbody>
                                            </table>

                                    </div>
                                    <div class="card-footer text-center"><button class="btn btn-success btn-block" type="submit">Commit Changes</button> </div>
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