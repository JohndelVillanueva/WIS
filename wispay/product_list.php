<?php
require_once("config/config.php");
session_start();

$id = $_SESSION['username'];

if (!isset($_SESSION['username'])) {
    header("location: index.php");
}

include_once("headers.php");
?>

<body>
    <div class="wrapper">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
        <?php include_once("sidemenu.php"); ?>
        <div class="main">
            <?php include_once("topbar.php"); ?>
            <!-- CONTENT STARTS HERE !-->
            <main class="content">
                <!-- Add Product Modal -->
                <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="addProductForm" method="post" action="productProcess/add_product.php">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="addProductCode" class="form-label">Product Code</label>
                                        <input type="text" class="form-control" id="addProductCode" name="product_code" placeholder="ex. Mil" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="addProductType" class="form-label">Product Type</label>
                                        <?php

                                        $typeProductQuery = $DB_con->prepare("SELECT * FROM type_of_products");
                                        $typeProductQuery->execute();
                                        $types = $typeProductQuery->fetchAll(PDO::FETCH_OBJ);

                                        ?>
                                        <select class="form-control" id="addProductType" name="type_of_product" required>
                                            <option value="">Select a product type</option>
                                            <?php foreach ($types as $type) : ?>
                                                <option value="<?= $type->name ?>"><?= $type->name ?></option>
                                            <?php endforeach; ?>
                                            <!-- Add more options as needed -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="addProductName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="addProductName" name="name_of_product" placeholder="ex. Milktea" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="addProductPrice" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="addProductPrice" name="price_of_product" placeholder="240" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="editForm" method="post" action="productProcess/update_product.php">
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="editProductId">
                                    <div class="mb-3">
                                        <label for="editProductCode" class="form-label">Product Code</label>
                                        <input type="text" class="form-control" id="editProductCode" name="product_code" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductType" class="form-label">Product Type</label>
                                        <input type="text" class="form-control" id="editProductType" name="type_of_product" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="editProductName" name="name_of_product" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editProductPrice" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="editProductPrice" name="price_of_product" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="container-fluid p-0">
                    <div class="container-fluid d-flex justify-content-end">
                        <button class="btn btn-primary" id="addProductButton" data-bs-toggle="modal" data-bs-target="#addProductModal" style="background-color: purple; border-color: purple; color: white;">
                            Add New Product
                        </button>
                    </div><br>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header"><b class="fs-5">Products</b></div>
                                <div class="card-body">
                                    <!-- DataTable -->
                                    <table id="productsTable" class="display table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Product Code</th>
                                                <th>Product Type</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Date Created</th>
                                                <th>Mark by</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Fetch data from the database
                                            $pdo_statement = $DB_con->prepare("SELECT * FROM products LIMIT 50");
                                            $pdo_statement->execute();
                                            $result = $pdo_statement->fetchAll(PDO::FETCH_OBJ);

                                            // Display each product in a table row
                                            foreach ($result as $row) {
                                            ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($row->product_code) ?></td>
                                                    <td><?= htmlspecialchars($row->type_of_product) ?></td>
                                                    <td><?= htmlspecialchars($row->name_of_product) ?></td>
                                                    <td><?= htmlspecialchars($row->price_of_product) ?></td>
                                                    <td><?= htmlspecialchars($row->date_created) ?></td>
                                                    <td><?= htmlspecialchars($row->last_touch) ?></td>
                                                    <td>
                                                        <!-- Edit button -->
                                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= htmlspecialchars($row->id) ?>" data-product_code="<?= htmlspecialchars($row->product_code) ?>" data-name_of_product="<?= htmlspecialchars($row->name_of_product) ?>" data-price_of_product="<?= htmlspecialchars($row->price_of_product) ?>" data-type_of_product="<?= htmlspecialchars($row->type_of_product) ?>">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                        <!-- Delete button -->
                                                        <a href="productProcess/delete_product.php?id=<?= htmlspecialchars($row->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            <!-- CONTENT ENDS HERE !-->
            <?php include_once("footer.php"); ?>
        </div>
    </div>

    <!-- <?php include_once("scripts.php"); ?> -->
</body>
<script>
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var id = button.getAttribute('data-id');
        var productCode = button.getAttribute('data-product_code');
        var productName = button.getAttribute('data-name_of_product');
        var productPrice = button.getAttribute('data-price_of_product');
        var productType = button.getAttribute('data-type_of_product');

        // Update the modal's content with the data
        var modalTitle = editModal.querySelector('.modal-title');
        var modalBodyIdInput = editModal.querySelector('#editProductId');
        var modalBodyCodeInput = editModal.querySelector('#editProductCode');
        var modalBodyNameInput = editModal.querySelector('#editProductName');
        var modalBodyPriceInput = editModal.querySelector('#editProductPrice');
        var modalBodyTypeInput = editModal.querySelector('#editProductType');

        modalTitle.textContent = 'Edit Product ' + productName;
        modalBodyIdInput.value = id;
        modalBodyCodeInput.value = productCode;
        modalBodyNameInput.value = productName;
        modalBodyPriceInput.value = productPrice;
        modalBodyTypeInput.value = productType;
    });

    $(document).ready(function() {
        $('#productsTable').DataTable();
    });
    
    
</script>
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
</html>