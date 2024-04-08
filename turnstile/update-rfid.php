<html>
	<head>
		<link rel="stylesheet" href="assets/vendors/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
    <script>
        $('body').on('keydown', 'input, select', function(e) {
            if (e.key === "Enter") {
                var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
                focusable = form.find('input,a,select,button,textarea').filter(':visible');
                next = focusable.eq(focusable.index(this)+1);
                if (next.length) {
                    next.focus();
                } else {
                    form.submit();
                }
                return false;
            }
        });
    </script>
	<body>
		<form method="post" action="update-rfid-process.php">
		<div class="container vh-100" style="width:700px;">
			<div class="d-flex align-items-center" style ="height: 100%">
				<div class="col-md-12 animateMe">
					<div class="wrapper p-5">
						<div class="logo"><img src="assets/images/logo/main.png" style="max-width: 200px;margin-top: -100px;"></div>	
						<div class="row">
							<div class="col-sm-12 d-flex align-items-center">
							</div>
						</div>
                        <form method="post" action="update-rfid-process.php">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="oldRFID" class="form-control form-control-lg" name="oldRFID" aria-describedby="oldRFID" placeholder="OLD RFID" autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="newRFID" class="form-control form-control-lg" name="newRFID" aria-describedby="newRFID" placeholder="NEW RFID">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-lg btn-block btn-success">Submit Changes</button>
                                </div>
                            </div>
                        </form>
					</div>
				</div>
			</div>
		</div>
		</form>
	</body>
	<script type="application/javascript" src="assets/js/jquery.min.js"></script>
	<script type="application/javascript" src="assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</html>