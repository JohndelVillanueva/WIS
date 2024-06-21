<?php
include_once("config/config.php");
session_start();

// Redirect to index if not logged in
if (!isset($_SESSION["username"])) {
    header("location:index.php");
    exit();
}

date_default_timezone_set("Asia/Manila");
$refcode = uniqid("WIS-");

// Insert transaction into the database
$statement = $DB_con->prepare(
    'INSERT INTO wispay (debit, credit, rfid, refcode, transdate, processedby)
     VALUES (:debit, :credit, :rfid, :refcode, :transdate, :processedby)'
);

$statement->execute([
    'debit' => '0',
    'credit' => $_POST['amount'],
    'rfid' => $_POST['rfid'],
    'refcode' => $refcode,
    'transdate' => date('Y-m-d H:i:s'),
    'processedby' => $_SESSION['fname'] . " " . $_SESSION['lname']
]);

// Retrieve student information based on RFID
$getstudent = $DB_con->prepare("SELECT * FROM user WHERE rfid = :rfid");
$getstudent->execute(['rfid' => $_POST["rfid"]]);
$students = $getstudent->fetchAll();

foreach ($students as $row) {
?>
    <meta http-equiv="refresh" content="2; url=showhistory.php?success=1&rfid=<?php echo $_POST['rfid']; ?>&refcode=<?php echo $refcode; ?>" />
    <div style="width:100%; text-align:center; margin-top:-10px; font-family: 'Friz Quadrata Std Medium', sans-serif">
        <h3>WISPay RELOAD</h3>
        <h4>Reference Code<br><?php echo $refcode; ?></h4>
        <?php echo $row["fname"] . " " . $row["lname"]; ?><br>
        Date : <?php echo date('m/d/Y'); ?><br>
        <h2 style="font-weight: bold">P <?php echo $_POST['amount'] . ".00"; ?></h2><br>
        <hr>
    </div>
    <script type="text/javascript">
        window.print();
    </script>
<?php
}

die();
?>
