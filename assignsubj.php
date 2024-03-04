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
                                        Subject Assignment
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

                                    <table id="datatabel" class="table display" style="width:100%!important;">
                                        <thead>
                                            <tr>
                                                <th scope="col">Subject Code</th>
                                                <th scope="col">Grade</th>
                                                <th scope="col">Section</th>
                                                <th scope="col">Subject</th>
                                                <th scope="col">Teacher</th>
                                                <th scope="col">WW</th>
                                                <th scope="col">PT</th>
                                                <th scope="col">QE</th>
                                                <th scope="col">Assigned By</th>
                                                <th scope="col">Reassign</th>
                                                <th scope="col">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $pdo_statement = $DB_con->prepare("SELECT * FROM s_subjects INNER JOIN user ON s_subjects.tid = user.username ORDER BY code ASC");
                                            $pdo_statement->execute();
                                            $result = $pdo_statement->fetchAll();
                                            foreach ($result as $row) {
                                            ?>
                                                <tr>
                                                    <form>
                                                        <th scope="row"><?php echo $row["code"]; ?></th>
                                                        <td><?php echo $row["subjlevel"]; ?></td>
                                                        <td><?php echo $row["subjsection"]; ?></td>
                                                        <td><?php echo $row["subjdesc"]; ?></td>
                                                        <td><?php echo $row["fname"] . " " . $row["lname"]; ?></td>
                                                        <td><?php echo $row["percentww"]; ?></td>
                                                        <td><?php echo $row["percentpt"]; ?></td>
                                                        <td><?php echo $row["percentqt"]; ?></td>
                                                        <td><?php echo $row["assignedby"]; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($_SESSION['level'] == 9 or $_SESSION['level'] == 2 or $_SESSION['level'] == 4) {
                                                            ?>
                                                                <select class="form-control form-select" aria-label="Reassign">
                                                                    <option selected>Select</option>
                                                                    <?php
                                                                    $teacher = $DB_con->prepare("SELECT * FROM user WHERE position LIKE '%Teacher%' ORDER BY lname ASC");
                                                                    $teacher->execute();
                                                                    $tresult = $teacher->fetchAll();
                                                                    foreach ($tresult as $trow) {
                                                                        echo "<option value=\"" . $trow["rfid"] . "\">" . $trow["lname"] . ", " . $trow["fname"] . "</option>";
                                                                    }
                                                                    ?>
                                                                </select>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><a href="edit-subject.php?id=<?php echo $row['code']; ?>" type="button" class="btn btn-primary rounded"><span class="icon-holder"><i class="anticon anticon-check"></i></span></a></td>
                                                    </form>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>

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
<script>
    new DataTable('#datatabel', {});
</script>

</html>