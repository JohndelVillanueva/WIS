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
	
<body>
<div class="app">
    <div class="layout">
        <?php include_once "includes/heading.php"; ?>
        <?php include_once "includes/sidemenu.php"; ?>
        <div class="page-container">
            <div class="main-content d-flex">
                <!-- form starts !-->
                <div class="row w-100">
                    <div class="col-sm-12">
                        <div class="card border-1 border-light">
                            <div class="card-footer d-flex align-items-center rounded bg-warning border-light">
                                <h4><span class="icon-holder"><i class="anticon anticon-read"></i></span> Subjects</h4>
                            </div>
                            <div class="card-body bg-white border-0 ">
                                <table id="userlist" class="display table " style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Grade</th>
                                        <th>Section</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $pdo_statement = $DB_con->prepare("SELECT DISTINCT teacher,subject,grade,section From subjects;");
                                    $pdo_statement->execute();
                                    $result = $pdo_statement->fetchAll();
                                    foreach($result as $row) {
                                        ?>
                                        <tr>
                                            <td><a href="edit-record.php" ><?php echo $row['subject']; ?></a></td>
                                            <td><?php echo $row['grade']; ?></td>
                                            <td><?php echo $row['section']; ?></td>
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
        <?php include_once "includes/footer.php"; ?>
        <?php include_once "includes/scripts.php";?>
    </div>
</div>
</body>

</html>