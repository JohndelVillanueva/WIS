<?php
require_once 'classes/db.php';
session_start();

if(isset($_SESSION["name"])) {
    header("location: pay.php");
}
    if(empty($_POST['rfid'])) {
        //$errorMsg[]="";
    } else {
        try {
            $select_stmt=$db->prepare("SELECT * FROM user WHERE rfid=:rfid");
            $select_stmt->execute(array(':rfid'=>$_POST['rfid']));
            $row=$select_stmt->fetch(PDO::FETCH_ASSOC);

            if($select_stmt->rowCount() > 0) {
                if ($_POST['rfid'] == $row["rfid"]) {
                    $_SESSION["name"] = $row["fname"] . " " . $row["lname"];
                    $_SESSION["position"] = $row["position"];

                    $loginMsg = "<a href='pay.php' class='btn btn-primary btn-block'><span class=\"glyphicon glyphicon-shopping-cart\"></span> Start WISpay&trade;</a><br>
                                 <a href='history.php' class='btn btn-primary btn-block'><span class=\"glyphicon glyphicon-list\"></span> Check WISpay&trade; Balance</a>";
                    //header("refresh:1; pay.php");
                    if($row["rfid"]=="880696139" || $row["rfid"]=="880200763" || $row["rfid"]=="883939387" || $row["rfid"]=="875545675"|| $row["rfid"]=="3218209891") {
                        $loginMsg .= "<br><a href='reload.php' class='btn btn-primary btn-block'><span class=\"glyphicon glyphicon-usd\"></span> Reload WISpay&trade;</a><br>
                                      <a href='report.php' class='btn btn-primary btn-block'><span class=\"glyphicon glyphicon-calendar\"></span> WISpay&trade; Report</a>";
                    } if($row["rfid"]=="351640807"){
                        $loginMsg .= "<br><a href='report.php' class='btn btn-primary btn-block'><span class=\"glyphicon glyphicon-calendar\"></span> WISpay&trade; Report</a>";
                    }
                }
            }
            else {
                $errorMsg[]="Your e-mail or username is wrong!";
            }
        }
        catch(PDOException $e) {
            $e->getMessage();
        }
}
?>
<!--
      WIS PORTAL 0.2beta

      Author: Chester Sigua
      Email: cio@westfields.edu.ph
!-->
<!DOCTYPE html>
<html lang="en">

<?php require_once("header.php"); ?>

<body class="loginform">
<div class="content">
    <div class="card">
        <div class="firstinfo"><img src="img/wispay.png"/>
            <div class="profileinfo">
                <form method="post">
                    <div class="form-group">
                        <?php if(isset($_SESSION["name"])) {
                            if(isset($errorMsg))
                            {
                                foreach($errorMsg as $error)
                                {
                                    ?>
                                    <div class="alert alert-danger">
                                        <strong><?php echo $error; ?></strong>
                                    </div>
                                    <?php
                                }
                            }
                            if(isset($loginMsg))
                            {
                                 echo $loginMsg;
                            }
                        } else {
                            echo "<input type=\"password\" name=\"rfid\" id=\"rfid\" class=\"form-control form-control-lg\" autofocus placeholder=\"Enter RFID\" /><br>
                        <button class=\"btn btn-primary btn-block \" type=\"submit\" name=\"btn_login\">Login</button>";
                        }

                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="badgescard">
        <?php if(isset($_SESSION["name"])) {
            echo "<a href=\"logout.php\"><span class=\"glyphicon glyphicon-log-out\"></span>".$_SESSION['name']." is processing WISpay&trade;</a>";
        } else {
          echo "<span class=\"glyphicon glyphicon-qrcode\"></span>Tap your ID to login to WISpay&trade;";
        }
        ?>
    </div>
</div>
</body>
<?php require_once("footer.php"); ?>
</body>

</html>