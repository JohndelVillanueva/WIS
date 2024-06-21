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

                <h1 class="h3 mb-3 wisfontorange">Blank Page</h1>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Empty card</h5>
                            </div>
                            <div class="card-body">
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