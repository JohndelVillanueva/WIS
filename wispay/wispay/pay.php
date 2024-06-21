<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("location: index.php");
}

if (isset($_REQUEST['submit'])  && !empty($_POST['amount']) && !empty($_POST['rfid'])) {
    $processedby = $_SESSION['fname']." ".$_SESSION['lname'];
    $refcode = uniqid("WIS-");

    $bal = $DB_con->prepare("SELECT sum(debit)-sum(credit) as ctot FROM wispay WHERE rfid = :rfid");
    $bal->bindParam(':rfid', $_POST['password']);
    $bal->execute();
    $rbal = $bal->fetchAll();

    if(!empty($rbal)) {
        foreach($rbal as $brow) {
            if($brow['ctot']>=$_POST['amount'] OR $brow['ctot'] <= -1000){
                $pay = "INSERT INTO wispay ( credit, rfid, refcode, transdate, processedby) VALUES ( :credit, :rfid, :refcode, NOW(), :processedby )";
                $pay_statement = $DB_con->prepare( $pay );
                $pay_statement->execute( array( ':credit'=>$_POST['amount'], ':rfid'=>$_POST['password'], ':refcode'=>$refcode, ':processedby'=>$processedby) );
                header("location: pay.php?success=1");
            } else {
                header("location: pay.php?success=0");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WISPay - Pay</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body class="login">

<div class="main">

    <form action="" method="post">
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/badge.png" alt="sing up image"></figure>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title wisfont">WISPay</h2>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <input class="wisfont" type="text" name="amount" id="amount"
                                       placeholder="Amount" autofocus/>
                            </div>
                            <div class="form-group">
                                <input class="wisfont" type="password" name="password" id="password"
                                       placeholder="RFID"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="submit" id="submit" class="form-submit wisfont"
                                       value="Pay"/>
                            </div>
                        </form>
                        <?php
                        if(isset($_GET['success'])){
                            switch($_GET['success']){
                                case 1:
                                    echo "
                                            <h1 class=\"alert alert-success\">Transaction Successful!</h1>
                                        ";
                                    break;
                                case 0:
                                    echo "
                                            <h1 class=\"alert alert-warning\">Transaction Failed!</h1>
                                        ";
                            }
                        }

                        if (isset($errorMsg)) {
                            foreach ($errorMsg as $error) {
                                ?>
                                <div class="alert alert-danger">
                                    <strong><?php echo $error; ?></strong>
                                </div>
                                <?php
                            }
                        }
                        if (isset($loginMsg)) {
                            ?>
                            <div class="alert alert-success">
                                <strong><?php echo $loginMsg; ?></strong>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="social-login">
                            <span class="social-label">Copyright &copy; WIS ICT.</span>
                            <a class="social-label"><a href="dashboard.php"><i class="align-middle" data-feather="trello"></i> DASHBOARD</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</div>

<!-- JS -->
<script src="vendor/jquery.min.js"></script>
<script src="js/main.js"></script>
<script>
    $('input#amount').on("keypress", function(e) {
        if (e.keyCode == 13) {
            var inputs = $(this).parents("form").eq(0).find(":input");
            var idx = inputs.index(this);

            if (idx == inputs.length - 1) {
                inputs[0].select()
            } else {
                inputs[idx + 1].focus();
                inputs[idx + 1].select();
            }
            return false;
        }
    });
</script>
</body>
</html>