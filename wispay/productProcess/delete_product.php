<?php 
include_once("../config/config.php");
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepare the delete query
    $deleteQuery = $DB_con->prepare("DELETE FROM products WHERE id = ?");
    $deleteQuery->execute([$product_id]);

    // Check if the delete was successful
    if ($deleteQuery->rowCount() > 0) {
        echo '<script type="text/javascript">
            // alert("Product deleted successfully.");
            window.location.href = "../product_list.php";
        </script>';
    } else {
        echo '<script type="text/javascript">
            alert("Error: Product not found or already deleted.");
            window.location.href = "../product_list.php";
        </script>';
    }
} else {
    echo 'Invalid request';
}
?>
