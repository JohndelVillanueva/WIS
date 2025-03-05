<?php
require_once("config/config.php");
session_start();

$errorMsg = [];
$signupMsg = '';

if (isset($_POST['signup'])) {
    // Get form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // var_dump($username, $email, $password, $confirm_password);
    // die();

    // Validation
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
            $stmt = $DB_con->prepare("SELECT * FROM user WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->rowCount() > 0) {
                $errorMsg[] = 'Username already exists';
            }

            // Check email
            $stmt = $DB_con->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $errorMsg[] = 'Email already registered';
            }

            // Insert new user
            if (empty($errorMsg)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $DB_con->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
                $stmt->execute([$username, $email, $hashed_password]);

                if ($stmt->rowCount() > 0) {
                    // Redirect immediately after successful insertion
                    header("Location: index.php");
                    exit(); // Always exit after header redirect
                } else {
                    $errorMsg[] = 'Registration failed. Please try again.';
                }
            }
        } catch (PDOException $e) {
            $errorMsg[] = 'Database error: ' . $e->getMessage();
        }
    }
}