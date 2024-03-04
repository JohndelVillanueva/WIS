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
                                    <h4><span class="icon-holder"><i class="anticon anticon-unordered-list"></i></span> Released Inventory</h4>
                                </div>
                                <div class="card-body">
                                    <table id="userlist" class="display table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Serial No.</th>
                                                <th>Date Issued</th>
                                                <th>Date Returned</th>
                                                <th>Issuer</th>
                                                <th>Remarks</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $pdo_statement = $DB_con->prepare("SELECT * FROM inventory INNER JOIN user WHERE inventory.empno = user.empno AND inventory.datein = :datein");
                                            $pdo_statement->execute(array(":datein" => "0000-00-00 00:00:00"));
                                            $result = $pdo_statement->fetchAll();
                                            foreach ($result as $row) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['lname'] . ", " . $row['fname']; ?></td>
                                                    <td><?php echo $row['description']; ?></td>
                                                    <td><?php echo $row['serial']; ?></td>
                                                    <td><?php echo $row['dateout']; ?></td>
                                                    <td><?php
                                                        if ($row['datein'] == "0000-00-00 00:00:00") {
                                                            echo "*** UNRETURNED ***";
                                                        } else {
                                                            echo $row['datein'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row['issuedby']; ?></td>
                                                    <td><?php echo $row['remarks']; ?></td>
                                                    <td><a class="btn btn-primary" href=#><i class="anticon anticon-retweet"></i> Return</a></td>
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

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-warning rounded-top pt-2">
                                    <h4><span class="icon-holder"><i class="anticon anticon-unordered-list"></i></span> Current Inventory</h4>
                                </div>
                                <div class="card-body">
                                    <a href="" class="btn btn-success float-right"><i class="anticon anticon-plus-circle"></i> New Record</a>
                                    <table id="userlist" class="display table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Serial No.</th>
                                                <th>Remarks</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $pdo_statement = $DB_con->prepare("SELECT * FROM inventory INNER JOIN user WHERE inventory.empno = user.empno AND inventory.datein != :datein");
                                            $pdo_statement->execute(array(":datein" => "0000-00-00 00:00:00"));
                                            $result = $pdo_statement->fetchAll();
                                            foreach ($result as $row) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['description']; ?></td>
                                                    <td><?php echo $row['serial']; ?></td>
                                                    <td><?php echo $row['remarks']; ?></td>
                                                    <td><a class="btn btn-primary" href=#><i class="anticon anticon-upload"></i> Release</a></td>
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
                    <!-- form ends !-->
                </div>
                <?php include_once "includes/footer.php"; ?>
            </div>
            <?php include_once "includes/scripts.php"; ?>
        </div>
    </div>
</body>

</html>