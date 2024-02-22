<?php
include_once "includes/config.php";
session_start();

if($_POST['stage']<=8){
    if($_POST['stage']=='3'){
        $process = "UPDATE user SET status = :status, tf = :tf  WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare( $process );
        $process_statement->execute( array( ':status'=>$_POST['stage'], ':tf'=>$_POST['tf'], ':uniqid'=>$_POST['ern']) );
		
    } elseif($_POST['stage']=='4'){
        $process = "UPDATE user SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare( $process );
        $process_statement->execute( array( ':status'=>$_POST['stage'], ':uniqid'=>$_POST['ern']) );

        $date = date("Y-m-d H:i:s",strtotime($_POST["esched"]));

        $sched = "INSERT INTO schedule (title, start, end) VALUES (?, ?, ?)";
        $sched_process = $DB_con->prepare($sched);
        $sched_process->execute(array( $_POST['sname'], $date, $date));
    } elseif($_POST['stage']=='5'){
		$process = "UPDATE user SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare( $process );
        $process_statement->execute( array( ':status'=>$_POST['stage'], ':uniqid'=>$_POST['ern']) );
		
		$sched = "DELETE FROM schedule WHERE title = ?";
        $sched_process = $DB_con->prepare($sched);
        $sched_process->execute(array( $_POST['sname']));
	}else {
        $process = "UPDATE user SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare( $process );
        $process_statement->execute( array( ':status'=>$_POST['stage'], ':uniqid'=>$_POST['ern']) );
    }

    $log = "INSERT INTO logs_enroll ( ern, stage, usertouch, touch, notes ) VALUES ( :ern, :stage, :user, NOW(), :notes )";
    $logstmt = $DB_con->prepare( $log );
    $logstmt->execute( array( ':ern'=>$_POST['ern'], ':stage'=>$_POST['stage'], ':user'=>$_SESSION['fname']." ".$_SESSION['lname'], ':notes'=>$_POST['notes'] ) );

    switch($_POST['stage']) {
        case "2":
			header("Location: registrardocs.php?ern=".$_POST['ern']);
            die();
        case "3":
            header("Location: cashier.php?ern=".$_POST['ern']);
            die();
        case "4":
            header("Location: admissions.php?ern=".$_POST['ern']);
            die();
        case "5":
            header("Location: guidance.php?ern=".$_POST['ern']);
            die();
        case "6":
            header("Location: interview.php?ern=".$_POST['ern']);
            die();
        case "7":
            header("Location: registrar.php?ern=".$_POST['ern']);
            die();
        case "8":
            header("Location: payment.php?ern=".$_POST['ern']);
			$to = "info@westfields.edu.ph";
			$subject = "NEW STUDENT ".$_POST['ern'];
			$head = implode("\r\n", [
			  "MIME-Version: 1.0",
			  "Content-type: text/html; charset=utf-8"
			]);
			$html = file_get_contents("mailtemplate.html");
			$html = str_replace("{ERN}", $_POST['ern'], $html);
			mail($to, $subject, $html, $head);
            die();
        default:
            header("Location: index.php?ern=".$_POST['ern']);
            die();
    }

} else {
    header("Location: cashier.php?ern=".$_POST['ern']);
    die();
}