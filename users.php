<?php
include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<? include_once "includes/css.php"; ?>

<body>
    <div class="app">
        <div class="layout">
            <?php include_once "includes/heading.php"; ?>
            <?php include_once "includes/sidemenu.php"; ?>
            <div class="page-container">
                <div class="main-content">
                    <!-- form starts !-->
                    <form action="generatereport.php" method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-warning rounded-top pt-2">
                                        <h4>
                                            <span class="icon-holder">
                                                <i class="anticon anticon-user"></i>
                                            </span>
                                            User List
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <table id="userlist" class="display table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Gender</th>
                                                    <th>Nationality</th>
                                                    <th>Grade</th>
                                                    <th>Previous School</th>
                                                    <th>LRN</th>
                                                    <th>Referral</th>
                                                    <th>Application Type</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $pdo_statement = $DB_con->prepare("SELECT * FROM user WHERE position = 'Student'");
                                                $pdo_statement->execute();
                                                $result = $pdo_statement->fetchAll();
                                                foreach ($result as $row) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row['lname'] . ", " . $row['fname']; ?></td>
                                                        <td><?php echo $row['gender']; ?></td>
                                                        <td><?php echo ucfirst($row['nationality']); ?></td>
                                                        <td><?php echo $row['grade']; ?></td>
                                                        <td><?php echo $row['prevsch']; ?></td>
                                                        <td><?php echo $row['lrn']; ?></td>
                                                        <td><?php echo $row['referral']; ?></td>
                                                        <td><?php echo ucfirst($row['apptype']); ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- form ends !-->
                </div>
                <?php include_once "includes/footer.php"; ?>
            </div>
            <?php include_once "includes/scripts.php"; ?>
        </div>
    </div>
    <script src="assets/vendors/datatables/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userlist').DataTable({
                dom: 'frtipB',
                "pageLength": 20,
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>

</html>