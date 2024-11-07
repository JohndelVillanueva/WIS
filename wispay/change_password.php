<?php
require_once("config/config.php"); // Include your database connection file
session_start();

if (!isset($_SESSION['id'])) {
    echo "User ID not set in session.";
    exit;
}

$userId = $_SESSION['id'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Input validation
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo "All fields are required.";
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        echo "New password and confirm password do not match.";
        exit;
    }

    try {
        // Fetch the current password hash from the database
        $stmtSelect = $DB_con->prepare("SELECT password FROM user WHERE id = :user_id");
        $stmtSelect->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmtSelect->execute();
        $user = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "User not found in the database.";
            exit;
        }

        if (!password_verify($currentPassword, $user['password'])) {
            echo "Current password is incorrect.";
            exit;
        }

        // Hash the new password
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $stmtUpdate = $DB_con->prepare("UPDATE user SET password = :new_password WHERE id = :user_id");
        $stmtUpdate->bindParam(':new_password', $newHashedPassword, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':user_id', $userId, PDO::PARAM_INT);

        if ($stmtUpdate->execute()) {
            // Redirect with success parameter
            header('Location: dashboard.php?password_changed=success');
            exit;
        } else {
            echo "Error updating password. Please try again.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>
