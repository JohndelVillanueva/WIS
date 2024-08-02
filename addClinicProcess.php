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

        // $data = [
        //     ":date" => date('F d, Y') // The date is stored as a string
        // ];

        $insertingStudent = $DB_con->prepare("INSERT INTO clinic_history (name, grade, complaint, diagnose, treatment, vital_signs, time_in, time_out, date, remarks) VALUES 
        (:name, :grade, :complaint, :diagnose, :treatment, :vital_signs, :time_in, :time_out, :date, :remark)");

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
            ":date" => date('F d, Y'),
            ":remark" => $_POST['remark']
        ]);

        // Check the result
        if ($result) {
            // var_dump($data);
            // die();
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
