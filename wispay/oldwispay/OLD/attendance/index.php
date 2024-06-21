<?php
include_once 'classes/dbclass.php';
include_once 'header.php';
?>
<body class="loginform">
    <div class="content">
        <div class="card">
            <div class="firstinfo"><img src="img/wislogo.jpg"/>
                <div class="profileinfo">
                    <h1 id="clock" onload="currentTime()" class="my-4" style="font-weight: 600;">00:00:00</h1>
                    <form action="profile.php" method="post">
                        <div class="form-group">
                            <input type="password" class="form-control" name="rfid" id="rfid" autofocus tabindex="0" required>
                            <button type="submit" class="hidden" name="submit">Scan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="badgescard"> <span class="glyphicon glyphicon-qrcode"></span>Tap your ID to Clock In.</div>
    </div>
</body>
<?php include_once 'footer.php'; ?>