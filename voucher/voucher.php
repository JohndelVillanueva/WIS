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
body {
	font-size: 1em;
	font-family:sans-serif;
	margin: 0;
	padding: 0;
}

div.voucher {
	display: inline-block;
	width: 166px;
	height: 100px;
	float: left;
	page-break-inside: avoid;
}

div.voucher div.voucher-outerWrapper {
	display: table;
	width: 100%;
	height: 100%;
}

div.voucher div.voucher-innerWrapper {
	display: table-cell;
	width: 100%;
	height: 100%;
	text-align: center;
	vertical-align: middle;
	overflow: hidden;
}

div.limit {
	font-size: 0.7em;
}

div.limit div {
	float: left;
	width: 100%;
}

div.limit.downrate_enabled .downrate_enabled,
div.limit.uprate_enabled .uprate_enabled,
div.limit.quota_enabled .quota_enabled {
	display: inline-block;
}

div.limit.downrate_enabled .downrate_disabled,
div.limit.uprate_enabled .uprate_disabled,
div.limit.quota_enabled .quota_disabled {
	display: none;
}

div.limit.downrate_disabled .downrate_enabled,
div.limit.uprate_disabled .uprate_enabled,
div.limit.quota_disabled .quota_enabled {
	display: none;
}

div.limit.downrate_disabled .downrate_disabled,
div.limit.uprate_disabled .uprate_disabled,
div.limit.quota_disabled .quota_disabled {
	display: inline-block;
}

div.limit div div.heading {
	display: inline-block;
	width: 83px;
	text-align: right;
}
div.limit div div.value {
	display: inline-block;
	width: 78px;
	text-align: left;
	margin-left: 5px;
	white-space: nowrap;
}

div.valid {
	color: #000;
}

div.valid div {
	display: inline-block;
}

div.valid.days_enabled .days_enabled,
div.valid.hours_enabled .hours_enabled,
div.valid.minutes_enabled .minutes_enabled {
	display: inline-block;
}

div.valid.days_disabled .days_enabled,
div.valid.hours_disabled .hours_enabled,
div.valid.minutes_disabled .minutes_enabled {
	display: none;
}

div.code {
	font-weight:bold;
	padding-top: 5px;
	padding-bottom: 5px;
	font-size:larger;
}

</style>
</head>
<body onload="self.focus(); window.print()">
	<div class="voucher">
	<div class="voucher-outerWrapper">
		<div class="voucher-innerWrapper">
			<div class="valid days_disabled hours_enabled minutes_disabled">
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
				<div class="valid">Westfields</div>
				<div class="valid">Internet Voucher</div>
				<hr>
				<div class="valid"><?php echo $vouchers[0]->note; ?></div><br>
				<div class="limit"><?php echo $_POST['type']; ?></div>
			</div>
			<div class="code"><?php echo $vouchers[0]->code; ?></div>
			<hr>
			<div class="limit">https://westfields.edu.ph</div>
		</div>
	</div>
</div>

</body>
</html>
