<?php 
include_once("config/config.php");
//ini_set('display_errors', 0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

// Get the product data from the POST request
if (isset($_POST['product_code'], $_POST['type_of_product'], $_POST['name_of_product'], $_POST['price_of_product'], $_POST['id'])) {
    // Prepare the update query
    $updateProductQuery = $DB_con->prepare("UPDATE products SET product_code = ?, type_of_product = ?, name_of_product = ?, price_of_product = ?, date_created = ?, last_touch = ? WHERE id = ?");
    $updateProductQuery->execute([
        $_POST['product_code'], 
        $_POST['type_of_product'], 
        $_POST['name_of_product'], 
        $_POST['price_of_product'], 
        date('Y-m-d H:i:s'), 
        $_SESSION['fname'] . ' ' . $_SESSION['lname'],
        $_POST['id']
    ]);

    // Redirect back to the products page or display a success message
    header('Location: product_list.php');
    exit();
} else {
    echo 'Required POST data is missing';
    die();
}


// var_dump($updateProductQuery);
?>