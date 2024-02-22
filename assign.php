<?php 
include_once("./includes/config.php");
if(isset($_POST['teacher'])){
    if(!empty($_POST['teacher'])) {
        $selected = $_POST['teacher'];
        $assign_statement = $DB_con->prepare("UPDATE `assignment` SET `teacher`='$selected'");
        $assign_statement->execute();
    } else {
        echo 'Please select the value.';
    }
}

header("Location: assignTeacher.php?assign=success");
die();  

?>