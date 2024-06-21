<?php
include_once 'classes/dbclass.php';
include_once 'header.php';

    //$command = escapeshellcmd('singleentry.py');
    //shell_exec($command);
    $pdo_statement = $pdo_conn->prepare("SELECT * FROM user WHERE rfid = :rfid");
    $pdo_statement->bindParam(':rfid', $_POST['rfid']);
    $pdo_statement->execute();
    $result = $pdo_statement->fetchAll();

    if(!empty($result)) {
        foreach($result as $row) {
?>
<body class="loginform">
<div class="content">
    <div class="card">
        <div class="firstinfo"><img src="img/people/employees/<?php echo $row["photo"]; ?>"/>
            <div class="profileinfo">
                <h1><?php echo $row["fname"].' '.$row["lname"]; ?></h1>
                <h2><?php echo $row["position"]; ?></h2>
            </div>
        </div>
    </div>
    <div class="badgescard"> <span class="	glyphicon glyphicon-asterisk"></span><?php echo $row["vacchist"]; ?></div>
</div>
<?php
        }
    } else {
        echo "<div class=\"alert alert-danger\">
                  <h1><strong>ERROR!</strong> Invalid RFID Card. Please report to the IT Department.</h1>
                </div>";
    }

    date_default_timezone_set('Asia/Manila');
    $numeric_date=date("G");

    if($numeric_date>=0&&$numeric_date<=11) {
        $att = "INSERT INTO attendance ( rfid, adate, clockin, clockout) VALUES ( :rfid, curdate(), curtime(), :null )";
        $att_statement = $pdo_conn->prepare( $att );
        $att_statement->execute( array( ':rfid'=>$_POST['rfid'], ':null'=>'00:00:00') );
    } else if($numeric_date>=12) {
        $att = "UPDATE attendance SET clockout=curtime() WHERE rfid = :rfid LIMIT 1";
        $att_statement = $pdo_conn->prepare( $att );
        $att_statement->execute( array( ':rfid'=>$_POST['rfid']) );
    }

?>
</body>
    <script>
        setTimeout(function(){
            window.location.href = 'index.php';
        }, 4000);
    </script>
<?php include_once 'footer.php'; ?>