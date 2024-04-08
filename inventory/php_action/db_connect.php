<?php 	

$localhost = "localhost";
$username = "inventory";
$password = "58!o44Fmz4DbjFGS";
$dbname = "inventory";
$store_url = "http://10.10.10.10/inventory/";
// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);
// check connection
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}

?>