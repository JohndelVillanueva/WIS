<?php
include_once "includes/config.php";
//ini_set('display_errors', 0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

    if (!empty($_POST['uniform_type_id']) && !empty($_POST['uniform_size_id']) && !empty($_POST['qty']) && !empty($_POST['gender'])) {

        $insertingToChildTable = $DB_con->prepare("INSERT INTO uniform_inventory (uniform_type_id,uniform_size_id,qty,gender,date,user) VALUES (:uniform_type_id,:uniform_size_id,:qty,:gender,:date,:user)");
        $result = $insertingToChildTable->execute([
            ":uniform_type_id" => $_POST['uniform_type_id'],
            ":uniform_size_id" => $_POST['uniform_size_id'],
            ":qty" => $_POST['qty'],
            ":gender" => $_POST['gender'],
            ":date" => date("Y-m-d H:i:s"),
            ":user" => $_SESSION['fname'] . " " . $_SESSION['lname']
        ]);
        // var_dump($result);
        // die();
        header("location: show-uniform-inventory.php");
        // echo "successfully Inserted " . $_POST['uniform_type_id'];
    }
?>