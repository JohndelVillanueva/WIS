<?php
require_once 'classes/db.php';

session_start();

if (!isset($_SESSION['name'])) {
    header("location: index.php");
}
include_once 'header.php';
?>
<body class="loginform">
    <div class="content">
        <div class="card">
            <div class="firstinfo"><img src="img/wispay.png"/>
                <div class="profileinfo">
                    <form action="reloadprofile.php" method="get">
                        <div class="form-group">
                            <input type="password" class="form-control" name="rfid" id="rfid" autofocus tabindex="0" required>
                            <button type="submit" class="hidden" name="submit">Scan</button><br>
                            <a href="showprofiles.php" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Search Student</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="badgescard"> <span class="glyphicon glyphicon-qrcode"></span><?php echo $_SESSION['name']; ?> is reloading WISpay&trade;</div>
    </div>
</body>
<?php include_once 'footer.php'; ?>