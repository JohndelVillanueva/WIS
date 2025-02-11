<?php
require_once("config/config.php"); // Include your database connection file
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php'); // Redirect to login page if user is not logged in
    exit;
}

$userId = $_SESSION['id'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token (if you have one)
    // if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    //     die("CSRF token validation failed.");
    // }

    // Get form data
    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Input validation
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['error'] = "All fields are required.";
        header('Location: dashboard.php');
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "New password and confirm password do not match.";
        header('Location: dashboard.php');
        exit;
    }

    // Validate password strength (optional)
    if (strlen($newPassword) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters long.";
        header('Location: dashboard.php');
        exit;
    }

    try {
        // Fetch the current password hash from the database
        $stmtSelect = $DB_con->prepare("SELECT password FROM user WHERE id = :user_id");
        $stmtSelect->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmtSelect->execute();
        $user = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $_SESSION['error'] = "User not found in the database.";
            header('Location: dashboard.php');
            exit;
        }

        // Verify the current password
        if (!password_verify($currentPassword, $user['password'])) {
            $_SESSION['error'] = "Current password is incorrect.";
            header('Location: dashboard.php');
            exit;
        }

        // Hash the new password
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $stmtUpdate = $DB_con->prepare("UPDATE user SET password = :new_password WHERE id = :user_id");
        $stmtUpdate->bindParam(':new_password', $newHashedPassword, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($stmtUpdate->execute()) {
            // Redirect with success message
            $_SESSION['success'] = "Password changed successfully.";
            header('Location: dashboard.php?password_changed=success');
            exit;
        } else {
            $_SESSION['error'] = "Error updating password. Please try again.";
            header('Location: dashboard.php');
            exit;
        }
    } catch (PDOException $e) {
        // Log the error and display a generic message
        error_log("Database error: " . $e->getMessage());
        $_SESSION['error'] = "An error occurred. Please try again later.";
        header('Location: dashboard.php');
        exit;
    }
}
?>