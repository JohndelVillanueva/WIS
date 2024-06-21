<?php
/*
 * DB Class
 * This class is used for database related (connect, insert, update, and delete) operations
 * with PHP Data Objects (PDO)
 *
 */

$database_username = 'attuser';
$database_password = '9qRs6Hx8T!lXcz1w';
$pdo_conn = new PDO( 'mysql:host=localhost;dbname=attendance', $database_username, $database_password );

$DB_host = "localhost";
$DB_user = "attuser";
$DB_pass = "9qRs6Hx8T!lXcz1w";
$DB_name = "attendance";

try {
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    echo $e->getMessage();
}

include_once './classes/class.crud.php';

$crud = new crud($DB_con);

