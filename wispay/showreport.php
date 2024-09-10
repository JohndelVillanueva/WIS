<?php
require_once "config/config.php";
session_start();

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION['username'];

include_once "headers.php";
?>

<body>
    <div class="wrapper">
        <?php include_once "sidemenu.php"; ?>

        <div class="main">
            <?php include_once "topbar.php"; ?>

            <!-- CONTENT STARTS HERE -->
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
                                            <h2 class="text-center text-primary">
                                                Transaction History [<?php echo htmlspecialchars($_POST['from']) . ' to ' . htmlspecialchars($_POST['to']); ?>]
                                            </h2>

                                            <table id="userlist" class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Product type</th>
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

                                                    // Prepare query with conditional logic
                                                    $query = "SELECT W.rfid, W.refcode, W.credit, W.debit, W.transdate, W.processedby, U.fname, U.lname, W.product_type 
                                                              FROM wispay W 
                                                              INNER JOIN user U ON W.rfid = U.rfid 
                                                              WHERE transdate BETWEEN :from AND :to";

                                                    if ($_POST['type'] === 'debit') {
                                                        $query .= " AND debit > 0";
                                                    } elseif ($_POST['type'] === 'credit') {
                                                        $query .= " AND credit > 0";
                                                    }

                                                    $xhistory = $DB_con->prepare($query);
                                                    $xhistory->execute([
                                                        ':from' => $_POST['from'] . " 00:00:00",
                                                        ':to'   => $_POST['to'] . " 23:59:59"
                                                    ]);

                                                    $fullhistory = $xhistory->fetchAll();

                                                    foreach ($fullhistory as $hrow) {
                                                        $friendlytime = date("M d, Y g:i A", strtotime($hrow['transdate']));
                                                        echo "<tr>
                                                            <th scope=\"row\">{$hrow['product_type']}</th>
                                                            <td><strong>{$hrow['fname']} {$hrow['lname']}</strong> ({$hrow['rfid']})</td>
                                                            <td>{$hrow['refcode']}</td>
                                                            <td><span class='text-success'>{$hrow['credit']}</span></td>
                                                            <td><span class='text-danger'>{$hrow['debit']}</span></td>
                                                            <td>{$hrow['processedby']}</td>
                                                            <td>{$friendlytime}</td>
                                                        </tr>";
                                                    }
                                                    ?>
                                                </tbody>

                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td>Total Balance</td>
                                                    <td colspan="2" class="text-success" style="font-weight: bolder; font-size: 1.2em; text-align: right;">
                                                        <?php
                                                        $rtbalance = $DB_con->prepare("SELECT SUM(credit) - SUM(debit) AS balance FROM wispay WHERE transdate BETWEEN :from AND :to");
                                                        $rtbalance->execute([
                                                            ':from' => $_POST['from'],
                                                            ':to'   => $_POST['to']
                                                        ]);

                                                        $cbalance = $rtbalance->fetch();
                                                        echo "&#8369; " . number_format($cbalance['balance'], 2);
                                                        ?>
                                                    </td>
                                                    <td colspan="2"></td>
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
            <!-- CONTENT ENDS HERE -->

            <?php include_once "footer.php"; ?>
        </div>
    </div>

    <?php include_once "scripts.php"; ?>

    <script>
        $(document).ready(function() {
            $('#userlist').DataTable({
                dom: 'frtipB',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                    'print'
                ],
                "pageLength": 15
            });
        });
    </script>
</body>
</html>
