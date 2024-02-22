<?php
include_once("./includes/config.php");

$student = $_POST['student'];
$val = $_POST['val'];
// $newVal = $_POST['val'] +1;
$actype = $_POST['actype']; 
if($actype=='Written'){
    
    $pdo_statement = $DB_con->prepare("UPDATE written SET actScore = :actscore WHERE name= '$student' AND actype='Written' AND actnum='$val'");

    $pdo_statement->bindParam(':actscore', $_POST['actScore']);
    $pdo_statement->execute();
   
}
if($actype=='Performance'){
    
    $pdo_statement = $DB_con->prepare("UPDATE performancetask SET actScore = :actscore WHERE name= '$student' AND actype='Performance' AND actnum='$val'");

    $pdo_statement->bindParam(':actscore', $_POST['actScore']);
    $pdo_statement->execute();
   
}
if($actype=='Quarterly'){
    
    $pdo_statement = $DB_con->prepare("UPDATE quarterly SET actScore = :actscore WHERE name= '$student' AND actype='Quarterly' AND actnum='$val'");

    $pdo_statement->bindParam(':actscore', $_POST['actScore']);
    $pdo_statement->execute();
   
}
header("Location: edit-record.php?update=success");
die();