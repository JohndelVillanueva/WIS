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
                            try {
                                    $sid = $_POST['sid'];
                                    $qtr = $_POST['qtr'];
                                    $subjid = $_POST['subjid'];
                                    $independence = $_POST['independence'];
                                    $confidence = $_POST['confidence'];
                                    $respect = $_POST['respect'];
                                    $empathy = $_POST['empathy'];
                                    $appreciation = $_POST['appreciation'];
                                    $tolerance = $_POST['tolerance'];
                                    $enthusiasm = $_POST['enthusiasm'];
                                    $conduct = $_POST['conduct'];
    
                                    for ($i = 0; $i < count($independence); $i++) {
                                        $insertToStudentCV = $DB_con->prepare("INSERT INTO s_studentcv (sid, tid, subjid, qtr, independence, confidence, respect, empathy, appreciation, tolerance, enthusiasm, conduct) 
                                        VALUES (:sid, :tid, :subjid, :qtr,  :independence, :confidence, :respect, :empathy, :appreciation, :tolerance, :enthusiasm, :conduct)
                                    ");
                                        $insertToStudentCV->execute(array(
                                            ":sid" => $sid[$i],
                                            ":tid" => $_SESSION['empno'],
                                            ":subjid" => $subjid[$i],
                                            ":qtr" => $qtr[$i],
                                            ":independence" => $independence[$i],
                                            ":confidence" => $confidence[$i],
                                            ":respect" =>  $respect[$i],
                                            ":empathy" => $empathy[$i],
                                            ":appreciation" => $appreciation[$i],
                                            ":tolerance" => $tolerance[$i],
                                            ":enthusiasm" => $enthusiasm[$i],
                                            ":conduct" => $conduct[$i]
                                        ));
                                    }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                           
                            ?>
                        </div>
                    </div>
                    <script>
                        // window.location.replace("teacher.php");
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