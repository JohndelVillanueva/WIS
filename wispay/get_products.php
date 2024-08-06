<?php
require_once("config/config.php");
header('Content-Type: application/json');

$type_of_product = isset($_POST['type_of_product']) ? $_POST['type_of_product'] : '';

if ($type_of_product === 'drinks') {
    $stmt = $DB_con->prepare("SELECT * FROM products WHERE type_of_product = 'drinks'");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($products);
} else {
    echo json_encode([]);
}
?>