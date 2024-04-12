<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}
?><!DOCTYPE html>
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
                                            <button type="butto" class="btn btn-danger btn-lg dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="icon-holder"><i class="anticon anticon-control"></i></span> Options
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#"><span class="icon-holder"><i class="anticon anticon-file-add"></i></span> Add New Inventory</a>
                                                <a class="dropdown-item" href="#"><span class="icon-holder"><i class="anticon anticon-user-add"></i></span> Release Inventory</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#"><span class="icon-holder"><i class="anticon anticon-table"></i></span> Reports</a>
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
                                                        $getreginv->execute(array(":uniformtype"=>"1"));
                                                        $reguniform = $getreginv->fetchAll();

                                                        if($getreginv->rowCount() != 0) {
                                                            foreach ($reguniform as $reg) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $reg["size"]?></td>
                                                                    <td><?php echo $reg["qty"]?></td>
                                                                    <td><?php echo $reg["date"]?></td>
                                                                    <td><?php echo $reg["user"]?></td>
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
                                                $getreginv->execute(array(":uniformtype"=>"2"));
                                                $reguniform = $getreginv->fetchAll();

                                                if($getreginv->rowCount() != 0) {
                                                    foreach ($reguniform as $reg) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $reg["size"]?></td>
                                                            <td><?php echo $reg["qty"]?></td>
                                                            <td><?php echo $reg["date"]?></td>
                                                            <td><?php echo $reg["user"]?></td>
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
                                                $getreginv->execute(array(":uniformtype"=>"3"));
                                                $reguniform = $getreginv->fetchAll();

                                                if($getreginv->rowCount() != 0) {
                                                    foreach ($reguniform as $reg) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $reg["size"]?></td>
                                                            <td><?php echo $reg["qty"]?></td>
                                                            <td><?php echo $reg["date"]?></td>
                                                            <td><?php echo $reg["user"]?></td>
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
        <?php include_once "includes/scripts.php";?>
        </div>
    </div>
</div>

</body>

</html>