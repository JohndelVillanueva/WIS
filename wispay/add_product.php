<?php 
include_once("config/config.php");
//ini_set('display_errors', 0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

// Add new Product
if (isset($_POST['product_code'], $_POST['type_of_product'], $_POST['name_of_product'], $_POST['price_of_product'])) {
    // Prepare the update query
    $storeQueryProduct = $DB_con->prepare("INSERT INTO products (product_code, type_of_product, name_of_product, price_of_product, date_created, last_touch) VALUES (?,?,?,?,?,?)");
    $storeQueryProduct->execute([
        $_POST['product_code'], 
        $_POST['type_of_product'], 
        $_POST['name_of_product'], 
        $_POST['price_of_product'], 
        date('Y-m-d H:i:s'), 
        $_SESSION['fname'] . ' ' . $_SESSION['lname'],
    ]);

    // Redirect back to the products page or display a success message
    header('Location: product_list.php');
    exit();
} else {
    echo 'Required POST data is missing';
    die();
}