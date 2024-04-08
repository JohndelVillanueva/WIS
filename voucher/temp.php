<?php
require_once 'vendor/autoload.php';
require_once 'config.php';
?>

<?php
$voucher_expiration = 525600;
$voucher_count = 1;
$voucher_note = "August Philippe";
$site_id = 'default';

$unifi_connection = new UniFi_API\Client($controlleruser, $controllerpassword, $controllerurl, $site_id, $controllerversion);
$set_debug_mode   = $unifi_connection->set_debug($debug);
$loginresults     = $unifi_connection->login();

$voucher_result = $unifi_connection->create_voucher($voucher_expiration, $voucher_count, 0, $voucher_note);

$vouchers = $unifi_connection->stat_voucher($voucher_result[0]->create_time);
echo "
<h2>Westfields ICT</h2>
<h1>".$vouchers[0]->code."</h1>
<p>".$vouchers[0]->note."</p>
";