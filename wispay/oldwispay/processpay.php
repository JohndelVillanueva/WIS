<?php
include_once 'classes/dbclass.php';
include_once 'header.php';

$transcode = "DEBIT";
$processedby = $_POST['lasttouch'];
$refcode = uniqid("WIS-");

$rtbalance = $pdo_conn->prepare("SELECT SUM(IF(`transcode`='CREDIT', `total`, 0))-sum(IF(`transcode`='DEBIT', `total`, 0)) AS `balance` FROM `wispay` WHERE `rfid`=:rfid");
$rtbalance->bindParam(':rfid', $_POST['rfid']);
$rtbalance->execute();
$cbalance = $rtbalance->fetchAll();

foreach($cbalance as $bal) {
    if($bal['balance'] > $_POST['amount']) {
        $pay = "INSERT INTO wispay ( transcode, rfid, debit, refcode, total, transdate, processedby) VALUES ( :transcode, :rfid, :debit, :refcode, :total, NOW(), :processedby )";
        $pay_statement = $pdo_conn->prepare( $pay );
        $pay_statement->execute( array( ':transcode'=>$transcode, ':rfid'=>$_POST['rfid'], ':debit'=>$_POST["amount"], ':refcode'=>$refcode, ':total'=>$_POST["amount"], ':processedby'=>$processedby,) );
        $message = "TRANSACTION COMPLETE!";
    } else {
        $message = "INSUFFICIENT BALANCE!";
    }
}

?>
<body class="loginform">
    <div class="content">
        <div class="card">
            <div class="firstinfo"><img src="img/wispay.png"/>
                <div class="profileinfo">
                    <h1 class="text-danger"><?php echo $message; ?></h1>
                    <h2>Transaction Date: <?php echo date('d.m.Y H:i:s'); ?></h2>
                    <h2>Transaction Amount: <?php echo $_POST['amount']; ?></h2>
                    <br><a class="btn btn-primary btn-lg" href="index.php"><span class="glyphicon glyphicon-repeat"></span> New transaction</div></a>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
include_once 'footer.php';
?>