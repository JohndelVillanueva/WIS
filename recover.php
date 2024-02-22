<?php
include_once "includes/config.php";
session_start();

if($_SESSION['level']!==9){
	header("location: dashboard.php");
}

if (isset($_REQUEST['submit'])) {
    $username = strip_tags($_REQUEST["username"]);
    $email = strip_tags($_REQUEST["username"]);
    $password = strip_tags($_REQUEST["password"]);

    if (empty($username)) {
        $errorMsg[] = "Enter username or email";
    } else if (empty($email)) {
        $errorMsg[] = "Enter username or email";
    } else if (empty($password)) {
        $errorMsg[] = "Enter Password";
    } else {
        try {
            $select_stmt = $DB_con->prepare("SELECT * FROM user WHERE username=:uname OR email=:uemail");
            $select_stmt->execute(array(':uname' => $username, ':uemail' => $email));
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if ($select_stmt->rowCount() > 0) {
                if ($username == $row["username"] or $email == $row["email"]) {
                    $update = $DB_con->prepare("UPDATE user SET password = :password WHERE id = :id");
					$update->execute(array(':password' => password_hash($password, PASSWORD_DEFAULT), ':id' => $row['id']));
					$resetMsg[] = "Successfully updated the password!";
					header("refresh:1; login.php");
                } else {
                    $errorMsg[] = "Incorrect Username /  Email";
                }
            } else {
                $errorMsg[] = "Incorrect Username /  Email";
            }
        } catch (PDOException $e) {
            $e->getMessage();
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
                                <p class="m-b-30">Reset your password</p>
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
								if (isset($resetMsg)) {
                                    foreach ($resetMsg as $reset) {
                                        ?>
                                        <div class="alert alert-danger">
                                            <strong><?php print $reset; ?></strong>
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
                                        <label class="font-weight-semibold" for="userName">Username:</label>
                                        <div class="input-affix">
                                            <i class="prefix-icon anticon anticon-user"></i>
                                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" autofocus>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-semibold" for="password">New Password:</label>
                                        <div class="input-affix m-b-10">
                                            <i class="prefix-icon anticon anticon-lock"></i>
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Sign In</button>
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

<?php
