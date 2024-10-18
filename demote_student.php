<?php
include_once "includes/config.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the ERN from the form
    $ern = $_POST['ern'];

    // Fetch the current status of the student
    $query = $DB_con->prepare("SELECT status FROM users24 WHERE uniqid = :ern");
    $query->execute(array(':ern' => $ern));
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if ($row && $row['status'] > 0) {
        // Decrease the status by 1
        $newStatus = $row['status'] - 1;

        // Update the student's status in the database
        $update = $DB_con->prepare("UPDATE users24 SET status = :newStatus WHERE uniqid = :ern");
        $update->execute(array(':newStatus' => $newStatus, ':ern' => $ern));

        // Redirect back with a success message
        header("Location: student_list.php?ern=$ern&demoted=true");
        exit();
    } else {
        // Status can't be decreased further
        header("Location: student_list.php?ern=$ern&error=already_minimum");
        exit();
    }
}
?>