<?php
include_once "includes/config.php";
//ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

if (!empty($_POST['name']) && !empty($_POST['grade']) && !empty($_POST['complaint']) && !empty($_POST['diagnose']) 
    && !empty($_POST['treatment']) && !empty($_POST['vital_signs']) && !empty($_POST['time_in']) && !empty($_POST['time_out'])) {

    try {
        // Prepare the SQL statement
        $insertingStudent = $DB_con->prepare("INSERT INTO clinic_history (name, grade, complaint, diagnose, treatment, vital_signs, time_in, time_out, remarks) VALUES 
        (:name, :grade, :complaint, :diagnose, :treatment, :vital_signs, :time_in, :time_out, :remark)");

        // Execute the statement with the bound parameters
        $result = $insertingStudent->execute([
            ":name" => $_POST['name'],
            ":grade" => $_POST['grade'],
            ":complaint" => $_POST['complaint'],
            ":diagnose" => $_POST['diagnose'],
            ":treatment" => $_POST['treatment'],
            ":vital_signs" => $_POST['vital_signs'],
            ":time_in" => $_POST['time_in'],
            ":time_out" => $_POST['time_out'],
            ":remark" => $_SESSION['fname'] . " " . $_SESSION['lname']
        ]);

        // Check the result
        if ($result) {
            header("location: clinic.php");
            exit();
        } else {
            echo '<script>("Failed to insert record.")</script>';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo '<script>("All fields are required.")</script>';
}
?>
