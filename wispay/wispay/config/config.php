<?php
$DB_host = "localhost";
$DB_user = "attuser";
$DB_pass = "9qRs6Hx8T!lXcz1w";
$DB_name = "attendance";

try {
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}", $DB_user, $DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}