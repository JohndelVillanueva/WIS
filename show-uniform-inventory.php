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

<form>

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
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#update" class="btn btn-danger"> Add New</button>
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#release" class="btn btn-danger">Release Inventory</button>
                                                        <button type="button" class="btn btn-danger">Reports</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php

                                    $uniform_type_id = $_POST['uniform_type_id'];
                                    $displayAlltheInventoryQuery = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id");
                                    $displayAlltheInventoryQuery->execute([":uniform_type_id" => $uniform_type_id]);
                                    $display = $displayAlltheInventoryQuery->fetch(PDO::FETCH_OBJ);

                                    if ($uniform_type_id == 1) {

                                        $updateQuery = $DB_con->prepare("UPDATE uniform_inventory SET `qty` = ? WHERE id = ?");
                                        $updateQuery->execute([
                                            $_POST['XSqty'],
                                            $_POST['Sqty'],
                                            $_POST['id']
                                        ]);
                                    }
                                    // $insertUniformQuery = $DB_con->prepare("INSERT INTO uniform_inventory (uniform_type_id,size,qty,date,user) VALUES (?,?,?,?,?)");
                                    // $insertUniformQuery->execute([
                                    //     $uniform_type_id = $_POST['uniform_type_id'],
                                    //     $uniform_type_id = $_POST['size'],
                                    //     $uniform_type_id = $_POST['qty'],
                                    //     date("Y/m/d"),
                                    //     $uniform_type_id = $_SESSION['fname'] . " " . $_SESSION['lname']
                                    // ])


                                    ?>

                                    <!-- Add New Modal-->
                                    <div class="modal fade" tabindex="-1" id="update" data-bs-backdrop="static" data-bs-keyboard="false">
                                        <div class=" modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form method="POST">
                                                    <div class="modal-header">
                                                        <div class="modal-title">
                                                            Add New Uniform
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table text-center">
                                                            <thead>
                                                                <tr>
                                                                    <th><h3>Uniform Type:</h3></th>
                                                                    <th><h3>Quantity</h3></th>
                                                                    <th><h3>Gender</h3></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <th>
                                                                    <select class="custom-select" id="uniformtype">
                                                                        <option selected>Choose Uniform</option>
                                                                        <option value="1">QUERY MU</option>
                                                                    </select>
                                                                </th>
                                                                <th>
                                                                    <input class="form-control form-control-md" type="number" require="required" placeholder="Input Number">
                                                                </th>
                                                                <th>
                                                                    <select class="custom-select" id="genderoption">
                                                                        <option selected>Choose Uniform</option>
                                                                        <option value="1">QUERY MU</option>
                                                                    </select>
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
                                                                    <th>Size</th>
                                                                    <th>Quantity</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th name="">XS</th> <!-- Change to Fetching database size !-->
                                                                    <th><input type="number" placeholder="Quantity" value="0" name="XSqty" required="required"></th>
                                                                    <!-- <th><input type="number" placeholder="Quantity for Female" value="0" name="sqty" required="required"></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>SMALL</th>
                                                                    <th><input type="number" placeholder="Quantity for Male" value="0" name="Sqty" required="required"></th>
                                                                    <th><input type="number" placeholder="Quantity for Female" value="0" name="sqty" required="required"></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>MEDIUM</th>
                                                                    <th><input type="number" placeholder="Quantity for Male" value="0" required="required"></th>
                                                                    <th><input type="number" placeholder="Quantity for Female" value="0" required="required"></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>LARGE</th>
                                                                    <th><input type="number" placeholder="Quantity for Male" value="0" required="required"></th>
                                                                    <th><input type="number" placeholder="Quantity for Female" value="0" required="required"></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>XL</th>
                                                                    <th><input type="number" placeholder="Quantity for Male" value="0" required="required"></th>
                                                                    <th><input type="number" placeholder="Quantity for Female" value="0" required="required"></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>XXL</th>
                                                                    <th><input type="number" placeholder="Quantity for Male" value="0" required="required"></th>
                                                                    <th><input type="number" placeholder="Quantity for Female" value="0" required="required"></th>
                                                                </tr> -->
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
                                <div class="modal fade" tabindex="-1" id="release" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal1">
                                    <div class="modal-dialog modal-xl ">
                                        <div class="modal-content ">
                                            <form action="inventory.php">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Students List</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-row-1 p-2">
                                                        <table class="table table-bordered table-hover w-100" id="studentInventory">
                                                            <thead>
                                                                <tr>
                                                                    <th>First Name</th>
                                                                    <th>Last Name</th>
                                                                    <th>Grade Level</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="align-middle">
                                                                    <td class="">Johndel</td>
                                                                    <td>Villanueva</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger" data-bs-target="record" data-bs-toggle="modal"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Jerald</td>
                                                                    <td>Balilu</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Rose Ann</td>
                                                                    <td>Vino</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Myren Josh</td>
                                                                    <td>Tiqui</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Johndel</td>
                                                                    <td>Villanueva</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Johndel</td>
                                                                    <td>Villanueva</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Johndel</td>
                                                                    <td>Villanueva</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Johndel</td>
                                                                    <td>Villanueva</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Johndel</td>
                                                                    <td>Villanueva</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Johndel</td>
                                                                    <td>Villanueva</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Johndel</td>
                                                                    <td>Villanueva</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Johndel</td>
                                                                    <td>Villanueva</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Johndel</td>
                                                                    <td>Villanueva</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                                <tr class="align-middle">
                                                                    <td class="">Johndel</td>
                                                                    <td>Villanueva</dh>
                                                                    <td>999</td>
                                                                    <td><button type="button" class="btn btn-danger"> Release</button></td>
                                                                </tr>
                                                            </tbody>
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
                            </div>
                        </div>

                        <br>
                        <!-- Start of First Table Set-->
                        <div class="card col-12">
                            <div class="row">
                                <div class="col-12 rounded-bottom card-header bg-warning">
                                    <h3 class="male pt-2">Highschool Uniform</h3>
                                </div>
                                <div class="card-body col-12 pb-0">
                                    <div class="row row-cols-2 col-12 m-auto justify-content-center">
                                        <div class="card bg-male p-3 col-6">
                                            <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-bank"></i></span> Longsleeve Uniform (Male)</h3>
                                            <table class="table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-light">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id AND gender = :gender");
                                                    $getreginv->execute(array(":uniform_type_id" => "1", ":gender" => "F"));
                                                    $reguniform = $getreginv->fetchAll();

                                                    if ($getreginv->rowCount() != 0) {
                                                        foreach ($reguniform as $reg) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $reg["size"] ?></td>
                                                                <td><?php echo $reg["qty"] ?></td>
                                                                <td><?php echo $reg["date"] ?></td>
                                                                <td><?php echo $reg["user"] ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="5">
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
                                        <div class="card bg-female p-4 col-6">
                                            <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-dribbble"></i></span> Longsleeve Uniform (Female)</h3>
                                            <table class="table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-light">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id AND gender = :gender");
                                                    $getreginv->execute(array(":uniform_type_id" => "2", ":gender" => "F"));
                                                    $reguniform = $getreginv->fetchAll();

                                                    if ($getreginv->rowCount() != 0) {
                                                        foreach ($reguniform as $reg) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $reg["size"] ?></td>
                                                                <td><?php echo $reg["qty"] ?></td>
                                                                <td><?php echo $reg["date"] ?></td>
                                                                <td><?php echo $reg["user"] ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="4">
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
                                    </div>
                                    <!-- End of First Table -->

                                    <!-- Second Table Set -->
                                    <div class="row row-cols-2 col-12 m-auto justify-content-center">
                                        <div class="card bg-male p-3 col-6">
                                            <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-bank"></i></span> Suit (Male)</h3>
                                            <table class="table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-light">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id AND gender = :gender");
                                                    $getreginv->execute(array(":uniform_type_id" => "1", ":gender" => "F"));
                                                    $reguniform = $getreginv->fetchAll();

                                                    if ($getreginv->rowCount() != 0) {
                                                        foreach ($reguniform as $reg) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $reg["size"] ?></td>
                                                                <td><?php echo $reg["qty"] ?></td>
                                                                <td><?php echo $reg["date"] ?></td>
                                                                <td><?php echo $reg["user"] ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="5">
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
                                        <div class="card bg-female p-4 col-6">
                                            <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-dribbble"></i></span> Suit (Female)</h3>
                                            <table class="table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-light">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id AND gender = :gender");
                                                    $getreginv->execute(array(":uniform_type_id" => "2", ":gender" => "F"));
                                                    $reguniform = $getreginv->fetchAll();

                                                    if ($getreginv->rowCount() != 0) {
                                                        foreach ($reguniform as $reg) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $reg["size"] ?></td>
                                                                <td><?php echo $reg["qty"] ?></td>
                                                                <td><?php echo $reg["date"] ?></td>
                                                                <td><?php echo $reg["user"] ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="4">
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
                                    </div>
                                    <!-- End of Second Table Set -->

                                    <!-- Start of Third Table Set -->
                                    <div class="row row-cols-2 col-12 m-auto justify-content-center">
                                        <div class="card bg-secondary p-3 col-6">
                                            <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-bank"></i></span> PE Shirt</h3>
                                            <table class="table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-light">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id AND gender = :gender");
                                                    $getreginv->execute(array(":uniform_type_id" => "1", ":gender" => "F"));
                                                    $reguniform = $getreginv->fetchAll();

                                                    if ($getreginv->rowCount() != 0) {
                                                        foreach ($reguniform as $reg) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $reg["size"] ?></td>
                                                                <td><?php echo $reg["qty"] ?></td>
                                                                <td><?php echo $reg["date"] ?></td>
                                                                <td><?php echo $reg["user"] ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="5">
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
                                        <div class="card bg-secondary p-4 col-6">
                                            <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-dribbble"></i></span> Jogging Pants</h3>
                                            <table class="table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-light">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id AND gender = :gender");
                                                    $getreginv->execute(array(":uniform_type_id" => "2", ":gender" => "F"));
                                                    $reguniform = $getreginv->fetchAll();

                                                    if ($getreginv->rowCount() != 0) {
                                                        foreach ($reguniform as $reg) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $reg["size"] ?></td>
                                                                <td><?php echo $reg["qty"] ?></td>
                                                                <td><?php echo $reg["date"] ?></td>
                                                                <td><?php echo $reg["user"] ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="4">
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
                                    </div>
                                    <!-- End of Third Table Set -->
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card col-12">
                            <div class="row">
                                <div class="col-12 rounded-bottom card-header bg-warning">
                                    <h3 class="male pt-2">Highschool Uniform</h3>
                                </div>
                                <div class="card-body col-12 pb-0">
                                    <div class="row row-cols-2 col-12 m-auto justify-content-center">
                                        <div class="card bg-male p-3 col-6">
                                            <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-bank"></i></span> Longsleeve Uniform (Male)</h3>
                                            <table class="table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-light">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id AND gender = :gender");
                                                    $getreginv->execute(array(":uniform_type_id" => "1", ":gender" => "F"));
                                                    $reguniform = $getreginv->fetchAll();

                                                    if ($getreginv->rowCount() != 0) {
                                                        foreach ($reguniform as $reg) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $reg["size"] ?></td>
                                                                <td><?php echo $reg["qty"] ?></td>
                                                                <td><?php echo $reg["date"] ?></td>
                                                                <td><?php echo $reg["user"] ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="5">
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
                                        <div class="card bg-female p-4 col-6">
                                            <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-dribbble"></i></span> Longsleeve Uniform (Female)</h3>
                                            <table class="table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-light">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id AND gender = :gender");
                                                    $getreginv->execute(array(":uniform_type_id" => "2", ":gender" => "F"));
                                                    $reguniform = $getreginv->fetchAll();

                                                    if ($getreginv->rowCount() != 0) {
                                                        foreach ($reguniform as $reg) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $reg["size"] ?></td>
                                                                <td><?php echo $reg["qty"] ?></td>
                                                                <td><?php echo $reg["date"] ?></td>
                                                                <td><?php echo $reg["user"] ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="4">
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
                                    </div>
                                    <!-- End of First Table -->

                                    <!-- Second Table Set -->
                                    <div class="row row-cols-2 col-12 m-auto justify-content-center">
                                        <div class="card bg-male p-3 col-6">
                                            <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-bank"></i></span> Suit (Male)</h3>
                                            <table class="table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-light">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id AND gender = :gender");
                                                    $getreginv->execute(array(":uniform_type_id" => "1", ":gender" => "F"));
                                                    $reguniform = $getreginv->fetchAll();

                                                    if ($getreginv->rowCount() != 0) {
                                                        foreach ($reguniform as $reg) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $reg["size"] ?></td>
                                                                <td><?php echo $reg["qty"] ?></td>
                                                                <td><?php echo $reg["date"] ?></td>
                                                                <td><?php echo $reg["user"] ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="5">
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
                                        <div class="card bg-female p-4 col-6">
                                            <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-dribbble"></i></span> Suit (Female)</h3>
                                            <table class="table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-light">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id AND gender = :gender");
                                                    $getreginv->execute(array(":uniform_type_id" => "2", ":gender" => "F"));
                                                    $reguniform = $getreginv->fetchAll();

                                                    if ($getreginv->rowCount() != 0) {
                                                        foreach ($reguniform as $reg) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $reg["size"] ?></td>
                                                                <td><?php echo $reg["qty"] ?></td>
                                                                <td><?php echo $reg["date"] ?></td>
                                                                <td><?php echo $reg["user"] ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="4">
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
                                    </div>
                                    <!-- End of Second Table Set -->

                                    <!-- Start of Third Table Set -->
                                    <div class="row row-cols-2 col-12 m-auto justify-content-center">
                                        <div class="card bg-secondary p-3 col-6">
                                            <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-bank"></i></span> PE Shirt</h3>
                                            <table class="table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-light">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id AND gender = :gender");
                                                    $getreginv->execute(array(":uniform_type_id" => "1", ":gender" => "F"));
                                                    $reguniform = $getreginv->fetchAll();

                                                    if ($getreginv->rowCount() != 0) {
                                                        foreach ($reguniform as $reg) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $reg["size"] ?></td>
                                                                <td><?php echo $reg["qty"] ?></td>
                                                                <td><?php echo $reg["date"] ?></td>
                                                                <td><?php echo $reg["user"] ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="5">
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
                                        <div class="card bg-secondary p-4 col-6">
                                            <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-dribbble"></i></span> Jogging Pants</h3>
                                            <table class="table table-hover table-light">
                                                <thead class="text-center">
                                                    <tr class="table-light">
                                                        <th>Size</th>
                                                        <th>Last Inventory</th>
                                                        <th>Date</th>
                                                        <th>User</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-center">
                                                    <?php
                                                    $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniform_type_id = :uniform_type_id AND gender = :gender");
                                                    $getreginv->execute(array(":uniform_type_id" => "2", ":gender" => "F"));
                                                    $reguniform = $getreginv->fetchAll();

                                                    if ($getreginv->rowCount() != 0) {
                                                        foreach ($reguniform as $reg) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $reg["size"] ?></td>
                                                                <td><?php echo $reg["qty"] ?></td>
                                                                <td><?php echo $reg["date"] ?></td>
                                                                <td><?php echo $reg["user"] ?></td>
                                                                <td><button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New</button></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="4">
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
                                    </div>
                                    <!-- End of Third Table Set -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- form ends !-->
                </div>
                <?php include_once "includes/footer.php"; ?>
            </div>
            <?php include_once "includes/scripts.php"; ?>
        </div>
    </div>
    </div>

    </body>

</html>