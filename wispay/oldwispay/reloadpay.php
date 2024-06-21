<?php
include_once 'classes/dbclass.php';
include_once 'header.php';

$transcode = "CREDIT";
$processedby = $_POST['lasttouch'];
$refcode = uniqid("WIS-");

$pay = "INSERT INTO wispay ( transcode, rfid, refcode, total, transdate, processedby) VALUES ( :transcode, :rfid, :refcode, :total, NOW(), :processedby )";
$pay_statement = $pdo_conn->prepare( $pay );
$pay_statement->execute( array( ':transcode'=>$transcode, ':rfid'=>$_POST['rfid'], ':refcode'=>$refcode, ':total'=>$_POST["amount"], ':processedby'=>$processedby,) );
?>
<body class="loginform">
    <div class="content">
        <div class="card">
            <div class="firstinfo"><img src="img/wispay.png"/>
                <div class="profileinfo">
                    <h1><?php echo $refcode; ?></h1>
                    <h2>Transaction Date: <?php echo date('d.m.Y H:i:s'); ?></h2>
                    <h2>Transaction Amount: <?php echo $_POST['amount']; ?></h2>
                    <br><a class="btn btn-primary btn-lg" href="reload.php"><span class="glyphicon glyphicon-repeat"></span> New transaction</div></a>
                </div>
            </div>
        </div>
        <div class="badgescard"> </div>
    </div>
</body>

<?php
include_once 'footer.php';
?>