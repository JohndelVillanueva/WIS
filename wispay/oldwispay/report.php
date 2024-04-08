<?php
include_once 'classes/dbclass.php';
include_once 'header.php';
?>
<body class="loginform">
    <div class="content">
        <div class="card">
            <div class="firstinfo"><img src="img/wispay.png"/>
                <div class="profileinfo">
                    <form action="showreport.php" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">From</div>
                                <div class="col-md-6"><input type="date" id="from" name="from" required></div>
                            </div>
                            <div class="row" style="margin-top: 10px!important;">
                                <div class="col-md-3">To</div>
                                <div class="col-md-6"><input type="date" id="to" name="to" required></div>
                            </div>
                            <div class="row" style="margin-top: 10px!important;">
                                <div class="col-md-12"><button type="submit" class="btn btn-success btn-block" name="submit"><span class="glyphicon glyphicon-list-alt"></span> Show Report</button></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="badgescard"> <span class="glyphicon glyphicon-zoom-in"></span>Generate WISpay&trade; Report</div>
    </div>
</body>
<?php include_once 'footer.php'; ?>