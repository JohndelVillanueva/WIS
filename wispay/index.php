<?php
require_once("config/config.php");
session_start();

if (isset($_SESSION["username"])) {
    header("location: dashboard.php");
}
if (isset($_SESSION['signup_success'])) {
    echo '<div class="alert alert-success">Registration successful!</div>';
    unset($_SESSION['signup_success']); // Clear the flag
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
                    if (password_verify($password, $row["password"])) {
                        $_SESSION['id'] = $row["id"];
                        $_SESSION["username"] = $row["username"];
                        $_SESSION["fname"] = $row["fname"];
                        $_SESSION["lname"] = $row["lname"];
                        $_SESSION["rfid"] = $row["rfid"];
                        $_SESSION["email"] = $row["email"];
                        $_SESSION["photo"] = $row["photo"];
                        $_SESSION["level"] = $row["level"];
                        $loginMsg = "Login Successful! Redirecting...";
                        header("refresh:2; dashboard.php");
                    } else {
                        $errorMsg[] = "Incorrect Password!";
                    }
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WIS ERP - Sign In</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
</head>
<body class="login">

<div class="main">
    <form action="" method="post">
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/pay-logo.png" alt="sing up image"></figure>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title wisfont">Log In</h2>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input class="wisfont" type="text" name="username" id="username"
                                       placeholder="Email / User Name" autofocus/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input class="wisfont" type="password" name="password" id="password"
                                       placeholder="Password"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="submit" id="submit" class="form-submit wisfont"
                                       value="Log in"/>
                            </div>
                            <div class="form-group signup-link">
                                <p class="wisfont">Don't have an account? <a href="signup.php" class="signup">Sign Up</a></p>
                            </div>
                        </form>
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
                        <div class="social-login">
                            <span class="social-label">This is a private system. Copyright &copy; WIS ICT.</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</div>

<!-- JS -->
<script src="vendor/jquery.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>