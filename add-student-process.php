<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}

if (isset($_GET["asid"], $_GET["fname"], $_GET["mname"], $_GET["lname"])) {
    
    // Begin a transaction to ensure both inserts succeed or fail together
    $DB_con->beginTransaction();
    
    try {
        // Insert student details
        $addstudent = $DB_con->prepare("INSERT INTO afterschool_students (fname, mname, lname) VALUES (:fname, :mname, :lname)");
        $addstudent->execute(array(
            ":fname" => $_GET["fname"],
            ":mname" => $_GET["mname"],
            ":lname" => $_GET["lname"],
        ));
        
        // Retrieve last inserted ID directly from the PDO object
        $lastId = $DB_con->lastInsertId();
        
        // Insert into enrollment table
        $enrollstudent = $DB_con->prepare("INSERT INTO afterschool_enrolled (sid, asid, student_name, enrolldate) VALUES (:sid, :asid,:student_name, NOW())");
        $enrollstudent->execute(array(
            ":sid" => $lastId,
            ":asid" => $_GET["asid"],
            ":student_name" => $_GET["fname"]. " ". $_GET["lname"]
        ));
        
        // Commit the transaction
        $DB_con->commit();
        
        // Redirect to the specified page
        header("location: show-others.php?id=" . $_GET["asid"]. "&activity=". $_GET["activity"]);
        exit();
        
    } catch (PDOException $e) {
        // Roll back the transaction if any query fails
        $DB_con->rollBack();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Required data is missing.";
}