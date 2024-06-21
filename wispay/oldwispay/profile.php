<?php
require_once 'classes/db.php';

session_start();

if (!isset($_SESSION['name'])) {
    header("location: index.php");
}
include_once 'classes/dbclass.php';
include_once 'header.php';

$pdo_statement = $pdo_conn->prepare("SELECT * FROM user WHERE rfid = :rfid");
$pdo_statement->bindParam(':rfid', $_POST['rfid']);
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();
if(!empty($result)) {
    foreach($result as $row) {
?>
<body class="loginform">
    <div class="content">
        <div class="card">
            <div class="firstinfo"><img src="img/wispay.png"/>
                <form action="processpay.php" method="post">
                <div class="profileinfo">
                    <h2><?php echo $row["fname"].' '.$row["lname"]; ?></h2>
                    <input type="hidden" name="rfid" id="rfid" value="<?php echo $_POST['rfid']; ?>">
                    <input type="hidden" name="lasttouch" value="<?php echo $_SESSION['name']; ?>">
                    <input type="text" class="form-control" name="amount" id="amount" autofocus tabindex="0" required>
                    <small id="amount" class="form-text text-muted">Enter payment amount.</small>
                    <button type="submit" class="hidden" name="submit">Pay</button>
                </div>
                </form>
            </div>
        </div>
        <div class="badgescard"> <span class="	glyphicon glyphicon-shopping-cart"></span> Pay with WISpay&trade;</div>
    </div>
</body>
<?php
    }
} else { ?>
    <body class="loginform">
    <div class="content">
        <div class="card">
            <div class="firstinfo"><img src="img/wispay.png"/>
                <form action="processpay.php" method="post">
                    <div class="profileinfo">
                        <h1 class="text-danger">INVALID RFID</h1>
                    </div>
                </form>
            </div>
        </div>
        <div class="badgescard"><span class="glyphicon glyphicon-refresh"></span> Redirecting to WISpay&trade;
            <script>
                setTimeout(function(){
                    window.location.href = 'index.php';
                }, 2000);
            </script>
        </div>
    </div>
    </body>
<?php
}
    include_once 'footer.php';
?>