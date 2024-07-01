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
                <?php

                $pdo_statement = $DB_con->prepare("SELECT * FROM user WHERE rfid = :rfid");
                $pdo_statement->execute([':rfid', $_GET['rfid']]);
                $result = $pdo_statement->fetchAll();
                foreach($result as $row) {
                ?>
                <h1 class="h3 mb-3 wisfontorange">Reload - <?php echo $row['fname']." ".$row['lname']; ?></h1>
                <form action="processmoney.php" method="post">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">RFID# <?php echo $_GET['rfid']; ?></h5>
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="inputAmount" class="form-label">Amount</label>
                                        <input type="text" class="form-control" id="inputAmount" name="amount" aria-describedby="amountHelp" autofocus>
                                        <input type="hidden" name="rfid" value="<?php echo $_GET['rfid'];?>">
                                        <div id="amountHelp" class="form-text">Enter reload amount.</div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Reload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            <?php } ?>
            </div>
        </main>
<!-- CONTENT ENDS HERE !-->
        <?php include_once ("footer.php");?>
    </div>
</div>

<?php include_once ("scripts.php");?>
</body>

</html>