<?php
$DB_host = "localhost";
$DB_user = "u652554119_admissions";
$DB_pass = "qQ5xkDk!yLzMui.f";
$DB_name = "u652554119_admissions";

try {
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}