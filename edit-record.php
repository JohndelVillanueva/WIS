<?php include_once "includes/config.php";
session_start();
if(!isset($_SESSION['username']))
{
    header("location: login.php");

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Westfields International School - WISPortal 0.1a</title>
    <link rel="shortcut icon" href="assets/images/logo/favicon.png">
</head>
<?php include_once "includes/css.php";?>
<body>
    <!-- MODAL -->
    <form action="addActivity.php" method="post">
        <div class="modal fade" id="addActivity" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-filter:none">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header  d-flex align-items-center bg-warning">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Activity</h1>
                        <button type="button" class="btn-close" style="background-color:transparent; border:none;" id="btnClose" data-bs-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"/>
                            </svg>
                        </button>
                    </div>
                <div class="modal-body">
                    <div class="row justify-content-center align-items-center g-2 mb-3">
                            <div class="col-4">Activity Name:</div>
                            <div class="col-8 align-items-center">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Type here..." maxlength="20" aria-label="actName" aria-describedby="basic-addon1" name="actname" required>                                                       
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center align-items-center g-2 mb-3">
                            <div class="col-4">Activity Type:</div>
                            <div class="col-8">
                                <select class="custom-select" id="actype" name="actype" required>
                                    <option selected disabled >Choose...</option>
                                    <option  value="Written">Written Work</option>
                                    <option value="Performance">Performance Task</option>
                                    <option value="Quarterly">Quarterly Assessment</option>
                                </select>
                            </div>
                        </div>

                        <!-- WRITTEN WORK -->
                        <div class="row justify-content-center align-items-center g-2 mb-3" id="wwOption">
                            <div class="col-4">Type:</div>
                            <div class="col-8">
                                <select class="custom-select" id="wwType" required>
                                    <option selected default disabled >Choose...</option>
                                    <option value="Homework">Homework</option>
                                    <option value="Seatwork">Seatwork</option>
                                </select>
                            </div>
                        </div>
                        <!-- Performance Task  -->
                        <div class="row justify-content-center align-items-center g-2 mb-3" id="ptOption">
                            <div class="col-4">Type:</div>
                            <div class="col-8">
                                <select class="custom-select" id="PTtype" required>
                                    <option selected default disabled >Choose...</option>
                                    <option value="Quiz">Quiz</option>
                                    <option value="PT">PT</option>
                                </select>
                            </div>
                            
                        </div>

                        <div class="row justify-content-center align-items-center g-2 mb-3">
                            <div class="col-4">Max possible score:</div>
                            <div class="col-8">
                                <div class="input-group">
                                    <input type="number" class="form-control"  min="1" max="1000" placeholder="Type here..." aria-label="Username" aria-describedby="basic-addon1" name="max" value="5" required>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <button type="button" class="btns btn-secondary rounded px-3 py-1 shadow-none" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btns btn-primary rounded px-3  py-1 shadow-none">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="app">
        <div class="layout">
            <?php include_once "includes/heading.php"; ?>
            <?php include_once "includes/sidemenu.php"; ?>
            <div class="page-container">
                <div class="main-content">
                    <?php
                        if(isset($_GET['add'])) {
                            echo "
                                <div class=\"row\">
                                    <div class=\"col-md-12\">
                                        <div class=\"alert alert-success\" role=\"alert\">
                                            Activity Added!
                                        </div>
                                    </div>
                                </div>";
                        } if(isset($_GET['fail'])){
                            echo "
                                <div class=\"row\">
                                    <div class=\"col-md-12\">
                                        <div class=\"alert alert-danger\" role=\"alert\">
                                            Add Activity Failed! Activity Type not selected!
                                        </div>
                                    </div>
                                </div>";
                        }
                    ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-footer rounded bg-light bg-warning">
                                    <h4><span class="icon-holder"><i class="anticon anticon-edit"></i></span> Editing Grade 6 - Efficiency - Science</h4>
                                </div>
                                <div class="card-body bg-white">
                                    <div class="d-flex justify-content-between">
                                        <ul class="nav nav-pills mb-3 d-flex justify-around" id="pills-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="pills-written-tab" data-toggle="pill" href="#pills-written" role="tab" aria-controls="pills-written" aria-selected="true">Written Works</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-performance-tab" data-toggle="pill" href="#pills-performance" role="tab" aria-controls="pills-performance" aria-selected="false">Performance Tasks</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-quarterly-tab" data-toggle="pill" href="#pills-quarterly" role="tab" aria-controls="pills-quarterly" aria-selected="false">Quarterly Assessment</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="pills-grade-tab" data-toggle="pill" href="#pills-grade" role="tab" aria-controls="pills-quarterly" aria-selected="false">Grades</a>
                                            </li>
                                        </ul>
                                    <div class="w-25 justify-content-between">
                                        <ul class="nav nav-pills mb-3 d-flex justify-content-between" id="pills-tab" role="tablist">
                                            <li class="nav-item w-100 d-flex" >
                                                <div class="btn-group w-100 d-flex justify-content-end" >
                                                    <a type="button" class="action btn-success m-5 text-white" href="./Tables/Preview/preview.php"  target="_blank">
                                                        Preview
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-spreadsheet" viewBox="0 0 16 16">
                                                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z"/>
                                                        </svg>
                                                    </a>
                                                    <button type="button" class="action btn-success m-5" data-bs-toggle="dropdown" aria-expanded="false" >
                                                        Edit Activities
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                        </svg>
                                                    </button>
                                                    <button type="submit" form="saveRecord"  class="action btn-success m-5"> 
                                                        Save changes
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                        </svg>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" id="addAct" data-bs-toggle="modal" data-bs-target="#addActivity">Add Activity</a></li>
                                                        <li><hr class="dropdown-divider"/></li>
                                                        <p class="dropdownLBL text-center">Edit Activities</p>
                                                        <li><hr class="dropdown-divider" /></li>
                                                        <?php 
                                                            include_once("getActivity.php");
                                                        ?>
                                                    </ul>
                                                    
                                                </div>
                                                
                                            </li>
                                        </ul>
                                    </div>
                                    </div>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-written" role="tabpanel" aria-labelledby="pills-written-tab">
                                            <?php 
                                                include("scoresWritten.php");
                                            ?>
                                        </div>
                                        <div class="tab-pane fade" id="pills-performance" role="tabpanel" aria-labelledby="pills-performance-tab">
                                            <?php 
                                                include("scoresPerformance.php");
                                            ?>
                                        </div>
                                        <div class="tab-pane fade" id="pills-quarterly" role="tabpanel" aria-labelledby="pills-quarterly-tab">
                                            <?php 
                                                include("scoresQuarterly.php");
                                            ?>
                                        </div>
                                        <div class="tab-pane fade" id="pills-grade" role="tabpanel" aria-labelledby="pills-grade-tab">
                                            <?php 
                                                    include("scoresGrade.php");
                                            ?>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php include_once "includes/footer.php"; ?>
            </div>
                        
            <script src="assets/js/app.min.js"></script>
            

        </body>
<?php include_once("./includes/scripts.php"); ?>


</html>