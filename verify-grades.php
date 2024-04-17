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
                                            $update = $DB_con->prepare("UPDATE s_scores SET flag = 1 WHERE sid = :username");
                                            $update->execute(array(":username" => $studrow["username"]));
                                        }
                                    }
                                    $insertQueryForVerification = $DB_con->prepare("INSERT INTO s_verifications (user_id,section,grade,flag,created_at) VALUES (:user_id,:section,:grade,:flag,:created_at)");
                                    $insertQueryForVerification->execute([
                                        ":user_id" => $_SESSION['fname'] . " " . $_SESSION['lname'],
                                        ":section" => $_GET['section'],
                                        ":grade" => $_GET['grade'],
                                        ":flag" => 1,
                                        ":created_at" => date('Y-m-d H:i:s')
                                    ])
                                    ?>
                                    <script>
                                        window.location.replace("show-students.php?code=<?php echo $_GET["code"]; ?>&section=<?php echo $_GET["section"]; ?>&subjdesc=<?php echo $_GET["subjdesc"]; ?>&qtr=<?php echo $_GET["qtr"]; ?>&grade=<?php echo $_GET["grade"]; ?>&lock=1");
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