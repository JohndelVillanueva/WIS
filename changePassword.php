<?php
include_once "includes/config.php";
session_start();

if(!isset($_SESSION['id'])){
    header('location: login.php');
}else{
        // Getting the user ID thri session
        $id = $_SESSION['id'];
        // this if statement checking the input text box if fill
        if(isset($_POST['password'], $_POST['newPassword'], $_POST['confirmPassword'])){
            // accessing thru form POST method
            $currentPassword = $_POST['password'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            // checking if match the new And Confirm
            if (empty($newPassword) || empty($confirmPassword)) {
            echo "New password and confirm password not fill";
            }else if ($newPassword != $confirmPassword){
            echo "New password and confirm password do not match";
        }else {
                // select query to get the current password
                $changingPassword = $DB_con->prepare("SELECT `password` FROM user WHERE id = :id");
                $changingPassword->execute(array(':id' => $id));
                $confirmingPassword = $changingPassword->fetch(PDO::FETCH_ASSOC);

                if($confirmingPassword && password_verify($currentPassword, $confirmingPassword['password'])){
                    $hshPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    // if the new And confrim password match execute this query
                    $updateConfirm = $DB_con->prepare("UPDATE user SET password = :password WHERE id = :id");
                        if ($updateConfirm->execute(array(':password' => $hshPassword, ':id' => $id))) {
                        echo "Password changed successfully.";
                        }
                    header("location: dashboard.php");
                }else {
                echo "Current password is incorrect.";
                }
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Westfields International School - Portal</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png">

    <!-- page css -->

    <!-- Core css -->
    <link href="assets/css/app.min.css" rel="stylesheet">
	<style>
		body {
			font-family: "Friz Quadrata Std Medium", sans-serif!important;
		}
	</style>

</head>

<body>
<form action="" method="post">
    <div class="app">
        <div class="container-fluid p-0 h-100">
            <div class="row no-gutters h-100 full-height">
                <div class="col-lg-4 d-none d-lg-flex bg" style="background-image:url('assets/images/others/cover.jpg')">
                    <div class="d-flex h-100 p-h-40 p-v-15 flex-column justify-content-between">
                        <div>
                            <img src="assets/images/logo/logo-white.png" alt="">
                        </div>
                        <div>
                            <h1 class="text-white m-b-20 font-weight-normal">Westfields International School</h1>
                            <p class="text-white font-size-16 lh-2 w-80 opacity-08">We don't limit their challenges, we challenge their limits! Unlock your potential at Westfields International School.</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-white">© 2023 WIS ICT</span>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-white text-link" href="https://fb.me/WestfieldsInternationalSchool">Facebook</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 bg-white">
                    <div class="container h-100">
                        <div class="row no-gutters h-100 align-items-center">
                            <div class="col-lg-8 col-lg-7 col-xl-6 mx-auto">
                                <h2>Westfields International School Portal</h2>
                                <p class="m-b-30">Sign in to get access</p>
                                <?php
                                if (isset($errorMsg)) {
                                    foreach ($errorMsg as $error) {
                                        ?>
                                        <div class="alert alert-danger">
                                            <strong><?php echo $error; ?></strong>
                                        </div>
                                        <?php
                                    }
                                }
                                if (isset($loginMsg)) {
                                    ?>
                                    <div class="alert alert-success">
                                        <strong><?php echo $loginMsg; ?></strong>
                                    </div>
                                    <?php
                                }
                                ?>
                                <form>
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="password">Old Password:</label>
                                        <div class="input-affix">
                                            <i class="prefix-icon anticon anticon-user"></i>
                                            <input type="text" class="form-control" name="password" id="password" placeholder="Old Password" autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="password">New Password:</label>
                                        <div class="input-affix">
                                            <i class="prefix-icon anticon anticon-user"></i>
                                            <input type="text" class="form-control" name="newPassword" id="newPassword" placeholder="New Password" autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="password">Confirm New Password:</label>
                                        <div class="input-affix">
                                            <i class="prefix-icon anticon anticon-user"></i>
                                            <input type="text" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="New Password" autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Core Vendors JS -->
    <script src="assets/js/vendors.min.js"></script>

    <!-- page js -->

    <!-- Core JS -->
    <script src="assets/js/app.min.js"></script>
</form>
</body>

</html>