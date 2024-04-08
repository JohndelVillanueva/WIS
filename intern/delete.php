<?php
require("includes.php");

$getdetails = $DB_con->prepare("DELETE FROM ojt WHERE id = :id");
$getdetails->execute(array(":id"=>$_GET["id"]));

header("location: index.php");