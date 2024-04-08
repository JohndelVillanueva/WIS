<?php
	include_once("includes/config.php");

	date_default_timezone_set("Asia/Manila");
	date_default_timezone_set("Asia/Manila");
	$currentTime = time();
	if ($currentTime <= strtotime('8:00:00')) {
		$istardy = 0;
	} else
	{
		$istardy = 1;
	}


	$pdo_statement = $DB_con->prepare("SELECT * FROM user WHERE rfid = :rfid AND isactive = 1");
	$pdo_statement->bindParam(':rfid', $_POST['rfid']);
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();

?>
<html>
	<head>
		<link rel="stylesheet" href="assets/vendors/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body>
		<div class="container vh-100">
			<div class="d-flex align-items-center" style ="height: 100%">
				<div class="col-md-12">
					<div class="wrapper p-5">
						<div class="logo"><img src="assets/images/logo/main.png" style="max-width: 150px;margin-top: -100px;"></div>	
						<div class="row" style="margin-top:-30px;">
							<?php
							if(!empty($result)) {
								foreach($result as $row) {
									
							?>
							<div class="col-sm-3">
								<img src="assets/images/avatars/<?php echo $row["photo"].'.jpg'; ?>" style="max-width: 200px;border:2px #041179 solid!important;" class="rounded-circle">
							</div>
							<div class="col-sm-9 d-flex align-items-center">
								<p style="font-size: 1.5cqw;margin-top:20px;">
									<strong><?php echo strtoupper($row["fname"]).' '.strtoupper($row["mname"]).' '.strtoupper($row["lname"]); ?></strong>
									<br>
									<?php echo $row["position"]; ?>
								</p>
								<?php
									$att = "INSERT INTO attendance ( rfid, adate, taptime, location, istardy) VALUES ( :rfid, curdate(), curtime(), :ip, :istardy )";
									$att_statement = $DB_con->prepare( $att );
									$att_statement->execute( array( ':rfid'=>$_POST['rfid'], ':ip'=>getHostByName(php_uname('n')), ':istardy'=>$istardy) );
									exec('sudo python /var/www/html/exit.py > /dev/null &');
									
										}
									} else {
										echo "<div style=\"margin-top:100px!important\" class=\"alert alert-danger\">
											<h1><strong>ERROR!</strong> Invalid RFID Card. Please report to the IT Department.</h1>
																	</div>";
									}
								?>
								<br>
								<script>
									setTimeout(function(){
										window.location.href = 'index.php';
									}, 2000);
								</script>
							</div>
						</div>
						<div class="row justify-content-center">
							<?php
								if($istardy==1 && $row['position']=="Student") {
										echo "<div style=\"margin-top:20px!important\" class=\"alert alert-warning\">
											<h1><strong>Notice:</strong> You have been marked late for school.</h1>
																	</div>";
									
									}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script type="application/javascript" src="assets/js/jquery.min.js"></script>
	<script type="application/javascript" src="assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<script>

    function currentTime() {
        let date = new Date();
        let hh = date.getHours();
        let mm = date.getMinutes();
        let ss = date.getSeconds();
        let session = "AM";

        if(hh == 0){
            hh = 12;
        }
        if(hh > 12){
            hh = hh - 12;
            session = "PM";
        }

        hh = (hh < 10) ? "0" + hh : hh;
        mm = (mm < 10) ? "0" + mm : mm;
        ss = (ss < 10) ? "0" + ss : ss;

        let time = hh + ":" + mm + ":" + ss + " " + session;

        document.getElementById("clock").innerText = time;
        let t = setTimeout(function(){ currentTime() }, 1000);
    }
    currentTime();
			
</script>
</html>