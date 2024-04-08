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

                <h1 class="h3 mb-3 wisfontorange">Report Generator</h1>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Parameters</div>
                            <div class="card-body">
                                <form action="showreport.php" method="post">
                                    <div class="form-group">
                                        <div class="row wisfont">
                                            <div class="col-md-1">From</div>
                                            <div class="col-md-2"><input class="form-group form-control" type="date" id="from" name="from" required></div>
                                            <div class="col-md-1">To</div>
                                            <div class="col-md-2"><input class="form-group form-control" type="date" id="to" name="to" required></div>
                                            <div class="col-md-1">Transaction</div>
                                            <div class="col-md-2">
                                                <select class="form-group form-control" name="type" id="type">
                                                    <option value="all" selected>All</option>
                                                    <option value="debit" selected>Debit</option>
                                                    <option value="credit" selected>Credit</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3"><button type="submit" class="btn btn-success w-100" name="submit"><span class="glyphicon glyphicon-list-alt"></span> Show Report</button></div>
                                        </div>
                                    </div>
                                </form>
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