<?php
include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once "includes/css.php"; ?>


<div class="app is-folded">
    <div class="layout">
        <?php include_once "includes/heading.php"; ?>
        <?php include_once "includes/sidemenu.php"; ?>
        <div class="page-container">
            <div class="main-content">
                <!-- form starts !-->
                <div class="row flex-nowrap overflow-auto">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-warning">
                                <h3 class="pt-2"><span class="icon-holder"><i class="anticon anticon-tags"></i></span> Uniform Inventory</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="btn-group float-right">
                                            <div class="dropdown">
                                                <button class=" dropdown-btn btn btn-danger" type="button" onclick="drpFunction()"> Options </button>
                                                <div id="dropdown-list" class="dropdown-content">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger"> Add New</button>
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#release" class="btn btn-danger">Release Inventory</button>
                                                    <button type="button" class="btn btn-danger">Reports</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Add New Modal-->
                                <?php
                                    if (!empty($_POST['uniform_type_id']) && !empty($_POST['uniform_size_id']) && !empty($_POST['qty']) && !empty($_POST['gender'])) {

                                        $insertingToChildTable = $DB_con->prepare("INSERT INTO uniform_inventory (uniform_type_id,uniform_size_id,qty,gender,date,user) VALUES (:uniform_type_id,:uniform_size_id,:qty,:gender,:date,:user)");
                                        $result = $insertingToChildTable->execute([
                                            ":uniform_type_id" => $_POST['uniform_type_id'],
                                            ":uniform_size_id" => $_POST['uniform_size_id'],
                                            ":qty" => $_POST['qty'],
                                            ":gender" => $_POST['gender'],
                                            ":date" => date("Y-m-d H:i:s"),
                                            ":user" => $_SESSION['fname'] . " " . $_SESSION['lname']
                                        ]);
                                        // var_dump($result);
                                        // die();
                                        header("location: show-uniform-inventory.php");
                                    }
                                ?>
                                <div class="modal fade" tabindex="-1" id="add" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class=" modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <form method="POST">
                                                <div class="modal-header">
                                                    <div class="modal-title text-white">
                                                        Add New Uniform
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <h3>Uniform Type</h3>
                                                                </th>
                                                                <th>
                                                                    <h3>Size</h3>
                                                                </th>
                                                                <th>
                                                                    <h3>Gender</h3>
                                                                </th>
                                                                <th>
                                                                    <h3>Quantity</h3>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $getAllUniformTypeQuery = $DB_con->prepare("SELECT * FROM uniform_types");
                                                            $getAllUniformTypeQuery->execute();
                                                            $types = $getAllUniformTypeQuery->fetchAll(PDO::FETCH_OBJ);
                                                            ?>
                                                            <th>
                                                                <select class="custom-select" id="uniformoption" name="uniform_type_id" required>
                                                                    <option selected disabled hidden value="">Choose Uniform</option>
                                                                    <?php
                                                                    foreach ($types as $type) {
                                                                    ?>
                                                                        <option value="<?= $type->type ?>"><?= $type->type ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </th>
                                                            <?php

                                                            $getAllSizesQuery = $DB_con->prepare("SELECT * FROM uniform_sizes");
                                                            $getAllSizesQuery->execute();
                                                            $sizes = $getAllSizesQuery->fetchAll(PDO::FETCH_OBJ);
                                                            ?>
                                                            <th>
                                                                <select class="custom-select" id="sizeoption" name="uniform_size_id" required>
                                                                    <option selected disabled hidden value="">Choose Uniform Size</option>
                                                                    <?php
                                                                    foreach ($sizes as $size) {
                                                                    ?>
                                                                        <option value="<?= $size->size ?>"><?= $size->size ?></option>

                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </th>

                                                            <th>
                                                                <select class="custom-select" id="genderoption" name="gender" required>
                                                                    <option selected disabled hidden value="">Gender</option>
                                                                    <option value="Male">Male</option>
                                                                    <option value="Female">Female</option>
                                                                    <option value="All">All</option>
                                                                </select>
                                                            </th>

                                                            <th>
                                                                <input class="form-control form-control-md" type="number" require="required" name="qty" placeholder="Input Number">
                                                            </th>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Save changes</button>
                                                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" id="reset">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Update Modal -->
                                <div class="modal fade" tabindex="-1" id="update" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content ">
                                            <form action="" method="post">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Add Uniform</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <h3>Size</h3>
                                                                </th>
                                                                <th>
                                                                    <h3>Quantity</h3>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th name="">XS</th> <!-- Change to Fetching database size !-->
                                                                <th><input type="number" placeholder="Quantity" value="0" name="XSqty" required="required"></th>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Save changes</button>
                                                    <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" id="reset">Cancel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Release Inventory -->
                            <div class="modal fade" tabindex="-1" id="release" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-lg ">
                                    <div class="modal-content ">
                                        <form action="inventory.php">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Students List</h5>
                                            </div>
                                            <div class="modal-body p-2">
                                                <div class=" col-12 p-2">
                                                    <table class="table table-bordered table-hover w-100" id="studentInventory">
                                                        <thead>
                                                            <tr>
                                                                <th>First Name</th>
                                                                <th>Last Name</th>
                                                                <th>Grade Level</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <?php 
                                                        
                                                        $fetchingAllStudents = $DB_con->prepare('SELECT * FROM user WHERE position = "Student" ORDER BY grade ASC');
                                                        $fetchingAllStudents->execute();
                                                        $students = $fetchingAllStudents->fetchAll(PDO::FETCH_OBJ);

                                                        foreach($students as $student){

                                                        ?>
                                                            <tr class="align-middle">
                                                                <td class=""><?= $student->fname ?></td>
                                                                <td><?= $student->lname ?></dh>
                                                                <td><?= $student->grade ?></td>
                                                                <td style="width:8.33%"><button type="button" class="btn btn-danger" data-bs-target="#record" data-bs-toggle="modal" value="<?= $student->id ?>" > Release</button></td>
                                                            </tr>
                                                            <?php 
                                                        }
                                                            ?>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Save changes</button>
                                                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" id="reset">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Record Modal  -->
                            <div class="modal fade" tabindex="-1" id="record" data-bs-backdrop="static" data-bs-keyboard="false">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form action="POST">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Distribute Uniform</h5>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 33%">Uniform Type</th>
                                                            <th style="width: 6.7%">Size</th>
                                                            <th style="width: 6.7%">Quantity</th>
                                                            <th style="width: auto">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr>
                                                            <!-- Fetch data for type  -->
                                                            <td style="width: 8.7%">
                                                                <?php 
                                                                $getAllUniform = $DB_con->prepare("SELECT * FROM uniform_types");
                                                                $getAllUniform->execute();
                                                                $uniforms = $getAllUniform->fetchAll(PDO::FETCH_OBJ);
                                                                ?>
                                                                <select name="distribution-type" id="distribution-type" class="form-control form-control-md">
                                                                    <option value="" selected hidden disabled>Select Uniform</option>
                                                                    <?php 
                                                                    foreach($uniforms as $uniform){
                                                                        ?>
                                                                        <option value="<?= $uniform->type?>"><?= $uniform->type?></option>
                                                                        <?php 
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                            <!-- Size Selecton -->
                                                            <td style="width: 21%">
                                                            <?php

                                                            $getAllSizesQuery = $DB_con->prepare("SELECT * FROM uniform_sizes");
                                                            $getAllSizesQuery->execute();
                                                            $sizes = $getAllSizesQuery->fetchAll(PDO::FETCH_OBJ);
                                                            ?>
                                                                <select name="distribution-size" id="distribution-size" class="form-control form-control-md">
                                                                    <option value="" selected hidden disabled>Select Size</option>
                                                                    <?php
                                                                    foreach ($sizes as $size) {
                                                                        ?>
                                                                        <option value="<?= $size->size ?>"><?= $size->size ?></option>
                                                                        <?php 
                                                                    }
                                                                    ?>
                                                                    <option value="medium">medium</option>
                                                                    <option value="large">large</option>
                                                                </select>
                                                            </td>
                                                            <td style="width:auto">
                                                                <input type="number" name="distribute-qty" id="distribute-qty" required>
                                                            </td>
                                                            <td style="width:4.3%"><button type="button" class="btn btn-primary btn-md">Add</button></td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                                <hr>

                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr >
                                                            <th style="width: 33%">Uniform Type</th>
                                                            <th style="width: 6.7%">Size</th>
                                                            <th style="width: 6.7%">Quantity</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <!-- Fetch data for type  -->
                                                            <td style="width: 8.7%">
                                                                Longsleeve Male
                                                            </td>
                                                            <!-- Size Selecton -->
                                                            <td style="width: 21%">
                                                                Large
                                                            </td>
                                                            <td style="width:21.2%">
                                                                1
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <!-- Fetch data for type  -->
                                                            <td style="width: 8.7%">
                                                                Longsleeve Male
                                                            </td>
                                                            <!-- Size Selecton -->
                                                            <td style="width: 21%">
                                                                Large
                                                            </td>
                                                            <td style="width:21.2%">
                                                                1
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Distribute</button>
                                                <button type="reset" class="btn btn-danger" data-bs-dismiss="modal" id="reset">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <br>
                    <!-- Start of First Table Set-->
                    <?php
                    $inventoryQuery = $DB_con->prepare("SELECT DISTINCT uniform_type_id FROM uniform_inventory");
                    $inventoryQuery->execute();
                    $uniformTypes = $inventoryQuery->fetchAll(PDO::FETCH_OBJ);

                    ?>
                    <div class="card col-12">
                        <div class="row">
                            <div class="col-12 rounded-bottom card-header bg-warning">
                                <h3 class="male pt-2">Stock</h3>
                            </div>
                            <div class="card-body col-12 pb-0 px-0">
                                <div class="row row-cols-2 col-12 m-auto justify-content-center">
                                    <?php

                                    foreach ($uniformTypes as $type) {

                                    ?>
                                        <div class="card bg-custom pt-2 col-xl-6 col-lg-12 col-12 px-3" id="table-inventory">
                                            <h2 class="m-0"><span class="icon-holder pr-2"><i class="anticon anticon-bank"></i></span><?= $type->uniform_type_id ?></h2>
                                            <table class="inventorylist table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-dark">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Gender</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $selectSpecificUniformType = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id");
                                                    $selectSpecificUniformType->bindParam(':uniform_type_id', $type->uniform_type_id);
                                                    $selectSpecificUniformType->execute();
                                                    $uniformItems = $selectSpecificUniformType->fetchAll(PDO::FETCH_OBJ);

                                                    if ($selectSpecificUniformType->rowCount() != 0) {
                                                        foreach ($uniformItems as $item) {
                                                    ?>
                                                            <tr>
                                                                <td><?= $item->uniform_size_id ?></td>
                                                                <td><?= $item->qty ?></td>
                                                                <td><?= $item->gender ?></td>
                                                                <td><?= $item->date ?></td>
                                                                <td><?= $item->user ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#update" class="btn btn-danger">Add Stock</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="6">
                                                                <div class="alert alert-warning" role="alert">
                                                                    ***** NO INVENTORY *****
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- form ends !-->
    </div>
    <!-- <?php include_once "includes/footer.php"; ?> -->
</div>
<?php include_once "includes/scripts.php"; ?>
</div>
</div>
</div>

</body>

</html>