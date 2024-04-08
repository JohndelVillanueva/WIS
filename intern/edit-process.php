<?php
require("includes.php");

$getdetails = $DB_con->prepare("UPDATE ojt SET name = :name, address = :address, email = :email, region = :region, country = :country WHERE id = :id");
$getdetails->execute(array(
    ":name"=>$_POST["name"],
    ":address"=>$_POST["address"],
    ":email"=>$_POST["email"],
    ":region"=>$_POST["region"],
    ":country"=>$_POST["country"],
    ":id"=>$_POST["id"]
));

header("location: index.php");