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
                    <form action="profile.php" method="post">
                        <div class="form-group">
                            <input type="password" class="form-control form-group-lg" name="rfid" id="rfid" autofocus tabindex="0" required>
                            <input type="hidden" name="lasttouch" value="<?php echo $_SESSION['name']; ?>">
                            <button type="submit" class="hidden" name="submit">Scan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="badgescard"> <a href="logout.php"><span class="glyphicon glyphicon-log-out"></span><?php echo $_SESSION['name']; ?> is processing WISpay&trade;</a></div>
    </div>
</body>
<?php include_once 'footer.php'; ?>