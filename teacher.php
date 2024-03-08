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
<style>
    .dropdown-item {
        transition: 0.4s !important;
    }

    .dropdown-item:hover {
        color: #000 !important;
        background-color: #ffcc00 !important;
        text-decoration: none !important;
    }
</style>

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
                                <div class="card-header bg-warning pt-2">
                                    <h3>
                                        <span class="icon-holder">
                                            <i class="anticon anticon-book"></i>
                                        </span>
                                        Classes Handled - <?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?>
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php
                                        $subjects = $DB_con->prepare("SELECT * FROM user 
                                        LEFT JOIN s_subjects ON user.empno = s_subjects.tid 
                                        WHERE empno = :empno");
                                        $subjects->execute(array(":empno" => $_SESSION["empno"]));
                                        $result = $subjects->fetchAll();
                                        $count = count($result); // Count the number of rows fetched

                                        // Check if any rows were fetched before performing the division
                                        if ($count > 0) {
                                            $cols = 12 / $count;
                                        } else {
                                            // Handle the case where no rows were fetched
                                            // For example, you can set $cols to 12 or any other default value
                                            $cols = 12;
                                        }

                                        foreach ($result as $row) {
                                        ?>
                                            <div class="col-2 col-lg-<?php echo $cols; ?> col-lg-2">
                                                <div class="card">
                                                    <div class="card-body alert-warning">
                                                        <div class="align-items-center text-center">
                                                            <div>
                                                                <h3 class="m-b-0"><?php echo $row["subjdesc"] . " " . $row["subjlevel"]; ?></h3>
                                                                <h2 class="m-b-0">
                                                                    <?php
                                                                    $sections = $DB_con->prepare("SELECT DISTINCT section FROM user WHERE grade = :grade");
                                                                    $sections->execute(array(":grade" => $row["subjlevel"]));
                                                                    $section = $sections->fetchAll();

                                                                    foreach ($section as $sec) {
                                                                    ?>
                                                                        <p><?= $sec['section'] ?></p>
                                                                        <div class="dropdown show">
                                                                            <a class="btn btn-secondary btn-block dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                Quarterly Grades
                                                                            </a>

                                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                                            <a href="show-students.php?grade=<?php echo $row["subjlevel"] . "&section=" . $sec["section"] . "&code=" . $row["code"] . "&qtr=1" . "&subjdesc=". $row['subjdesc']; ?>" class="dropdown-item">
                                                                                    First Quarter
                                                                                </a>
                                                                                <a href="show-students.php?grade=<?php echo $row["subjlevel"] . "&section=" . $sec["section"] . "&code=" . $row["code"] . "&qtr=2" . "&subjdesc=". $row['subjdesc']; ?>" class="dropdown-item">
                                                                                    Second Quarter
                                                                                </a>
                                                                                <a href="show-students.php?grade=<?php echo $row["subjlevel"] . "&section=" . $sec["section"] . "&code=" . $row["code"] . "&qtr=3" . "&subjdesc=". $row['subjdesc']; ?>" class="dropdown-item">
                                                                                    Third Quarter
                                                                                </a>
                                                                                <a href="show-students.php?grade=<?php echo $row["subjlevel"] . "&section=" . $sec["section"] . "&code=" . $row["code"] . "&qtr=4" . "&subjdesc=". $row['subjdesc']; ?>" class="dropdown-item">
                                                                                    Fourth Quarter
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="dropdown show">
                                                                            <a class="btn btn-success btn-block dropdown-toggle" href="#" role="button" id="coreValues" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                                Core Values
                                                                            </a>

                                                                            <div class="dropdown-menu" aria-labelledby="coreValues">
                                                                            <a href="show-studentscv.php?grade=<?php echo $row["subjlevel"] . "&section=" . $sec["section"] . "&code=" . $row["code"] . "&qtr=1" . "&subjdesc=". $_SESSION['subjdesc']; ?>" class="dropdown-item">
                                                                                    First Quarter
                                                                                </a>
                                                                                <a href="show-studentscv.php?grade=<?php echo $row["subjlevel"] . "&section=" . $sec["section"] . "&code=" . $row["code"] . "&qtr=2" . "&subjdesc=". $_SESSION['subjdesc']; ?>" class="dropdown-item">
                                                                                    Second Quarter
                                                                                </a>
                                                                                <a href="show-studentscv.php?grade=<?php echo $row["subjlevel"] . "&section=" . $sec["section"] . "&code=" . $row["code"] . "&qtr=3" . "&subjdesc=". $_SESSION['subjdesc']; ?>" class="dropdown-item">
                                                                                    Third Quarter
                                                                                </a>
                                                                                <a href="show-studentscv.php?grade=<?php echo $row["subjlevel"] . "&section=" . $sec["section"] . "&code=" . $row["code"] . "&qtr=4" . "&subjdesc=". $_SESSION['subjdesc']; ?>" class="dropdown-item">
                                                                                    Fourth Quarter
                                                                                </a>
                                                                            </div>
                                                                        </div>

                                                                        <div class="pt-2">
                                                                            <a href="check-attendance.php?code=<?php echo $row["code"] . "&section=" . $sec["section"]; ?>" class="btn btn-primary btn-block text-sm">
                                                                                Today's Attendance
                                                                            </a><br>
                                                                        </div>
                                                                    <?php } ?>
                                                                </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="card">
                                        <div class="card-body text-center fs-1">
                                                <p>“You have to believe in yourself when no one else does.”</p>
                                                <footer class="blockquote-footer">Westfields International <cite title="Source Title"> School</cite></footer>
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
            <?php include_once "includes/scripts.php"; ?>
        </div>
    </div>
</body>

</html>