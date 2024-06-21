<?php
require_once("config/config.php");
session_start();

$id = $_SESSION['username'];

if(!isset($_SESSION['username']))
{
    header("location: index.php");
}

include_once ("headers.php");

?>


<body>
<div class="wrapper">
<?php include_once ("sidemenu.php");?>
    <div class="main">
        <?php include_once ("topbar.php");?>
<!-- CONTENT STARTS HERE !-->
        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3 wisfontorange">Dashboard</h1>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Real Time Transaction</div>
                            <div class="card-body">
                                <table class="display table table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Reference Code</th>
                                        <th>Credit</th>
                                        <th>Debit</th>
                                        <th>Transaction Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $pdo_statement = $DB_con->prepare("SELECT wispay.*, user.fname AS fname, user.lname AS lname FROM wispay INNER JOIN user ON wispay.rfid = user.rfid  ORDER by wispay.id DESC LIMIT 50");
                                    $pdo_statement->execute();
                                    $result = $pdo_statement->fetchAll();
                                    foreach($result as $row) {
                                        if($row['transdate']!="0000-00-00 00:00:00") {
                                            $phpdate = strtotime($row['transdate']);
                                            $mysqldate = date('M d, Y H:i:s A', $phpdate);
                                        } else {
                                            $mysqldate = "Carry Over from 2022-2023";
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $row['fname']." ".$row['lname']." (".$row['rfid'].")"; ?></td>
                                            <td><?php echo $row['refcode']; ?></td>
                                            <td><span class="text-success"><?php echo $credit = $row['credit']==0 ? "" : $row['credit']; ?></span></td>
                                            <td><span class="text-danger"><?php echo $debit = $row['debit']==0 ? "" : $row['debit']; ?></span></td>
                                            <td><?php echo $mysqldate; ?></td>
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

            </div>
        </main>
<!-- CONTENT ENDS HERE !-->
        <?php include_once ("footer.php");?>
    </div>
</div>

<?php include_once ("scripts.php");?>
</body>

</html>