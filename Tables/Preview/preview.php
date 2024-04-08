<?php
include_once ("../../includes/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Westfields International School - WISPortal 0.1a</title>
    <link rel="shortcut icon" href="../../assets/images/logo/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<style>
    #addLabel:hover{
        cursor: pointer;
    }
    .TR{
        background:transparent;
    }
    tbody .rotate{
        transform:rotate(-90deg);
        background:transparent;
        font-size:15px;
        letter-spacing: 1px;
        line-height:175px;
        white-space: nowrap;
    }

</style>

</head>

<body>

<div class="app px-5 py-2">
    <div class="layout">
        <div class="page-container">
            <div class="main-content py-2">
                <div class="row">
                    <header class="d-flex justify-content-center"><img src="../../assets/images/logo/logo.png"></header>
                    <?php
                        $getData = "SELECT teacher,subject FROM subjects";
                        $getTeacherData = $DB_con->query($getData)->fetchAll();
                        $getSubjectData = $DB_con->query($getData)->fetchAll();
                        $teacher = $getTeacherData[0]['teacher'];
                        $subject = $getSubjectData[0]['subject'];
                        echo "<h1>Quarter 1</h1>";
                        echo "<h2>$subject</h2>";
                        echo "<h3>$teacher</h3>";
                        echo "<h3>2022-2023</h3>";
                    ?>
                </div>
                <div class="row d-flex justify-content-center pt-5">
                    <div class="col-md-2 names border border-dark border-2 rounded-start">                       
                        <div class="label p-4 bg-light text-center">
                            <p style="font-weight:bold">Learner's Names</p>
                        </div>
                        <div>
                            <table class="table table-responsive text-center">
                                <?php 
                                    include_once("names.php");
                                ?>
                            </table>
                        </div> 
                    </div>
                    <div class="col-md-3 written border border-dark border-2 ">                       
                        <div class="label p-4 bg-light text-center">
                            <p style="font-weight:bold">Written Works (20%)</p>
                        </div>
                        <div>
                            <table class="table table-responsive text-center">
                                <?php 
                                    include_once("written.php");
                                ?>
                            </table>
                        </div> 
                    </div>
                    <div class="col-md-3  performance border border-dark border-2">                       
                        <div class="label  p-4 bg-light text-center">
                            <p style="font-weight:bold">Performance Task (60%)</p>
                        </div>
                        <div>
                            <table class="table table-responsive text-center">
                                <?php 
                                    include_once("performance.php");
                                ?>
                            </table>
                        </div> 
                    </div>
                    <div class="col-md-2 quarterly border border-dark border-2">                       
                        <div class="label  p-4 bg-light text-center">
                            <p style="font-weight:bold">Quarterly (20%)</p>
                        </div>
                        <div>
                            <table class="table table-responsive text-center">
                                <?php 
                                    include_once("quarterly.php");
                                ?>
                            </table>
                        </div> 
                    </div>
                    <div class="col-md-1  grade border border-dark border-2">                       
                        <div class="label  p-4 bg-light text-center">
                            <p style="font-weight:bold">Grade</p>
                        </div>
                        <div>
                            <table class="table table-responsive text-center">
                                <?php 
                                    include_once("igrade.php");
                                ?>
                            </table>
                        </div> 
                    </div>
                    <div class="col-md-1  grade border border-dark border-2 rounded-end">                       
                        <div class="label  p-4 bg-light text-center">
                            <p style="font-weight:bold">Grade</p>
                        </div>
                        <div>
                            <table class="table table-responsive text-center">
                                <?php 
                                    include_once("fgrade.php");
                                ?>
                            </table>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <?php
        include_once("../../includes/scripts.php");
        ?>
</body>

</html>