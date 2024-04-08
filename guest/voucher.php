<?php
require_once 'vendor/autoload.php';
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WIS Internet Voucher Kiosk</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<section class="main-content">
    <div class="container">
        <form method="post" action="voucher.php">
            <div class="row">
                <div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6">
                    <div class="profile-card card rounded-lg shadow p-4 p-xl-5 mb-4 text-center position-relative overflow-hidden">
                        <img src="img/logo.png" alt="" class="mx-auto mb-3">
                        <h3 class="mb-4">Westfields International School</h3>
                        <?php
                        $voucher_expiration = $_POST['time'];
                        $voucher_count = 1;
                        $voucher_note = $_POST['name'];
                        $site_id = 'default';

                        $unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
                        $set_debug_mode   = $unifi_connection->set_debug($debug);
                        $loginresults     = $unifi_connection->login();

                        $voucher_result = $unifi_connection->create_voucher($voucher_expiration, $voucher_count, 0, $voucher_note);

                        $vouchers = $unifi_connection->stat_voucher($voucher_result[0]->create_time);

                        ?>
                        <h4 class="mb-4">Internet Voucher</h4>
                        <h4><?php echo $vouchers[0]->note." ( ".$_POST['type'] ." )"; ?></h4><br>
                        <h1><?php echo $vouchers[0]->code; ?></h1><br><br>
                        <div class="input-group mb-2">
                            <a type="button" class="btn btn-success btn-lg btn-block" href="index.php">New Voucher</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>