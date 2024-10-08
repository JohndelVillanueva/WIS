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
                                        Re-enroll Old Student
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row ">
                                        <div class="col-lg-12">
                                            <table id="userlist" class="display table table-stripped table-fluid"  >
                                            <thead>
                                                <tr>
                                                    <th scope="col">Student Number</th>
                                                    <th scope="col">Full Name</th>
                                                    <th scope="col">Gender</th>
                                                    <th scope="col">Grade</th>
                                                    <th scope="col">Section</th>
                                                    <th scope="col">Profile</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $pdo_statement = $DB_con->prepare("SELECT * FROM user WHERE position = :position");
                                                $pdo_statement->execute([":position" => "Student"]);
                                                $result = $pdo_statement->fetchAll();
                                                foreach ($result as $row) {
                                                ?>
                                                    <tr class="<?php echo $style; ?>">
                                                        <form>
                                                            <th scope="row">
                                                                <?php echo $row['username']; ?>
                                                            </th>
                                                            <td><strong><?php echo $row["lname"] . ", " . $row["fname"] . " " . $row["mname"]; ?></strong>
                                                            </td>
                                                            <td><?php echo $row["gender"]; ?></td>
                                                            <td><?php echo $row["grade"]; ?></td>
                                                            <td><?php echo $row["section"]; ?></td>
                                                            <td>
                                                                <a type="button" href="re-enroll.php?id=<?php echo $row["id"]; ?>" class="btn btn-success rounded"><span class="icon-holder"><i class="anticon anticon-play-circle"></i></span> Enroll</a>
                                                            </td>

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
        $(document).ready( function() {
            $('#userlist').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                    'print'
                ],
                "pageLength":15
            } );
        } );
    </script>


</body>

</html>