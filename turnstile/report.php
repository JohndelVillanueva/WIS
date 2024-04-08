<?php
	include_once("includes/config.php");

	$pdo_statement = $DB_con->prepare("SELECT * FROM user INNER JOIN attendance");
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();

?>
<html>
	<head>
		<link rel="stylesheet" href="assets/vendors/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="""assets/vendors/datatables/dataTables.bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/style.css">
	</head>
	<body class="bodybg">
		<div class="container vh-100">
			<div class="d-flex align-items-center" style ="height: 100%">
				<div class="col-md-12">
					<div class="wrapper p-5">
						<div class="logo"><img src="assets/images/logo/main.png" style="max-width: 150px;margin-top: -100px;"></div>	
						<div class="row" style="margin-top:-30px;">
							<?php
							if(!empty($result)) {
								foreach($result as $row) {
									?>
										<table id="userlist" class="display table table-striped" style="width:100%">
										<thead>
										<tr>
											<th>First Name</th>
											<th>Last Name</th>
											<th>Position</th>
											<th>RFID</th>
											<th>Actions</th>
										</tr>
										</thead>
										<tbody>
										<?php
										$pdo_statement = $DB_con->prepare("SELECT * FROM user WHERE position != 'Student'");
										$pdo_statement->execute();
										$result = $pdo_statement->fetchAll();
										foreach($result as $row) {
										?>
											<tr>
												<td><?php echo $row['fname']; ?></td>
												<td><?php echo $row['lname']; ?></td>
												<td><?php echo $row['position']; ?></td>
												<td><?php echo $row['rfid']; ?></td>
												<td>
													<a type="button" href="addmoney.php?rfid=<?php echo $row['rfid']; ?>" class="btn btn-outline-success shadow-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Money">Reload</a>
													<a type="button" href="showhistory.php?rfid=<?php echo $row['rfid']; ?>" class="btn btn-outline-primary shadow-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Show History">History</a>
												</td>
											</tr>
											<?php
										}
										?>
										</tbody>
									</table>
									<?php
								}
							}
							?>
						</div>
					</div>
				</div>1
			</div>
		</div>
	</body>
	<script>
    $(document).ready(function() {
        $('#userlist').DataTable( {
            dom: 'frtipB',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
                'print'
            ],
            "pageLength":15
        } );
    } );
</script>
	<script type="application/javascript" src="assets/js/jquery.min.js"></script>
	<script type="application/javascript" src="assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="application/javascript" src="""assets/vendors/datatables/dataTables.bootstrap.min.js"></script>
	<script type="application/javascript" src="""assets/vendors/datatables/jquery.dataTables.min.js"></script>
	<script>

    function currentTime() {
        let date = new Date();
        let hh = date.getHours();
        let mm = date.getMinutes();
        let ss = date.getSeconds();
        let session = "AM";

        if(hh == 0){
            hh = 12;
        }
        if(hh > 12){
            hh = hh - 12;
            session = "PM";
        }

        hh = (hh < 10) ? "0" + hh : hh;
        mm = (mm < 10) ? "0" + mm : mm;
        ss = (ss < 10) ? "0" + ss : ss;

        let time = hh + ":" + mm + ":" + ss + " " + session;

        document.getElementById("clock").innerText = time;
        let t = setTimeout(function(){ currentTime() }, 1000);
    }
    currentTime();
			
</script>
</html>