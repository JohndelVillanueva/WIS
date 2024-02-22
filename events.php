<?php
$json = array();

$requete = "SELECT * FROM schedule ORDER BY id";


try {
    require "includes/config.php";
} catch(Exception $e) {
    exit('Unable to connect to database.');
}


$resultat = $DB_con->query($requete) or die(print_r($bdd->errorInfo()));


echo json_encode($resultat->fetchAll(PDO::FETCH_ASSOC));

