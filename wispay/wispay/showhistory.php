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

                <h1 class="h3 mb-3 wisfontorange">Show Transaction History</h1>

                <div class="row">
                    <div class="col-12">
                        <?php
                        if (!isset($_GET['success'])) {

                        } elseif ($_GET['success'] == 0) {
                            echo "
                        <div class=\"alert alert-danger\" role=\"alert\">Failed to Reload!</div>
                    ";
                        } elseif ($_GET['success'] == 1) {
                            echo "
                        <div class=\"alert alert-success\" role=\"alert\">WISPay Account number " . $_GET['rfid'] . " Reloading Successful!<br>Reference Number " . $_GET['refcode'] . "</div>
                    ";
                        }
                        ?>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Transaction History for <?php echo $_GET['rfid']; ?></div>
                            <div class="card-body">
                                <table id="userlist" class="display table table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Reference Code</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Transaction Date</th>
                                        <th>Processed By</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $pdo_statement = $DB_con->prepare("SELECT * FROM wispay WHERE rfid=:rfid ORDER BY transdate DESC");
                                    $pdo_statement->bindParam(':rfid', $_GET['rfid']);
                                    $pdo_statement->execute();
                                    $result = $pdo_statement->fetchAll();
                                    foreach($result as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row['refcode']; ?></td>
                                            <td><span class="text-danger"><?php echo $debit = $row['debit']==0 ? "" : $row['debit']; ?></span></td>
                                            <td><span class="text-success"><?php echo $credit = $row['credit']==0 ? "" : $row['credit']; ?></span></td>
                                            <td><?php echo $row['transdate']; ?></td>
                                            <td><?php echo $row['processedby']; ?></td>
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
<script>

    $(document).ready(function() {
        $('#userlist').DataTable( {
            order:[3, 'desc'],
            dom: 'frtipB',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'print'
            ]
        } );
    } );
</script>
</body>

</html>