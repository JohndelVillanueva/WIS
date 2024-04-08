<?php
	include_once("includes/config.php");

	date_default_timezone_set("Asia/Manila");

    $from = $_POST['from']." 00:00:00";
    $to = $_POST['to']." 23:59:59";

	$pdo_statement = $DB_con->prepare("SELECT * FROM `attendance` INNER JOIN `user` ON `attendance`.`rfid` = `user`.`rfid` WHERE (`attendance`.`adate` BETWEEN :from AND :to) AND `attendance`.`istardy` = 1 AND `user`.`position` ='Student'");
	$pdo_statement->execute(array(":to"=>$to, ":from"=> $from));
	$result = $pdo_statement->fetchAll();
?>
<html>
	<head>
		<link rel="stylesheet" href="assets/vendors/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
	</head>
	<body>
    <br>
        <h1 class="text-center">Tardy List for <?php echo $_POST['from']." to ".$_POST['to']; ?></h1>
        <h2 class="text-center"><a href="index.php">Click here to Generate a new Report</a></h2>
        <br><hr><br>
		<div class="container vh-100">
			<div class="d-flex align-items-center">
				<div class="col-md-12">
                    <table id="userlist" class="display table">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>Section</th>
                            <th>Time In</th>
                            <th>Location</th>
                        </tr>
                        </thead>
                        <?php
                            foreach($result as $row) {
                                $easydate =  date('D d M Y', strtotime($row['adate']));
                        ?>
                        <tr>
                            <td><?php echo $easydate; ?></td>
                            <td><?php echo $row['lname'].", ".$row['fname']; ?></td>
                            <td><?php echo $row['grade']; ?></td>
                            <td><?php echo $row['section']; ?></td>
                            <td><?php echo $row['taptime']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                        </tr>
                        <?php
                            }
                        ?>
                        </tbody>
                    </table>
                    <script>
                        new DataTable('#userlist');
                    </script>
				</div>
			</div>
		</div>
	</body>
	<script type="application/javascript" src="assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="application/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script type="application/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script type="application/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script type="application/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="application/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script type="application/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#userlist').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Export to Excel',
                    }
                ]
            } );
        } );
    </script>
</html>