<?php
session_start();
require_once("config/config.php");

$errorMsg = [];
$signupMsg = '';

if (isset($_POST['signup'])) {
    // Get form data
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validation
    if (empty($firstname)) {
        $errorMsg[] = 'First name is required';
    } elseif (!preg_match('/^[a-zA-Z \-\']+$/', $firstname)) {
        $errorMsg[] = 'First name can only contain letters, spaces, hyphens, and apostrophes';
    }

    if (empty($lastname)) {
        $errorMsg[] = 'Last name is required';
    } elseif (!preg_match('/^[a-zA-Z \-\']+$/', $lastname)) {
        $errorMsg[] = 'Last name can only contain letters, spaces, hyphens, and apostrophes';
    }

    if (empty($username)) {
        $errorMsg[] = 'Username is required';
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $errorMsg[] = 'Username can only contain letters, numbers, and underscores';
    }

    if (empty($email)) {
        $errorMsg[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMsg[] = 'Invalid email format';
    }

    if (empty($password)) {
        $errorMsg[] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errorMsg[] = 'Password must be at least 8 characters';
    }

    if ($password !== $confirm_password) {
        $errorMsg[] = 'Passwords do not match';
    }

    // Check if user exists
    if (empty($errorMsg)) {
        try {
            // Check username
            $stmt = $DB_con->prepare("SELECT id FROM user WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->rowCount() > 0) {
                $errorMsg[] = 'Username already exists';
            }

            // Check email
            $stmt = $DB_con->prepare("SELECT id FROM user WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $errorMsg[] = 'Email already registered';
            }

            // Insert new user
            if (empty($errorMsg)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $DB_con->prepare("INSERT INTO user (fname, lname, username, email, password) VALUES (?, ?, ?, ?, ?)");
                if ($stmt->execute([$firstname, $lastname, $username, $email, $hashed_password])) {
                    $_SESSION['signup_success'] = true;
                    header("Location: index.php");
                    exit();
                }
            }
        } catch (PDOException $e) {
            $errorMsg[] = "Error: " . $e->getMessage();
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
    <title>WIS ERP - Sign Up</title>
    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
</head>

<body class="login">
    <div class="main">
        <!-- Removed outer form tag -->
        <section class="sign-up">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-image">
                        <figure><img src="images/pay-logo.png" alt="sign up image"></figure>
                    </div>

                    <div class="signup-form">
                        <h2 class="form-title wisfont">Create Account</h2>
                        <!-- Single form element -->
                        <form method="POST" class="register-form" id="signup-form">
                            <div class="form-group">
                                <label for="firstname"><i class="zmdi zmdi-account-box"></i></label>
                                <input class="wisfont" type="text" name="firstname" id="firstname"
                                    placeholder="First Name" required
                                    value="<?= isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="lastname"><i class="zmdi zmdi-account-box-o"></i></label>
                                <input class="wisfont" type="text" name="lastname" id="lastname"
                                    placeholder="Last Name" required
                                    value="<?= isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input class="wisfont" type="text" name="username" id="username"
                                    placeholder="User Name" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input class="wisfont" type="email" name="email" id="email"
                                    placeholder="Your Email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                            </div>
                            <div class="form-group">
                                <label for="password"><i class="zmdi zmdi-lock"></i></label>
                                <input class="wisfont" type="password" name="password" id="password"
                                    placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input class="wisfont" type="password" name="confirm_password" id="confirm_password"
                                    placeholder="Confirm Password" required>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit wisfont"
                                    value="Register">
                            </div>
                            <div class="form-group login-link">
                                <p class="wisfont">Already have an account? <a href="index.php" class="login">Log In</a></p>
                            </div>
                        </form>
                        <?php
                        if (!empty($errorMsg)) {
                            foreach ($errorMsg as $error) {
                                echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>';
                            }
                        }
                        ?>
                        <div class="social-login">
                            <span class="social-label">This is a private system. Copyright &copy; WIS ICT.</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="vendor/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>