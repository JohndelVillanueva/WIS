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

<div class="app is-folded">
    <div class="layout">
        <?php include_once "includes/heading.php"; ?>
        <?php include_once "includes/sidemenu.php"; ?>
        <div class="page-container">
            <div class="main-content">

            </div>
        </div>
    </div>
</div>