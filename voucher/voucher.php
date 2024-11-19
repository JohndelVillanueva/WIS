<?php
require_once 'vendor/autoload.php';
require_once 'config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="x-ua-compatible" content="IE=Edge;chrome=1" />
    <meta http-equiv="refresh" content="2; url=index.php" />
    <title>WIS Wifi Voucher KIOSK</title>
    <style type="text/css">
        /* Your existing CSS styles */
    </style>
</head>
<body onload="self.focus(); window.print()">
    <div class="voucher">
    <div class="voucher-outerWrapper">
        <div class="voucher-innerWrapper">
            <div class="valid days_disabled hours_enabled minutes_disabled">
                <?php
                    // Retrieve user input
                    $voucher_expiration = $_POST['time'];
                    $voucher_count = 1;
                    $voucher_note = $_POST['name'];
                    $download_limit = isset($_POST['download_limit']) ? intval($_POST['download_limit']) : 10; // Default to 10 MB
                    $upload_limit = isset($_POST['upload_limit']) ? intval($_POST['upload_limit']) : 10; // Default to 10 MB
                    $site_id = 'default';

                    // Connect to the UniFi controller
                    $unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
                    $set_debug_mode   = $unifi_connection->set_debug($debug);
                    $loginresults     = $unifi_connection->login();

                    // Create the voucher with dynamic limits
                    $voucher_result = $unifi_connection->create_voucher($voucher_expiration, $voucher_count, 0, $voucher_note, $download_limit, $upload_limit);

                    // Fetch voucher details
                    $vouchers = $unifi_connection->stat_voucher($voucher_result[0]->create_time);
                ?>
                <div class="valid">Westfields</div>
                <div class="valid">Internet Voucher</div>
                <hr>
                <div class="valid"><h3><?php echo $vouchers[0]->note; ?></h3></div><br>
                <div class="limit"><?php echo $_POST['type']; ?></div>
                <div class="limit">Download Limit: <?php echo $download_limit; ?> MB</div> <!-- Display the dynamic download limit -->
                <div class="limit">Upload Limit: <?php echo $upload_limit; ?> MB</div> <!-- Display the dynamic upload limit -->
            </div>
            <div class="code"><h1><?php echo $vouchers[0]->code; ?></h1></div>
            <hr>
            <div class="limit">https://westfields.edu.ph</div>
        </div>
    </div>
</div>
</body>
</html>
