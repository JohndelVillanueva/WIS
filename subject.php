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
                               <div class="d-flex">
                                <div class="w-20 input-group mr-3">
                                        <select class="custom-select" id="GLevel">
                                            <option selected disabled>Grade Level</option>
                                            <option value="Nursery">Nursery</option>
                                            <option value="Toddler">Toddler</option>
                                            <option value="Preschool">Preschool</option>
                                            <option value="Kinder">Kinder</option>
                                            <option value="Grade 1">Grade 1</option>
                                            <option value="Grade 2">Grade 2</option>
                                            <option value="Grade 3">Grade 3</option>
                                            <option value="Grade 4">Grade 4</option>
                                            <option value="Grade 5">Grade 5</option>
                                            <option value="Grade 6">Grade 6</option>
                                            <option value="Grade 1">Grade 7</option>
                                            <option value="Grade 8">Grade 8</option>
                                            <option value="Grade 9">Grade 9</option>
                                            <option value="Grade 10">Grade 10</option>
                                            <option value="Grade 11">Grade 11</option>
                                            <option value="Grade 12">Grade 12</option>
                                            <option value="CAIE">CAIE</option>
                                        </select>
                                    </div>
                                    
                               </div>
                            </div>
                            <div class="card-body bg-white border-0 d-none" id='subs'>
                                <table id="userlist" class="display table " style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Grade</th>
                                        <!-- <th>Section</th> -->
                                    </tr>
                                    </thead>
                                    <tbody id="gradeRow">
                                        <?php
                                            $pdo_statement = $DB_con->prepare("SELECT * From assignment;");
                                            $pdo_statement->execute();
                                            $result = $pdo_statement->fetchAll();
                                            foreach($result as $row) {
                                                ?>
                                                    <tr class="<?php echo $row['grade'] ?> <?php echo $row['subject']?>">
                                                        <td><a href="assignTeacher.php" ><?php echo $row['subject']; ?></a></td>
                                                        <td><?php echo $row['grade']; ?></td>
                                                        <!-- <td><?php echo $row['section']; ?></td> -->
                                                    </tr>
                                                <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-body bg-white border-0 " id='nosubs'>
                                <p class="text-center">Please select Grade level first</p>
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
<?php include('./includes/filter.php');?>
</html>