<?php

$DB_host = "localhost";
$DB_user = "intern";
$DB_pass = "ZrcUvr1q2c7)SXZd";
$DB_name = "intern";

try {
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}