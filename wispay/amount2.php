<?php
require_once("config/config.php");

$type = $_GET['type'];

$stmt = $DB_con->prepare("SELECT id, name_of_product, price_of_product FROM products WHERE type_of_product = ?");
$stmt->execute([$type]);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($products);
?>