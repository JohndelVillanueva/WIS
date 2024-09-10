<?php
require_once("config/config.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("location: index.php");
}

if (empty($_POST['rfid'])) {
    header("location: pay.php?error=1");
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

    <form action="other_payment2.php" method="post">
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/badge.png" alt="sing up image"></figure>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title wisfont">Enter Amount</h2>
                        <form method="POST" class="register-form" id="login-form">
                            <h3 class="form-title wisfont">Scanned RFID : <span style="color:red"><?php
                                $pdo_statement = $DB_con->prepare("SELECT * FROM user WHERE rfid=?");
                                $pdo_statement->execute([$_POST['rfid']]);
                                $result = $pdo_statement->fetch();
                                echo $result['fname']." ".$result['lname'];
                                ?></span></h3>
                            <div class="form-group">
                                <input class="wisfont" type="text" name="amount" id="amount"
                                       placeholder="Amount" autofocus/>
                                <input class="wisfont" type="hidden" name="rfid" id="rfid"
                                       placeholder="RFID" value="<?php echo $_POST['rfid'];?>"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="submit" id="submit" class="form-submit wisfont"
                                       value="Pay"/>
                            </div>
                        </form>
                        <?php
                        if(isset($_GET['error'])){
                            switch($_GET['error']){
                                case 1:
                                    echo "
                                            <h1 class=\"alert alert-warning\">Empty Amount!</h1>
                                        ";
                                    break;
                            }
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
</body>
</html>