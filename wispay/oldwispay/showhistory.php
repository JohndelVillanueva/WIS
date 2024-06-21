<?php
include_once 'classes/dbclass.php';
include_once 'header.php';

$pdo_statement = $pdo_conn->prepare("SELECT * FROM user WHERE rfid = :rfid");
$pdo_statement->bindParam(':rfid', $_POST['rfid']);
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();
    foreach($result as $row) {
?>
<style>
.table-hover > tbody > tr:hover > td,
.table-hover > tbody > tr:hover > th {
    background-color: #ffc107!important;
}
</style>
<body>
    <div class="container">
        <nav class="navbar navbar-dark bg-dark">
          <a class="navbar-brand" href="#">WISPAY</a>
          <a class="navbar-brand" href="#" onclick="window.print()">PRINT</a>
          <a class="navbar-brand" href="#" onclick="history.back()">BACK</a>
        </nav>
        <div class="row">
            <div class="col-12">
                <h1><?php echo $row["fname"].' '.$row["lname"].' - RFID No. '.$row["rfid"]; ?></h1>
                    <input type="hidden" name="rfid" id="rfid" value="<?php echo $_POST['rfid']; ?>">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="font-size:1.4em;font-weight: bold;">Current Balance</td>
                                <?php
                                    $rtbalance = $pdo_conn->prepare("SELECT SUM(credit)-sum(debit) AS `balance` FROM `wispay` WHERE `rfid`=:rfid");
                                    $rtbalance->bindParam(':rfid', $_POST['rfid']);
                                    $rtbalance->execute();
                                    $cbalance = $rtbalance->fetchAll();

                                    foreach($cbalance as $bal) {
                                        echo "<td style='text-align: right; font-size: 1.4em; font-weight: bolder' class='text-success'>&#8369; ".number_format($bal['balance'],2)."</td>";
                                    }
                                ?>
                        </tr>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Reference Code</th>
                            <th scope="col">Debit</th>
                            <th scope="col">Credit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            setlocale(LC_MONETARY,"fil_PH");
                            $xhistory = $pdo_conn->prepare("SELECT * FROM wispay WHERE rfid = :rfid");
                            $xhistory->bindParam(':rfid', $_POST['rfid']);
                            $xhistory->execute();
                            $fullhistory = $xhistory->fetchAll();

                            foreach($fullhistory as $hrow) {
                                if($hrow['transcode']=="DEBIT"){
                                    $total = "<span class='text-danger'>-".number_format($hrow['total'],2)."</span>";
                                } else {
                                    $total = "<span class='text-success'>+".number_format($hrow['total'],2)."</span>";
                                }
                                echo "<tr>
                                        <th scope=\"row\">".$hrow['transdate']."</th>
                                        <td>".$hrow['refcode']."</td>";
                                if($hrow['transcode'] == 'DEBIT') {
                                            echo "<td><strong>".$total."</strong></td><td></td></tr>";
                                } elseif ($hrow['transcode'] == 'CREDIT'){
                                            echo "<td></td><td><strong>".$total."</strong></td></tr>";
                               }
                                        
                            } ?>
                        </tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Current Balance</td>
                                <?php
                                    $rtbalance = $pdo_conn->prepare("SELECT SUM(IF(`transcode`='CREDIT', `total`, 0))-sum(IF(`transcode`='DEBIT', `total`, 0)) AS `balance` FROM `wispay` WHERE `rfid`=:rfid");
                                    $rtbalance->bindParam(':rfid', $_POST['rfid']);
                                    $rtbalance->execute();
                                    $cbalance = $rtbalance->fetchAll();

                                    foreach($cbalance as $bal) {
                                        echo "<td style='text-align: right; font-weight: bolder'>&#8369; ".number_format($bal['balance'],2)."</td>";
                                    }
                                ?>
                        </tr>
                    </table>     
            </div>
        </div>
    </div>
</body>
<?php
}
    include_once 'footer.php';
?>