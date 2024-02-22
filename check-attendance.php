<?php
include_once "includes/config.php";
//ini_set('display_errors', 0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}
?><!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>
<?php
$subjects = $DB_con->prepare("SELECT * FROM s_subjects WHERE code = :code");
$subjects->execute(array(":code"=>$_GET["code"]));
$result = $subjects->fetchAll();

foreach($result as $row) {
?>
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
                                    <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-book"></i></span> <?php
                                        $now = date('M d, Y');
                                        echo $row["subjdesc"]." ".$row["subjlevel"]." - ".$_GET["section"]." ( ".$now." )"; ?></h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h3>Male</h3>
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col" style="width: 20%">Name</th>
                                                    <th scope="col" style="width: 25%" colspan="3">Attendance</th>
                                                    <th>History</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        // MALE STUDENTS
                                                        $getstudents = $DB_con->prepare("SELECT * FROM user WHERE position = :position AND grade = :grade AND section = :section AND gender = :gender");
                                                        $getstudents->execute(array(
                                                            ":position"=>"Student",
                                                            ":grade"=>$row["subjlevel"],
                                                            ":section"=>$_GET["section"],
                                                            ":gender"=>"M"
                                                        ));
                                                        $studentdetails = $getstudents->fetchAll();


                                                        foreach($studentdetails as $students) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $students["lname"].", ".$students["fname"]; ?></td>
                                                                    <?php
                                                                     // check if already marked absent
                                                                    $checkabsent = $DB_con->prepare("SELECT * FROM s_classattendance WHERE DATE(adate) = CURDATE() AND subjid = :subjid AND studid = :studid");
                                                                    $checkabsent->execute(array(":subjid"=>$_GET["code"], ":studid"=>$students["username"]));

                                                                    if($checkabsent->rowCount() > 0) {
                                                                        $absentee = $checkabsent->fetchAll();
                                                                        foreach ($absentee as $absent) {
                                                                            if ($absent["attendance"] == 0) {

                                                                                ?>
                                                                                    <td><button type="button" id="absent" class="btn btn-danger btn-lg" disabled><span class="icon-holder"><i class="anticon anticon-stop"></i></span> Absent</button></td>
                                                                                    <td><a class="btn btn-warning btn-lg" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=1" role="button"><span class="icon-holder"><i class="anticon anticon-clock-circle"></i></span> Tardy</a></td>
                                                                                <td>
                                                                                    <div class="dropdown show">
                                                                                        <a class="btn btn-info btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                            <span class="icon-holder"><i class="anticon anticon-issues-close"></i></span>  Excused
                                                                                        </a>

                                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                            <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=3">Clinic</a>
                                                                                            <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=4">PBIS</a>
                                                                                            <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=2">Excused</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <?php
                                                                            } elseif($absent["attendance"] == 1){
                                                                                ?>
                                                                                    <td><a class="btn btn-danger btn-lg" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=0" role="button"><span class="icon-holder"><i class="anticon anticon-stop"></i></span> Absent</a></td>
                                                                                    <td><button type="button" id="tardu" class="btn btn-warning btn-lg" disabled><span class="icon-holder"><i class="anticon anticon-clock-circle"></i></span> Tardy</button></td>
                                                                                <td>
                                                                                    <div class="dropdown show">
                                                                                        <a class="btn btn-info btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                            <span class="icon-holder"><i class="anticon anticon-issues-close"></i></span>  Excused
                                                                                        </a>

                                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                            <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=3">Clinic</a>
                                                                                            <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=4">PBIS</a>
                                                                                            <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=2">Excused</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <?php
                                                                            } elseif($absent["attendance"] >= 2){
                                                                                ?>
                                                                                    <td><a class="btn btn-danger btn-lg" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=0" role="button"><span class="icon-holder"><i class="anticon anticon-stop"></i></span> Absent</a></td>
                                                                                    <td><a class="btn btn-warning btn-lg" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=1" role="button"><span class="icon-holder"><i class="anticon anticon-clock-circle"></i></span> Tardy</a></td>
                                                                                    <td><button type="button" id="excused" class="btn btn-secondary btn-lg" disabled><span class="icon-holder"><i class="anticon anticon-issues-close"></i></span> Excused</button></td>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>

                                                                        <td>
                                                                            <p>
                                                                                <a class="btn btn-primary btn-lg" data-toggle="collapse" href="#<?php echo $students["username"]; ?>" role="button" aria-expanded="false" aria-controls="<?php echo $students["username"]; ?>">
                                                                                    <span class="icon-holder"><i class="anticon anticon-history"></i></span>  Attendance Today
                                                                                </a>
                                                                            </p>
                                                                            <div class="collapse" id="<?php echo $students["username"]; ?>">
                                                                                <div class="card card-body">
                                                                                    <?php
                                                                                        $checkhistory = $DB_con->prepare("SELECT * FROM s_classattendance INNER JOIN s_subjects ON s_classattendance.subjid = s_subjects.code WHERE DATE(s_classattendance.adate) = CURDATE() AND s_classattendance.studid = :studid");
                                                                                        $checkhistory->execute(array(":studid"=>$students["username"]));
                                                                                        $showhistory = $checkhistory->fetchAll();

                                                                                        if($checkhistory->rowCount() > 0) {
                                                                                            foreach($showhistory as $history){
                                                                                                echo $history["subjdesc"]." ".$history["subjlevel"]." - ".$history["notes"]."<br>";
                                                                                            }
                                                                                        } else {
                                                                                            echo "No History";
                                                                                        }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </td>

                                                                        <?php
                                                                    } else {
                                                                        ?>
                                                                        <td><a class="btn btn-danger btn-lg" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=0" role="button"><span class="icon-holder"><i class="anticon anticon-stop"></i></span> Absent</a></td>
                                                                        <td><a class="btn btn-warning btn-lg" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=1" role="button"><span class="icon-holder"><i class="anticon anticon-clock-circle"></i></span> Tardy</a></td>
                                                                        <td>
                                                                            <div class="dropdown show">
                                                                                <a class="btn btn-info btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                    <span class="icon-holder"><i class="anticon anticon-issues-close"></i></span>  Excused
                                                                                </a>

                                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                                    <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=3">Clinic</a>
                                                                                    <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=4">PBIS</a>
                                                                                    <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=2">Excused</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <p>
                                                                                <a class="btn btn-primary btn-lg" data-toggle="collapse" href="#<?php echo $students["username"]; ?>" role="button" aria-expanded="false" aria-controls="<?php echo $students["username"]; ?>">
                                                                                    <span class="icon-holder"><i class="anticon anticon-history"></i></span>  Attendance Today
                                                                                </a>
                                                                            </p>
                                                                            <div class="collapse" id="<?php echo $students["username"]; ?>">
                                                                                <div class="card card-body">
                                                                                    <?php
                                                                                    $checkhistory = $DB_con->prepare("SELECT * FROM s_classattendance INNER JOIN s_subjects ON s_classattendance.subjid = s_subjects.code WHERE DATE(s_classattendance.adate) = CURDATE() AND s_classattendance.studid = :studid");
                                                                                    $checkhistory->execute(array(":studid"=>$students["username"]));
                                                                                    $showhistory = $checkhistory->fetchAll();

                                                                                    if($checkhistory->rowCount() > 0) {
                                                                                        foreach($showhistory as $history){
                                                                                            echo $history["subjdesc"]." ".$history["subjlevel"]." - ".$history["notes"]."<br>";
                                                                                        }
                                                                                    } else {
                                                                                        echo "No History";
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <?php
                                                                    }
                                                        }
                                                       ?>
                                                            </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-12">
                                            <h3>Female</h3>
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col" style="width: 20%">Name</th>
                                                    <th scope="col" style="width: 25%" colspan="3">Attendance</th>
                                                    <th>History</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                // MALE STUDENTS
                                                $getstudents = $DB_con->prepare("SELECT * FROM user WHERE position = :position AND grade = :grade AND section = :section AND gender = :gender");
                                                $getstudents->execute(array(
                                                    ":position"=>"Student",
                                                    ":grade"=>$row["subjlevel"],
                                                    ":section"=>$_GET["section"],
                                                    ":gender"=>"F"
                                                ));
                                                $studentdetails = $getstudents->fetchAll();


                                                foreach($studentdetails as $students) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $students["lname"].", ".$students["fname"]; ?></td>
                                                    <?php
                                                    // check if already marked absent
                                                    $checkabsent = $DB_con->prepare("SELECT * FROM s_classattendance WHERE DATE(adate) = CURDATE() AND subjid = :subjid AND studid = :studid");
                                                    $checkabsent->execute(array(":subjid"=>$_GET["code"], ":studid"=>$students["username"]));

                                                    if($checkabsent->rowCount() > 0) {
                                                        $absentee = $checkabsent->fetchAll();
                                                        foreach ($absentee as $absent) {
                                                            if ($absent["attendance"] == 0) {

                                                                ?>
                                                                <td><button type="button" id="absent" class="btn btn-danger btn-lg" disabled><span class="icon-holder"><i class="anticon anticon-stop"></i></span> Absent</button></td>
                                                                <td><a class="btn btn-warning btn-lg" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=1" role="button"><span class="icon-holder"><i class="anticon anticon-clock-circle"></i></span> Tardy</a></td>
                                                                <td>
                                                                    <div class="dropdown show">
                                                                        <a class="btn btn-info btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="icon-holder"><i class="anticon anticon-issues-close"></i></span>  Excused
                                                                        </a>

                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                            <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=3">Clinic</a>
                                                                            <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=4">PBIS</a>
                                                                            <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=2">Excused</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <?php
                                                            } elseif($absent["attendance"] == 1){
                                                                ?>
                                                                <td><a class="btn btn-danger btn-lg" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=0" role="button"><span class="icon-holder"><i class="anticon anticon-stop"></i></span> Absent</a></td>
                                                                <td><button type="button" id="tardu" class="btn btn-warning btn-lg" disabled><span class="icon-holder"><i class="anticon anticon-clock-circle"></i></span> Tardy</button></td>
                                                                <td>
                                                                    <div class="dropdown show">
                                                                        <a class="btn btn-info btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <span class="icon-holder"><i class="anticon anticon-issues-close"></i></span>  Excused
                                                                        </a>

                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                            <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=3">Clinic</a>
                                                                            <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=4">PBIS</a>
                                                                            <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=2">Excused</a>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <?php
                                                            } elseif($absent["attendance"] >= 2){
                                                                ?>
                                                                <td><a class="btn btn-danger btn-lg" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=0" role="button"><span class="icon-holder"><i class="anticon anticon-stop"></i></span> Absent</a></td>
                                                                <td><a class="btn btn-warning btn-lg" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=1" role="button"><span class="icon-holder"><i class="anticon anticon-clock-circle"></i></span> Tardy</a></td>
                                                                <td><button type="button" id="excused" class="btn btn-secondary btn-lg" disabled><span class="icon-holder"><i class="anticon anticon-issues-close"></i></span> Excused</button></td>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                        <td>
                                                            <p>
                                                                <a class="btn btn-primary btn-lg" data-toggle="collapse" href="#<?php echo $students["username"]; ?>" role="button" aria-expanded="false" aria-controls="<?php echo $students["username"]; ?>">
                                                                    <span class="icon-holder"><i class="anticon anticon-history"></i></span>  Attendance Today
                                                                </a>
                                                            </p>
                                                            <div class="collapse" id="<?php echo $students["username"]; ?>">
                                                                <div class="card card-body">
                                                                    <?php
                                                                    $checkhistory = $DB_con->prepare("SELECT * FROM s_classattendance INNER JOIN s_subjects ON s_classattendance.subjid = s_subjects.code WHERE DATE(s_classattendance.adate) = CURDATE() AND s_classattendance.studid = :studid");
                                                                    $checkhistory->execute(array(":studid"=>$students["username"]));
                                                                    $showhistory = $checkhistory->fetchAll();

                                                                    if($checkhistory->rowCount() > 0) {
                                                                        foreach($showhistory as $history){
                                                                            echo $history["subjdesc"]." ".$history["subjlevel"]." - ".$history["notes"]."<br>";
                                                                        }
                                                                    } else {
                                                                        echo "No History";
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <?php
                                                    } else {
                                                        ?>
                                                        <td><a class="btn btn-danger btn-lg" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=0" role="button"><span class="icon-holder"><i class="anticon anticon-stop"></i></span> Absent</a></td>
                                                        <td><a class="btn btn-warning btn-lg" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=1" role="button"><span class="icon-holder"><i class="anticon anticon-clock-circle"></i></span> Tardy</a></td>
                                                        <td>
                                                            <div class="dropdown show">
                                                                <a class="btn btn-info btn-lg dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <span class="icon-holder"><i class="anticon anticon-issues-close"></i></span>  Excused
                                                                </a>

                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                    <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=3">Clinic</a>
                                                                    <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=4">PBIS</a>
                                                                    <a class="dropdown-item" href="process-absent.php?subjid=<?php echo $row["code"]; ?>&studid=<?php echo $students["username"]; ?>&section=<?php echo $_GET["section"]; ?>&att=2">Excused</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <p>
                                                                <a class="btn btn-primary btn-lg" data-toggle="collapse" href="#<?php echo $students["username"]; ?>" role="button" aria-expanded="false" aria-controls="<?php echo $students["username"]; ?>">
                                                                    <span class="icon-holder"><i class="anticon anticon-history"></i></span>  Attendance Today
                                                                </a>
                                                            </p>
                                                            <div class="collapse" id="<?php echo $students["username"]; ?>">
                                                                <div class="card card-body">
                                                                    <?php
                                                                    $checkhistory = $DB_con->prepare("SELECT * FROM s_classattendance INNER JOIN s_subjects ON s_classattendance.subjid = s_subjects.code WHERE DATE(s_classattendance.adate) = CURDATE() AND s_classattendance.studid = :studid");
                                                                    $checkhistory->execute(array(":studid"=>$students["username"]));
                                                                    $showhistory = $checkhistory->fetchAll();

                                                                    if($checkhistory->rowCount() > 0) {
                                                                        foreach($showhistory as $history){
                                                                            echo $history["subjdesc"]." ".$history["subjlevel"]." - ".$history["notes"]."<br>";
                                                                        }
                                                                    } else {
                                                                        echo "No History";
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <?php
                                                    }
                                                    }
                                                    ?>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
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
    <?php
}
?>

</body>

</html>