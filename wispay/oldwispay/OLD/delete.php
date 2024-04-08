<?php
    include_once 'classes/dbclass.php';
    include_once 'header.php';
?>
    <div class="container py-3">
        <header>
            <div class="container">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">

                        <!-- Brand/logo -->
                        <div class="navbar-header">
                            <a class="navbar-brand" href="/">Westfields International School - Attendance System</a>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                <h1 class="display-5 fw-normal">Delete Record</h1>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <?php
                            if(isset($_GET['deleted']))
                            {
                                ?>
                                <div class="alert alert-success">
                                    <strong>Success!</strong> record was deleted...
                                </div>
                                <?php
                            }
                            else
                            {
                                ?>
                                <div class="alert alert-danger">
                                    <strong>Sure !</strong> to remove the following record ?
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        if(isset($_GET['delete_id']))
                        {
                            ?>
                            <table class='table table-bordered'>
                                <tr>
                                    <th>RFID</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                </tr>
                                <?php
                                $stmt = $DB_con->prepare("SELECT * FROM user WHERE id=:id");
                                $stmt->execute(array(":id"=>$_GET['delete_id']));
                                while($row=$stmt->fetch(PDO::FETCH_BOTH))
                                {
                                    ?>
                                    <tr>
                                        <td><?php print($row['rfid']); ?></td>
                                        <td><?php print($row['fname']); ?></td>
                                        <td><?php print($row['mname']); ?></td>
                                        <td><?php print($row['lname']); ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            <?php
                        }
                        ?>
                        <p>
                            <?php
                            if(isset($_GET['delete_id']))
                            {
                            ?>
                        <form method="post">
                            <input type="hidden" name="id" value="<?php echo $_GET['delete_id']; ?>" />
                            <button class="btn btn-large btn-primary" type="submit" name="btn-del"><i class="glyphicon glyphicon-trash"></i> &nbsp; YES</button>
                            <a href="attendance.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; NO</a>
                        </form>
                    <?php
                    }
                    else
                    {
                        ?>
                        <a href="attendance.php" class="btn btn-large btn-success"><i class="glyphicon glyphicon-backward"></i> &nbsp; Back to index</a>
                        <?php
                    }
                    ?>
                        </p>
                    </div>
            </div>
        </header>
    </div>
<?php include_once 'footer.php'; ?>