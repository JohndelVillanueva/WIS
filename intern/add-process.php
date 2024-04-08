<?php
require("includes.php");

$getdetails = $DB_con->prepare("INSERT INTO ojt (name, address, email, region, country) VALUES (:name, :address, :email, :region, :country)");
$getdetails->execute(array(
    ":name"=>$_POST["name"],
    ":address"=>$_POST["address"],
    ":email"=>$_POST["email"],
    ":region"=>$_POST["region"],
    ":country"=>$_POST["country"]
));

header("location: index.php");