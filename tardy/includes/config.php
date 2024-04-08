<?php
$DB_host = "10.10.10.10";
$DB_user = "u652554119_admissions";
$DB_pass = "kk_eBcbMy4E0xc/D";
$DB_name = "u652554119_admissions";

try {
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}