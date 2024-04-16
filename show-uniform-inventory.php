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
                                                    <button class=" dropdown-btn btn btn-danger" onclick="drpFunction()"> Options </button>
                                                    <div id="dropdown-list" class="dropdown-content">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#add" class="btn btn-danger">Add New Inventory</button>
                                                        <button type="button" class="btn btn-danger">Release Inventory</button>
                                                        <button type="button" class="btn btn-danger">Reports</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add New Modal -->
                                    <div class="modal fade" tabindex="-1" id="add" data-bs-backdrop="static" data-bs-keyboard="false">
                                        <div class="modal-dialog modal-lg ">
                                            <div class="modal-content ">
                                                <form action="">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Select Uniform Type</h5>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <div class="row col-12">
                                                            <div class="col-4">
                                                                <input type="radio" id="reg" name="uniformtype" value="regular" onclick="adaptColor()" required="required">
                                                                <label for="regular">Regular Uniform</label>
                                                            </div>
                                                            <div class="col-4">
                                                                <input type="radio" id="phyedu" name="uniformtype" value="physicalEducation" onclick="adaptColor()" required="required">
                                                                <label for=" regular">PE Uniform</label>
                                                            </div>
                                                            <div class="col-4">
                                                                <input type="radio" id="afterschool" name="uniformtype" value="afterSchool" onclick="adaptColor()" required="required">
                                                                <label for=" regular">Afterschool Uniform</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-header" id="modal-header-body">
                                                        <h5 class="modal-title">Add Uniform</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table text-center">
                                                            <thead>
                                                                <tr>
                                                                    <th>Size</th>
                                                                    <th>Quantity for Male Uniform</th>
                                                                    <th>Quantity for Female Uniform</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th>xs</th>
                                                                    <th><input type="number" placeholder="Quantity for Male" value="0" required="required"></th>
                                                                    <th><input type="number" placeholder="Quantity for Female" value="0" required="required"></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>small</th>
                                                                    <th><input type="number" placeholder="Quantity for Male" value="0" required="required"></th>
                                                                    <th><input type="number" placeholder="Quantity for Female" value="0" required="required"></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>medium</th>
                                                                    <th><input type="number" placeholder="Quantity for Male" value="0" required="required"></th>
                                                                    <th><input type="number" placeholder="Quantity for Female" value="0" required="required"></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>large</th>
                                                                    <th><input type="number" placeholder="Quantity for Male" value="0" required="required"></th>
                                                                    <th><input type="number" placeholder="Quantity for Female" value="0" required="required"></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>xl</th>
                                                                    <th><input type="number" placeholder="Quantity for Male" value="0" required="required"></th>
                                                                    <th><input type="number" placeholder="Quantity for Female" value="0" required="required"></th>
                                                                </tr>
                                                                <tr>
                                                                    <th>xxl</th>
                                                                    <th><input type="number" placeholder="Quantity for Male" value="0" required="required"></th>
                                                                    <th><input type="number" placeholder="Quantity for Female" value="0" required="required"></th>
                                                                </tr>
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

                                    <br>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="card bg-primary p-4">
                                                <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-bank"></i></span> Regular Uniform</h3>
                                                <table class="table table-hover table-light">
                                                    <thead class="text-center">
                                                        <tr class="table-light">
                                                            <th>Size</th>
                                                            <th>Last Inventory</th>
                                                            <th>Date</th>
                                                            <th>User</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
                                                        <?php
                                                        $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniformtype = :uniformtype");
                                                        $getreginv->execute(array(":uniformtype" => "1"));
                                                        $reguniform = $getreginv->fetchAll();

                                                        if ($getreginv->rowCount() != 0) {
                                                            foreach ($reguniform as $reg) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $reg["size"] ?></td>
                                                                    <td><?php echo $reg["qty"] ?></td>
                                                                    <td><?php echo $reg["date"] ?></td>
                                                                    <td><?php echo $reg["user"] ?></td>
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
                                        <div class="col-lg-4">
                                            <div class="card bg-info p-4">
                                                <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-dribbble"></i></span> PE Uniform</h3>
                                                <table class="table table-hover table-light">
                                                    <thead class="text-center">
                                                        <tr class="table-light">
                                                            <th>Size</th>
                                                            <th>Last Inventory</th>
                                                            <th>Date</th>
                                                            <th>User</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
                                                        <?php
                                                        $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniformtype = :uniformtype");
                                                        $getreginv->execute(array(":uniformtype" => "2"));
                                                        $reguniform = $getreginv->fetchAll();

                                                        if ($getreginv->rowCount() != 0) {
                                                            foreach ($reguniform as $reg) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $reg["size"] ?></td>
                                                                    <td><?php echo $reg["qty"] ?></td>
                                                                    <td><?php echo $reg["date"] ?></td>
                                                                    <td><?php echo $reg["user"] ?></td>
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
                                        <div class="col-lg-4">
                                            <div class="card bg-secondary p-4">
                                                <h3 class="pt-2 text-white"><span class="icon-holder"><i class="anticon anticon-alert"></i></span> Activity Uniform</h3>
                                                <table class="table table-hover table-light">
                                                    <thead class="text-center">
                                                        <tr class="table-light">
                                                            <th>Size</th>
                                                            <th>Last Inventory</th>
                                                            <th>Date</th>
                                                            <th>User</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
                                                        <?php
                                                        $getreginv = $DB_con->prepare("SELECT * FROM uniform_inventory WHERE uniformtype = :uniformtype");
                                                        $getreginv->execute(array(":uniformtype" => "3"));
                                                        $reguniform = $getreginv->fetchAll();

                                                        if ($getreginv->rowCount() != 0) {
                                                            foreach ($reguniform as $reg) {
                                                        ?>
                                                                <tr>
                                                                    <td><?php echo $reg["size"] ?></td>
                                                                    <td><?php echo $reg["qty"] ?></td>
                                                                    <td><?php echo $reg["date"] ?></td>
                                                                    <td><?php echo $reg["user"] ?></td>
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