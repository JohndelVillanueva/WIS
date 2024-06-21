<?php
include_once 'classes/dbclass.php';

if(isset($_GET['user']))
{
    $id = $_GET['user'];
    extract($crud->getID($id));
}

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
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav nav-pills navbar-right">
                                <li class="text-primary"><a href="students.php"><span class="glyphicon glyphicon glyphicon-chevron-left"></span> Go Back</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                <h1 class="display-5 fw-normal">Time Card - <?php echo $fname." ".$lname; ?></h1>
                <div class="container">
                    <?php
                        $pdo_statement = $pdo_conn->prepare("SELECT * FROM attendance WHERE rfid = :rfid ORDER BY adate ASC");
                        $pdo_statement->bindParam(':rfid', $rfid);
                        $pdo_statement->execute();
                        $result = $pdo_statement->fetchAll();

                        if(!empty($result)) {
                            foreach($result as $row) {
                    ?>
                    <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th scope="col" class="text-center">Date</th>
                          <th scope="col" class="text-center">Clock In</th>
                          <th scope="col" class="text-center">Clock Out</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <?php
                                $phpdate = strtotime($row['adate']);
                                $easydate = date("F d Y", $phpdate);
                                $clockin = strtotime($row['clockin']);
                                $timein = date("g:i:s A", $clockin);
                                $clockout = strtotime($row['clockout']);
                                $timeout = date("g:i:s A", $clockout);
                            ?>
                          <th scope="row" class="text-center"><?php echo $easydate; ?></th>
                          <td class="text-center"><?php echo $timein; ?></td>
                          <td class="text-center"><?php echo $timeout; ?></td>
                        </tr>
                      </tbody>
                    </table>
                    <?php
                            }
                                } else {
                                    echo "<div class=\"alert alert-danger\">
                          <h1><strong>ERROR!</strong> No record found. <a href=\"attendance.php\"><span class=\"glyphicon glyphicon glyphicon-chevron-left\"></span> Go Back</a></h1>
                        </div>";
                                }
                    ?>
                </div>
        </header>
    </div>
<?php include_once 'footer.php'; ?>