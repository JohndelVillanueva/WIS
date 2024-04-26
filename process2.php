<?php
include_once "includes/config.php";
session_start();
if($_POST['stage'] == '7') {
    if (isset($_POST["official"])) {
        $process = "UPDATE users24 SET status = :status, isofficial = 1 WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));

        echo "official";
    } elseif (isset($_POST["unofficial"])) {
        $process = "UPDATE users24 SET status = :status, isofficial = 0 WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));
        echo "unofficial";
    }
}