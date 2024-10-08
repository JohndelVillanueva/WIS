<?php
include_once "includes/config.php";
//ini_set('display_errors', 0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>

<form>

    <div class="app is-folded">
        <div class="layout">
            <?php include_once "includes/heading.php"; ?>
            <?php include_once "includes/sidemenu.php"; ?>
            <div class="page-container">
                <div class="main-content">
                    <!-- form starts !-->
                    <div class="row flex-nowrap overflow-auto">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-warning">
                                    <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-book"></i></span></h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                    $s_subjects = $DB_con->prepare("SELECT * FROM s_subjects WHERE code = :code");
                                    $s_subjects->execute(array(":code" => $_GET["code"]));
                                    $subject = $s_subjects->fetchAll();
                                    
                                    foreach ($subject as $subjrow) {
                                        $s_students = $DB_con->prepare("SELECT * FROM user WHERE grade = :grade AND section = :section");
                                        $s_students->execute(array(":grade" => $subjrow["subjlevel"], ":section" => $_GET["section"]));
                                        $students = $s_students->fetchAll();
                                        
                                        foreach ($students as $studrow) {
                                            $motherTableQuery = $DB_con->prepare("UPDATE s_activities SET flag = 1 WHERE subjcode = :subjcode AND actsection = :section AND actlvl = :grade AND actqtr = :qtr ");
                                            $mother = $motherTableQuery->execute([
                                                ":subjcode" => $_GET['code'],
                                                ":section" => $_GET['section'],
                                                ":grade" => $subjrow["subjlevel"],
                                                ":qtr" => $_GET['qtr']
                                            ]);
                                            
                                            $update = $DB_con->prepare("UPDATE s_scores SET flag = 1 WHERE sid = :username AND subjcode = :subjcode AND qtr = :qtr");
                                            $child = $update->execute(array(":username" => $studrow["username"], ":subjcode" => $_GET['code'], ":qtr" => $_GET['qtr']));
                                    
                                            if (!$mother || !$child) {
                                                // Log or handle query execution errors
                                                echo "Error executing queries!";
                                                exit;
                                            }
                                        }
                                        
                                        $insertQueryForVerification = $DB_con->prepare("INSERT INTO s_verifications (user_id,section,grade,flag,created_at,subject,request_unlock,subjcode) VALUES (:user_id,:section,:grade,:flag,:created_at,:subject,:request_unlock,:subjcode)");
                                        $insertQueryForVerification->execute([
                                            ":user_id" => $_SESSION['fname'] . " " . $_SESSION['lname'],
                                            ":section" => $_GET['section'],
                                            ":grade" => $_GET['grade'],
                                            ":flag" => 1,
                                            ":created_at" => date('Y-m-d H:i:s'),
                                            ":subject" => $_GET['subjdesc'],
                                            ":request_unlock" => 1,
                                            ":subjcode" => $_GET['code']
                                        ]);
                                    
                                        // var_dump(["motherTable" => $motherTableQuery, "child" => $update]);
                                        // die();
                                    }
                                    
                                    ?>
                                    <script>
                                        window.location.replace("show-students.php?code=<?php echo $_GET["code"]; ?>&section=<?php echo $_GET["section"]; ?>&subjdesc=<?php echo $_GET["subjdesc"]; ?>&qtr=<?php echo $_GET["qtr"]; ?>&grade=<?php echo $_GET["grade"]; ?>");
                                    </script>
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
    </div>

    </body>

</html>