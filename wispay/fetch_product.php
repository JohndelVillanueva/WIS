<?php
if (isset($_GET['type_id'])) {
    $type_id = intval($_GET['type_id']);

    // Prepare the query to fetch products based on the type
    $getProductsQuery = $DB_con->prepare("SELECT * FROM products WHERE type_id = :type_id");
    $getProductsQuery->bindParam(':type_id', $type_id, PDO::PARAM_INT);
    $getProductsQuery->execute();
    $products = $getProductsQuery->fetchAll(PDO::FETCH_OBJ);

    // Return the products as JSON
    echo json_encode($products);
}
?>