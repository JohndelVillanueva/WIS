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
                            <?php
                            $scorearray = $_POST['score'];
                            $acttypearray = $_POST['acttype'];
                            $actidarray = $_POST['actid'];
                            $subjcodearray = $_POST['subjcode'];
                            $sidarray = $_POST['sid'];
                            $maxscorearray = $_POST['maxscore'];
                            $qtr = $_POST['qtr'];

                            for ($i = 0; $i < count($scorearray); $i++) {
                                $insertscore = $DB_con->prepare("INSERT INTO s_scores (subjcode, actid, acttype, sid, score, maxscore, qtr) VALUES (:subjcode, :actid, :acttype, :sid, :score, :maxscore, :qtr)");
                                $insertscore->execute(array(
                                    ":subjcode" => $subjcodearray[$i],
                                    ":actid" => $actidarray[$i],
                                    ":acttype" => $acttypearray[$i],
                                    ":sid" => $sidarray[$i],
                                    ":score" => $scorearray[$i],
                                    ":maxscore" => $maxscorearray[$i],
                                    ":qtr" => $qtr[$i]
                                ));
                            }
                            ?>
                        </div>
                    </div>
                    <script>
                        window.location.replace("teacher.php");
                    </script>
                    <!-- form ends !-->
                </div>
                <?php include_once "includes/footer.php"; ?>
            </div>
            <?php include_once "includes/scripts.php"; ?>

        </div>
    </div>
</body>

</html>