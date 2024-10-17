<?php
include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

$gradelevel = $_POST["gradelevel"];
$section = $_POST["section"];
$type = $_POST["type"];
$house = $_POST["house"];

// Start the SQL query
$sql = "SELECT * FROM users24 WHERE 1=1 and status = 9"; // Always true, allowing us to append conditions

// Add filters based on selected options
if (!empty($gradelevel)) {
    $sql .= " AND grade = :grade";
}
if (!empty($section)) {
    $sql .= " AND section = :section";
}
if (!empty($type)) {
    $sql .= " AND type = :type";
}
if (!empty($house)) {
    $sql .= " AND house = :house";
}

$sql .= " ORDER BY gender DESC, lname ASC";

// Prepare the statement
$pdo_statement = $DB_con->prepare($sql);

// Bind the parameters
if (!empty($gradelevel)) {
    $pdo_statement->bindParam(':grade', $gradelevel);
}
if (!empty($section)) {
    $pdo_statement->bindParam(':section', $section);
}
if (!empty($type)) {
    $pdo_statement->bindParam(':type', $type);
}
if (!empty($house)) {
    $pdo_statement->bindParam(':house', $house);
}

// Execute the query
$pdo_statement->execute();
$result = $pdo_statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once "includes/css.php"; ?>
<!-- DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<!-- Buttons Extension for Export and Print -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<body>
    <div class="app">
        <div class="layout">
            <?php include_once "includes/heading.php"; ?>
            <?php include_once "includes/sidemenu.php"; ?>
            <div class="page-container">
                <div class="main-content">
                    <!-- form starts !-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-warning rounded-top pt-2">
                                    <h4>
                                        <span class="icon-holder">
                                            <i class="anticon anticon-idcard"></i>
                                        </span>
                                        Class List - <?php echo $_POST["gradelevel"] . " - " . $_POST["section"] . " - " . $_POST["type"]; ?>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="export.php" method="post" name="upload_excel" enctype="multipart/form-data">
                                                        <input type="hidden" name="gradelevel" value="<?php echo $_POST["gradelevel"]; ?>">
                                                        <input type="hidden" name="section" value="<?php echo $_POST["section"]; ?>">
                                                        <input type="hidden" name="house" value="<?php echo $_POST["house"]; ?>">
                                                        <input type="hidden" name="type" value="<?php echo $_POST["type"]; ?>">
                                                        <button type="submit" name="Export" class="btn btn-primary float-right">Export</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table id="classListTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Last Name</th>
                                                    <th scope="col">First Name</th>
                                                    <th scope="col">Middle Name</th>
                                                    <th scope="col">Date of Birth</th>
                                                    <th scope="col">Gender</th>
                                                    <th scope="col">LRN</th>
                                                    <th scope="col">Previous School</th>
                                                    <th scope="col">Nationality</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">House</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($result as $row) { ?>
                                                    <tr>
                                                        <td><?php echo $row["lname"]; ?></td>
                                                        <td><?php echo $row["fname"]; ?></td>
                                                        <td><?php echo $row["mname"]; ?></td>
                                                        <td><?php echo date("F j, Y", strtotime($row["dob"])); ?></td>
                                                        <td><?php echo $row["gender"]; ?></td>
                                                        <td><?php echo $row["lrn"]; ?></td>
                                                        <td><?php echo $row["prevsch"]; ?></td>
                                                        <td><?php echo $row["nationality"]; ?></td>
                                                        <td><?php echo $row["type"]; ?></td>
                                                        <td><?php echo $row["house"]; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer bg-light text-center"></div>
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
    <script>
    $(document).ready(function() {
        $('#classListTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
    </script>
</body>
</html>
