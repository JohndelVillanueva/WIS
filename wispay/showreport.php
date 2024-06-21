<?php
require_once("config/config.php");
session_start();

$id = $_SESSION['username'];

if (!isset($_SESSION['username'])) {
    header("location: index.php");
}

include_once("headers.php");

?>


<body>
<div class="wrapper">
    <?php include_once("sidemenu.php"); ?>
    <div class="main">
        <?php include_once("topbar.php"); ?>
        <!-- CONTENT STARTS HERE !-->
        <main class="content">
            <div class="container-fluid p-0">

                <h1 class="h3 mb-3 wisfontorange">Report Generator</h1>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Results</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="text-center text-primary">Transaction History
                                            [<?php echo $_POST["from"] . ' to ' . $_POST["to"]; ?>]</h2>
                                        <table id="userlist" class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Name (RFID)</th>
                                                <th scope="col">Reference Code</th>
                                                <th scope="col">Credit</th>
                                                <th scope="col">Debit</th>
                                                <th scope="col">Actor</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            setlocale(LC_MONETARY, "fil_PH");
                                            $query = "SELECT W.rfid, W.refcode, W.credit, W.debit, W.refcode, W.transdate, W.processedby, U.rfid, U.fname, U.lname FROM wispay W INNER JOIN user U ON W.rfid = U.rfid WHERE transdate BETWEEN :from AND :to ";
                                            if($_POST["type"]=="debit"){
                                                $query .= "AND debit > 0";
                                            } elseif($_POST["type"]=="credit"){
                                                $query .= "AND credit > 0";
                                            }
                                            $xhistory = $DB_con->prepare($query);
                                            $xhistory->execute(array(':from' => $_POST["from"]." 00:00:00", ':to' => $_POST["to"]." 23:59:59"));
                                            $fullhistory = $xhistory->fetchAll();

                                            foreach ($fullhistory as $hrow) {

                                                $time = strtotime($hrow['transdate']);
                                                $friendlytime = date("M d, Y g:i A", $time);

                                                echo "<tr>
                                        <th scope=\"row\">" . $friendlytime . "</th>
                                        <td><strong>" . $hrow['fname'] . " " . $hrow['lname'] . "</strong> (" . $hrow['rfid'] . ")</td>
                                        <td>" . $hrow['refcode'] . "</td>
                                        <td><span class='text-success'>" . $hrow['credit'] . "</span></td>
                                        <td><span class='text-danger'>" . $hrow['debit'] . "</span></td>
                                        <td>" . $hrow['processedby'] . "</td>
                                        <td>" . date("F j, Y, g:i a", strtotime($hrow['transdate'])) . "</td>";

                                            } ?>
                                            </tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Total Balance</td>
                                                <td></td>
                                                <?php
                                                $rtbalance = $DB_con->prepare("SELECT SUM(credit)-SUM(debit) AS `balance` FROM `wispay` WHERE transdate BETWEEN :from AND :to");
                                                $rtbalance->execute(array(':from' => $_POST["from"], ':to' => $_POST["to"]));
                                                $cbalance = $rtbalance->fetchAll();

                                                foreach ($cbalance as $bal) {
                                                    echo "<td style='text-align: right; font-weight: bolder; font-size:1.2em;text-align:left' class='text-success'>&#8369; " . number_format($bal['balance'], 2) . "</td>";
                                                }
                                                ?>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
        <!-- CONTENT ENDS HERE !-->
        <?php include_once("footer.php"); ?>
    </div>
</div>

<?php include_once("scripts.php"); ?>
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