<?php

require_once("config/config.php");
session_start();

$id = $_SESSION['username'];

if(!isset($_SESSION['username']))
{
    header("location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_type = trim($_POST['new_type']); // Trimming any leading/trailing spaces

    // Basic validation to check if the input is empty
    if (empty($new_type)) {
        echo "error: empty type";
        exit;
    }

    try {
        // Check if the type already exists in the database
        $checkStmt = $DB_con->prepare("SELECT id FROM type_of_products WHERE name = :name");
        $checkStmt->bindParam(':name', $new_type);
        $checkStmt->execute();

        if ($checkStmt->rowCount() > 0) {
            echo "error: type already exists";
        } else {
            // Insert the new type into the database
            $stmt = $DB_con->prepare("INSERT INTO type_of_products (name) VALUES (:name)");
            $stmt->bindParam(':name', $new_type);

            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "error: insertion failed";
            }
        }
    } catch (PDOException $e) {
        echo "error: " . $e->getMessage();
    }
}