<?php
include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

function transmuteGrade($sql, $params = array())
{
    global $DB_con;
    $stmt = $DB_con->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchColumn();
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
                                    <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-book"></i></span> Core Values - <?php echo $_GET["grade"] . " (" . $_GET["section"] . ") - Quarter " . $_GET["qtr"]; ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="float-right">
                                        <a class="btn btn-primary btn-tone btn-rounded" href="add-corevalues.php?qtr=<?php echo $_GET["qtr"] ?>&grade=<?php echo $_GET["grade"]; ?>&section=<?php echo $_GET["section"]; ?>&code=<?php echo $_GET["code"]; ?>"><i class="anticon anticon-diff"></i> Add Core Values</a><br><br>
                                    </div>
                                    <table class="table table-hover table-bordered table-condensed">
                                        <tr>
                                            <th>Student Name</th>
                                            <?php

                                            $corevalues = $DB_con->prepare("SELECT * FROM s_corevalues");
                                            $corevalues->execute();
                                            $result = $corevalues->fetchAll();

                                            foreach ($result as $row) {
                                                echo "<th class='text-center'>" . $row["corevalue"] . "</th>";
                                            }
                                            ?>
                                        </tr>
                                        <tr>
                                            <td colspan="9" class="alert-warning">MALE</td>
                                        </tr>
                                        <?php
                                        $studentM = $DB_con->prepare("SELECT * FROM user WHERE grade = :grade AND section = :section AND gender = 'M' ORDER by lname ASC");
                                        $studentM->execute(array(":grade" => $_GET["grade"], ":section" => $_GET["section"]));
                                        $studentsM = $studentM->fetchAll();

                                        foreach ($studentsM as $studM) {
                                        ?>
                                            <tr>
                                                <td><?php echo $studM["lname"] . ", " . $studM["fname"] . " " . $studM["mname"]; ?></td>
                                                <?php

                                                $coregrade = $DB_con->prepare("SELECT * FROM s_studentcv WHERE sid = :sid and tid = :tid AND qtr = :qtr AND subjid = :subjid");
                                                $coregrade->execute(array(":sid" => $studM["username"], ":tid" => $_SESSION["empno"], ":qtr" => $_GET["qtr"], ":subjid" => $_GET['code'] ));
                                                $coregrades = $coregrade->fetchAll();

                                                foreach ($coregrades as $cv) {

                                                    foreach (["independence", "confidence", "respect", "empathy", "appreciation", "tolerance", "enthusiasm", "conduct"] as $q)

                                                        echo "<td class='text-center font-weight-bold alert-primary font-size-16'>" . transmuteGrade("SELECT grade FROM s_coretable WHERE ? BETWEEN start AND end", array($cv[$q])) . "<br><span class='small'>(" . $cv[$q] . ")</span></td>";
                                                }
                                                ?>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <td colspan="9" class="alert-warning">FEMALE</td>
                                        </tr>
                                        <?php
                                        $studentF = $DB_con->prepare("SELECT * FROM user WHERE grade = :grade AND section = :section AND gender = 'F' ORDER by lname ASC");
                                        $studentF->execute(array(":grade" => $_GET["grade"], ":section" => $_GET["section"]));
                                        $studentsF = $studentF->fetchAll();

                                        foreach ($studentsF as $studF) {
                                        ?>
                                            <tr>
                                                <td><?php echo $studF["lname"] . ", " . $studF["fname"] . " " . $studF["mname"]; ?></td>

                                            <?php
                                            $coregrades = $DB_con->prepare("SELECT * FROM s_studentcv WHERE sid = :sid and tid = :tid AND qtr = :qtr AND subjid = :subjid");
                                            $coregrades->execute(array(":sid" => $studM["username"], ":tid" => $_SESSION["empno"], ":qtr" => $_GET["qtr"], ":subjid" => $_GET['code']));
                                            $cgrades = $coregrades->fetchAll();

                                            foreach ($cgrades as $cvg) {

                                                foreach (["independence", "confidence", "respect", "empathy", "appreciation", "tolerance", "enthusiasm", "conduct"] as $q)
                                                    echo "<td class='text-center font-weight-bold alert-primary font-size-16'>" .transmuteGrade("SELECT grade FROM s_coretable WHERE ? BETWEEN start AND end", array($cvg[$q])) . "<br><span class='small'>(" . $cvg[$q] . ")
                                                </span></td>";
                                            }
                                            ?>
                                            </tr>
                                        <?php
                                        }
                                        ?>

                                           
                                    </table>
                                </div>
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