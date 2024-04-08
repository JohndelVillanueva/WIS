<html>
	<head>
		<link rel="stylesheet" href="assets/vendors/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body>
		<form method="post" action="profile.php">
		<div class="container vh-100" style="width:700px;">
			<div class="d-flex align-items-center" style ="height: 100%">
				<div class="col-md-12 animateMe">
					<div class="wrapper p-5">
						<div class="logo"><img src="assets/images/logo/main.png" style="max-width: 200px;margin-top: -100px;"></div>	
						<div class="row">
							<div class="col-sm-12 d-flex align-items-center">
							</div>
						</div>
						<h1 id="clock" onload="currentTime()" style="font-weight: 600;padding-top:30px;font-size:3.5em"></h1><br>
						<input class="form-control form-control-lg bg-transparent border-0 text-center"  style="color: transparent;text-shadow: 0 0 0 black;" type="password" name="rfid" autofocus>
						<button type="submit" style="display:none">Scan</button>
						<div class="logo"><img class="rfidLogo" src="assets/images/logo/rfid.png" style="max-width: 50px;margin-top: -50px;opacity:0.5;"></div>	
					</div>
				</div>
			</div>
		</div>
		</form>
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