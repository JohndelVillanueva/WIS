<?php
include_once "includes/config.php";
session_start();

if(isset($_POST["Export"])){
    ob_start();
    $filename = "students_".$_POST["gradelevel"].$_POST["section"]."_".date("Ymd").".csv";
    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    ob_end_clean();
    $output = fopen("php://output", "w");
    fputcsv($output, array("Last Name", "First Name", "Middle Name", "Date of Birth","Gender", "LRN", "Previous School", "Nationality", "House"));

    $pdo_statement = $DB_con->prepare("SELECT lname, fname, mname, dob, gender, lrn, prevsch, nationality, house FROM users24 WHERE grade = :grade AND section = :section");
    $pdo_statement->execute(array(":grade"=>$_POST["gradelevel"], ":section"=>$_POST["section"]));
    $result = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row=>$line) {
        fputcsv($output, $line);
    }
    fclose($output);
    exit;
}