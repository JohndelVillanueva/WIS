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

                <h1 class="h3 mb-3 wisfontorange">Student Database</h1>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
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
                                    $pdo_statement = $DB_con->prepare("SELECT * FROM user WHERE position = 'Student'");
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
</body>

</html>