<?php
include_once "includes/config.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

$gradelevel = $_POST["gradelevel"];
$section = $_POST["section"];
$gender = $_POST["gender"];
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
if (!empty($gender)) {
    $sql .= " AND gender = :gender";
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
if (!empty($gender)) {
    $pdo_statement->bindParam(':gender', $gender);
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
                                        Class List - <?php echo $_POST["gradelevel"] . " - " . $_POST["section"]; ?>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <form action="export.php" method="post" name="upload_excel" enctype="multipart/form-data">
                                                        <input type="hidden" name="gradelevel" value="<?php echo $_POST["gradelevel"]; ?>">
                                                        <input type="hidden" name="gender" value="<?php echo $_POST["gender"]; ?>">
                                                        <input type="hidden" name="section" value="<?php echo $_POST["section"]; ?>">
                                                        <input type="hidden" name="house" value="<?php echo $_POST["house"]; ?>">
                                                        <button type="submit" name="Export" class="btn btn-primary float-right">Export</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <table class="table table-hover">
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
                                                    <th scope="col">House</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($result as $row) {
                                                ?>
                                                    <tr>
                                                        <td><?php echo $row["lname"]; ?></td>
                                                        <td><?php echo $row["fname"]; ?></td>
                                                        <td><?php echo $row["mname"]; ?></td>
                                                        <td><?php echo date("F j, Y", strtotime($row["dob"])); ?></td>
                                                        <td><?php echo $row["gender"]; ?></td>
                                                        <td><?php echo $row["lrn"]; ?></td>
                                                        <td><?php echo $row["prevsch"]; ?></td>
                                                        <td><?php echo $row["nationality"]; ?></td>
                                                        <td><?php echo $row["house"]; ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
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
</body>
</html>
