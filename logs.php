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
                                        Processing of all Student not enrolled
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <!-- <div class="row">
                                        <div class="col-lg-12">
                                            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#classList">
                                                Class List
                                            </button>
                                        </div>
                                    </div> -->
                                    <div class="row ">
                                        <div class="col-lg-12">
                                            <table id="userlist" class="display table table-stripped table-fluid">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Reference Number</th>
                                                        <th scope="col">Full Name</th>
                                                        <th scope="col">Gender</th>
                                                        <th scope="col">Date of Birth</th>
                                                        <th scope="col">Grade</th>
                                                        <th scope="col">Section</th>
                                                        <th scope="col">House</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $pdo_statement = $DB_con->prepare("SELECT * FROM users24 WHERE position = :position AND status != :status ORDER BY `id` DESC");
                                                    $pdo_statement->execute([":position" => "Student", ":status" => 8]);
                                                    $result = $pdo_statement->fetchAll();
                                                    foreach ($result as $row) {
                                                        if ($row["isofficial"] == 0) {
                                                            $style = "bg-dangerous";
                                                        } else {
                                                            $style = "bg-complete";
                                                        }
                                                    ?>
                                                        <tr class="<?php echo $style; ?>">
                                                            <form>
                                                                <th scope="row">
                                                                    <div class="col-lg-12">
                                                                        <p><a class="btn btn-primary" data-toggle="collapse" href="#collapseExample<?php echo $row['uniqid']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $row['uniqid']; ?>"><?php echo $row["uniqid"]; ?></a> 
                                                                        <?= " " . $status = $row['status']. "/9 ";
                                                                            switch ($row['status']) {
                                                                                case 1:
                                                                                    echo "Verification";
                                                                                    break;
                                                                                case 2:
                                                                                    echo "Application Fee";
                                                                                    break;
                                                                                case 3:
                                                                                    echo "Guidance";
                                                                                    break;
                                                                                case 4:
                                                                                    echo "Examination";
                                                                                    break;
                                                                                case 5:
                                                                                    echo "Interview";
                                                                                    break;
                                                                                case 6:
                                                                                    echo "Registrar";
                                                                                    break;
                                                                                case 7:
                                                                                    echo "Cashier";
                                                                                    break;
                                                                                case 8:
                                                                                    echo "Completion";
                                                                                    break;
                                                                                case 9:
                                                                                    echo "Enrolled";
                                                                                    break;
                                                                                default:
                                                                                    echo "Default: Number is not between 1 and 8";
                                                                                    break;
                                                                            }
                                                                            ?></p>
                                                                        <?php
                                                                        $logs = $DB_con->prepare("SELECT * FROM logs_enroll WHERE ern = :ern");
                                                                        $logs->execute(array(':ern' => $row['uniqid']));
                                                                        $logsresult = $logs->fetchAll();
                                                                        foreach ($logsresult as $log) {
                                                                        ?>
                                                                            <div class="collapse" id="collapseExample<?php echo $row['uniqid']; ?>">
                                                                                <div class="card card-body">
                                                                                    <?= $log['notes'] . " " . "<h5>" . $log['usertouch'] . "</h5>" . $log['touch']; ?>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </th>
                                                                <td><strong><?php echo $row["lname"] . ", " . $row["fname"] . " " . $row["mname"]; ?>
                                                                        &nbsp;
                                                                        <?php
                                                                        if ($row["isofficial"] == 0) {
                                                                        ?>
                                                                            <span class="icon-holder">
                                                                                <i class="anticon anticon-warning"></i>
                                                                            </span>
                                                                        <?php
                                                                        }
                                                                        ?></strong>
                                                                </td>
                                                                <td><?php echo $row["gender"]; ?></td>
                                                                <td><?php echo date("F j, Y", strtotime($row["dob"])); ?></td>
                                                                <!-- <td><?php echo $row["lrn"]; ?></td> -->
                                                                <td><?php echo $row["grade"]; ?></td>
                                                                <td><?php echo $row["section"]; ?></td>
                                                                <td><?php echo $row["house"]; ?></td>
                                                                <!-- <td>
                                                                <a type="button" href="profile.php?id=<?php echo $row["id"]; ?>&uniqid=<?php echo $row["uniqid"]; ?>" class="btn btn-success rounded"><span class="icon-holder"><i class="anticon anticon-eye"></i></span></a>
                                                                <?php
                                                                if ($_SESSION['level'] == 9 or $_SESSION['level'] == 2 or $_SESSION['level'] == 4) {
                                                                ?>
                                                                    <a href="edit-profile.php?id=<?php echo $row['id']; ?>&uniqid=<?php echo $row["uniqid"]; ?>" type="button" class="btn btn-primary rounded"><span class="icon-holder"><i class="anticon anticon-edit"></i></span></a>
                                                                <?php
                                                                }
                                                                if ($_SESSION['level'] == 9 or $_SESSION['level'] == 3) {
                                                                    if ($row["isofficial"] == 0) {
                                                                ?>
                                                                    <a href="mark-complete.php?id=<?php echo $row['uniqid']; ?>" type="button" class="btn btn-info rounded"><span class="icon-holder"><i class="anticon anticon-check"></i></span></a>
                                                                    <?php
                                                                    }
                                                                }
                                                                    ?>
                                                            </td> -->

                                                            </form>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-light text-center"></div>
                            </div>
                        </div>
                    </div>
                    <!-- form ends !-->
                </div>
                <?php include_once "includes/footer.php"; ?>
            </div>
            <?php include_once "script.php"; ?>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#userlist').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                    'print'
                ],
                "pageLength": 15
            });
        });
    </script>

    <!-- <div class="modal fade" id="classList" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" action="show-class-list.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Generate Class List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <select class="custom-select" id="gradelevel" name="gradelevel" required="">
                                <option value="">-- select one --</option>
                                <option value="Nursery">Nursery</option>
                                <option value="Toddler">Toddler</option>
                                <option value="Preschool">Preschool</option>
                                <option value="Kinder">Kinder</option>
                                <option value="Grade 1">Grade 1</option>
                                <option value="Grade 2">Grade 2</option>
                                <option value="Grade 3">Grade 3</option>
                                <option value="Grade 4">Grade 4</option>
                                <option value="Grade 5">Grade 5</option>
                                <option value="Grade 6">Grade 6</option>
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                                <option value="CAIE">CAIE</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <select class="custom-select" id="section" name="section" required="">
                                <option value="">-- select one --</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </div>
            </form>
        </div> -->
    </div>
</body>

</html>