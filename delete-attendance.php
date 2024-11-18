<?php
include_once "includes/config.php"; // Ensure this file has the correct DB connection setup
session_start();

// Redirect if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit; // Always call exit after redirect to stop script execution
}

// Check if the required parameters are set
if (isset($_GET['sid']) && isset($_GET['asid']) && isset($_GET['activity'])) {
    // Sanitize input to prevent SQL injection
    $sid = intval($_GET['sid']);
    $asid = intval($_GET['asid']);
    $activity = htmlspecialchars($_GET['activity']);
    
    // Prepare the SQL query to delete the attendance record
    $sql = "DELETE FROM afterschool_records WHERE sid = :sid AND asid = :asid AND as_name = :activity AND attend = CURDATE()";
    
    try {
        // Prepare the query with PDO
        $stmt = $DB_con->prepare($sql);
        
        // Bind parameters to the query
        $stmt->bindParam(':sid', $sid, PDO::PARAM_INT);
        $stmt->bindParam(':asid', $asid, PDO::PARAM_INT);
        $stmt->bindParam(':activity', $activity, PDO::PARAM_STR);
        
        // Execute the query
        if ($stmt->execute()) {
            // If deletion is successful, redirect to a page (for example, attendance list or a success page)
            header("Location: other-attendance.php?id=" . $_GET['asid'] . "&activity=" . urlencode($_GET['activity']). "&action=delete");

            exit; // Stop further execution after redirect
        } else {
            // If there was an error with the query execution
            echo "Error executing the query: " . implode(", ", $stmt->errorInfo());
        }
    } catch (PDOException $e) {
        // Catch any PDO errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // If the parameters are not set
    echo "Invalid request.";
}

// Close the database connection (optional as PDO closes automatically when the script ends)
$DB_con = null;
?>
