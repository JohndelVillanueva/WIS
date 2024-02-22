<?php
include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}
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
                                        Subject Assignment
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <?php
                                    if(isset($_GET['ern'])){
                                        ?>
                                        <div class="row" id="alertmsg">
                                            <div class="col-lg-12">
                                                <div class="alert alert-success" role="alert">
                                                    Successfully processed ERN <?php echo $_GET['ern'];?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <div class="row">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Grade</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                        <?php
                                            $pdo_statement = $DB_con->prepare("SELECT DISTINCT grade FROM user WHERE position = 'Student' ORDER BY CAST(grade AS UNSIGNED) ASC");
                                            $pdo_statement->execute();
                                            $result = $pdo_statement->fetchAll();
                                            foreach($result as $row) {
                                            ?>
                                                <tr>
                                                    <form>
                                                        <th scope="row"><?php echo $row["grade"];?></th>
                                                        <td>
															<?php
																if($_SESSION['level'] == 9 OR $_SESSION['level'] == 2 OR $_SESSION['level'] == 4){
															?>
																 <a href="edit-subject.php?id=<?php echo $row['grade'];?>" type="button" class="btn btn-primary rounded"><span class="icon-holder"><i class="anticon anticon-edit"></i></span></a>
															<?php
																}															
															?>
                                                        </td>
                                                    </form>
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
<?php include_once "includes/scripts.php";?>
</div>
</div>
</body>

</html>