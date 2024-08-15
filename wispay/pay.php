<?php
require_once("config/config.php");
session_start();

// Redirect to index if not logged in
if (!isset($_SESSION["username"])) {
    header("location: index.php");
    exit();
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
    <form action="amount.php" method="post">
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/pay-logo.png" alt="sign up image" style="margin-left: -20px"></figure>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title wisfont">Scan ID</h2>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <input class="wisfont" type="password" name="rfid" id="rfid"
                                       placeholder="RFID" autofocus/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="submit" id="submit" class="form-submit wisfont" value="Pay"/>
                            </div>
                        </form>
                        <?php
                        if (isset($_GET['error'])) {
                            switch ($_GET['error']) {
                                case 1:
                                    echo '<h1 class="alert alert-warning">Invalid RFID!</h1>';
                                    break;
                            }
                        }

                        if (isset($_GET['success'])) {
                            switch ($_GET['success']) {
                                case 0:
                                    echo '<h1 class="alert alert-warning">Insufficient Balance!</h1>';
                                    break;
                                case 1:
                                    echo '<h1 class="alert alert-success">Transaction Complete!</h1>';
                                    break;
                            }
                        }
                        ?>
                        <div class="social-login">
                            <span class="social-label">Copyright &copy; WIS ICT.</span>
                            <a class="social-label" href="dashboard.php">
                                <i class="align-middle" data-feather="trello"></i> DASHBOARD
                            </a>
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
