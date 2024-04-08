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
                                    $insert = $DB_con->prepare("INSERT INTO `visitorlog` (`name`, `rfid`, `comment`, `registerdate`, `status`) VALUES (:vname, :rfid, :remarks, NOW(), '1');");
                                    $insert->execute(array( ':rfid'=>$_POST['rfid'],':vname'=>$_POST['guestname'],':remarks'=>$_POST['guestcomment']));
                                }
                            }
							?>
                            <div class="col-lg-12 alert alert-success" style="margin-top: 80px;">
                                 <h1 class="text-center"><strong><?php echo $_POST['guestname']; ?></strong>  successfully registered!</h1>
                            </div>
                            <script>
                                setTimeout(function(){
                                    window.location.href = 'visitor.php';
                                }, 2000);
                            </script>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script type="application/javascript" src="assets/js/jquery.min.js"></script>
	<script type="application/javascript" src="assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<script>
			
</script>
</html>