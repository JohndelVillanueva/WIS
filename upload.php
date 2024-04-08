<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
}

include_once "includes/config.php";

if (is_array($_FILES)) {
    if (is_uploaded_file($_FILES['userImage']['tmp_name'])) {
        $sourcePath = $_FILES['userImage']['tmp_name'];
        $targetPath = "assets/images/avatars/" . $_POST['username'].".png";
        if (move_uploaded_file($sourcePath, $targetPath)) {
            ?>
            <img class="image-preview" src="<?php echo $targetPath; ?>"
                 class="upload-preview" style="width: 128px!important;" />
            <?php
        }
    }
}

$addphoto = $DB_con->prepare("UPDATE users24 SET photo = :photo WHERE username = :username");
$addphoto->execute(array(
    ":photo"=>$_POST["username"],
    ":username"=>$_POST["username"]
));