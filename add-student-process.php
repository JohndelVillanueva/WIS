<?php 
include_once "includes/config.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $lastName = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
    $firstName = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
    $middleName = filter_input(INPUT_POST, 'mname', FILTER_SANITIZE_STRING);
    $asid = filter_input(INPUT_POST, 'asid', FILTER_SANITIZE_NUMBER_INT);

    // Check for required fields
    if (empty($lastName) || empty($firstName) || empty($asid)|| empty($middleName)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields.']);
        exit;
    }

    try {
        // Start a transaction
        $DB_con->beginTransaction();

        // Insert into the afterschool_students table
        $stmt = $DB_con->prepare("
            INSERT INTO afterschool_students (lname, fname, mname) 
            VALUES (:lname, :fname, :mname)
        ");
        $stmt->execute([
            ':lname' => $lastName,
            ':fname' => $firstName,
            ':mname' => $middleName
        ]);

        // Get the last inserted ID
        $lastId = $DB_con->lastInsertId();

        // Insert into the afterschool_enrolled table
        $enrollStudent = $DB_con->prepare("
            INSERT INTO afterschool_enrolled (sid, asid, student_name, enrolldate) 
            VALUES (:sid, :asid, :student_name, NOW())
        ");
        $enrollStudent->execute([
            ':sid' => $lastId,
            ':asid' => $asid,
            ':student_name' => $firstName . ' ' . $lastName
        ]);

        // Commit the transaction
        $DB_con->commit();

        // Redirect after successful enrollment
        header("Location: show-others.php?id=" . $_GET['id'] . "&activity=" . $_GET['Activity']);
        exit;

    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $DB_con->rollBack();
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>