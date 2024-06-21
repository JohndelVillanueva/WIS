<?php
require_once("config/config.php");
session_start();

$id = $_SESSION['username'];

if(!isset($_SESSION['username']))
{
    header("location: index.php");
}

include_once ("headers.php");

?>


<body>
<div class="wrapper">
<?php include_once ("sidemenu.php");?>
    <div class="main">
        <?php include_once ("topbar.php");?>
<!-- CONTENT STARTS HERE !-->
        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3 wisfontorange">Event Management</h1>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <button class="nav-link active" id="v-pills-events-tab" data-bs-toggle="pill" data-bs-target="#v-pills-events" type="button" role="tab" aria-controls="v-pills-events" aria-selected="true">Events</button>
                                        <button class="nav-link" id="v-pills-judges-tab" data-bs-toggle="pill" data-bs-target="#v-pills-judges" type="button" role="tab" aria-controls="v-pills-judges" aria-selected="false">Judges</button>
                                    </div>
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-events" role="tabpanel" aria-labelledby="v-pills-events-tab">

                                        </div>
                                        <div class="tab-pane fade" id="v-pills-judges" role="tabpanel" aria-labelledby="v-pills-judges-tab">...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
<!-- CONTENT ENDS HERE !-->
        <?php include_once ("footer.php");?>
    </div>
</div>

<?php include_once ("scripts.php");?>
</body>

</html>