<?php
include_once 'classes/dbclass.php';
include_once 'header.php';
?>
<body class="loginform">
    <div class="content">
        <div class="card">
            <div class="firstinfo"><img src="img/wispay.png"/>
                <div class="profileinfo">
                    <form action="showhistory.php" method="post">
                        <div class="form-group">
                            <input type="password" class="form-control" name="rfid" id="rfid" autofocus tabindex="0" required>
                            <button type="submit" class="hidden" name="submit">Scan</button>
				<a href="showbalance.php" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search Student</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="badgescard"> <span class="glyphicon glyphicon-qrcode"></span>Tap your ID to use WISpay&trade;</div>
    </div>
</body>
<?php include_once 'footer.php'; ?>