<?php
include_once 'classes/dbclass.php';
include_once 'header.php';

?>
<style>
.table-hover > tbody > tr:hover > td,
.table-hover > tbody > tr:hover > th {
    background-color: #ffc107!important;
}
</style>
<body>
    <div class="container pt-2">
        <!-- Image and text -->
        <nav class="navbar navbar-dark bg-dark">
          <a class="navbar-brand" href="#">WISPAY</a>
          <a class="navbar-brand" href="#" onclick="window.print()">PRINT</a>
          <a class="navbar-brand" href="#" onclick="history.back()">BACK</a>
        </nav>
        <div class="row">
            <div class="col-12">
                <h2 class="text-center text-primary">Transaction History [<?php echo $_POST["from"].' to '.$_POST["to"]; ?>]</h2>
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Name (RFID)</th>
                            <th scope="col">Reference Code</th>
                            <th scope="col">Debit</th>
                            <th scope="col">Credit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            setlocale(LC_MONETARY,"fil_PH");
                            $xhistory = $pdo_conn->prepare("SELECT W.rfid, W.refcode, W.total, W.transcode, W.transdate, U.rfid, U.fname, U.lname FROM wispay W INNER JOIN user U ON W.rfid = U.rfid WHERE transdate BETWEEN :from AND :to");
                            $xhistory->execute(array(':from' => $_POST["from"],':to' => $_POST["to"]));
                            $fullhistory = $xhistory->fetchAll();

                            foreach($fullhistory as $hrow) {
                                if($hrow['transcode']=="DEBIT"){
                                    $total = "<span class='text-danger'>-".number_format($hrow['total'],2)."</span>";
                                } else {
                                    $total = "<span class='text-success'>+".number_format($hrow['total'],2)."</span>";
                                }

                                $time = strtotime($hrow['transdate']);
                                $friendlytime = date("M d, Y g:i A", $time);

                                echo "<tr>
                                        <th scope=\"row\">".$friendlytime."</th>
                                        <td><strong>".$hrow['fname']." ".$hrow['lname']."</strong> (".$hrow['rfid'].")</td>
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
                            <td>Total Balance</td>
                            <td></td>
                                <?php
                                    $rtbalance = $pdo_conn->prepare("SELECT SUM(IF(`transcode`='CREDIT', `total`, 0))-sum(IF(`transcode`='DEBIT', `total`, 0)) AS `balance` FROM `wispay` WHERE transdate BETWEEN :from AND :to");
                                    $rtbalance->execute(array(':from' => $_POST["from"],':to' => $_POST["to"]));
                                    $cbalance = $rtbalance->fetchAll();

                                    foreach($cbalance as $bal) {
                                        echo "<td style='text-align: right; font-weight: bolder; font-size:1.2em;text-align:left' class='text-success'>&#8369; ".number_format($bal['balance'],2)."</td>";
                                    }
                                ?>
                        </tr>
                    </table>      
            </div>
        </div>
    </div>
</body>
<?php
    include_once 'footer.php';
?>