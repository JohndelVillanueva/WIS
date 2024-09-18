<?php
include_once "includes/config.php";
session_start();

if ($_POST['stage'] <= 8) {
    if ($_POST['stage'] == '3') {
        $process = "UPDATE users24 SET status = :status, tf = :tf  WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':tf' => $_POST['tf'], ':uniqid' => $_POST['ern']));
    } elseif ($_POST['stage'] == '4') {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));

        $date = date("Y-m-d H:i:s", strtotime($_POST["esched"]));

        $sched = "INSERT INTO schedule (title, start, end) VALUES (?, ?, ?)";
        $sched_process = $DB_con->prepare($sched);
        $sched_process->execute(array($_POST['sname']." - EXAM", $date, $date));
    } elseif ($_POST['stage'] == '5') {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));

        $date = date("Y-m-d H:i:s", strtotime($_POST["esched"]));

        $sched = "UPDATE schedule SET start = ?, end = ?, title = ? WHERE title LIKE ?";
        $sched_process = $DB_con->prepare($sched);
        $sched_process->execute(array($date,$date,$_POST["sname"]." - INTERVIEW","%".$_POST["sname"]."%"));

    } elseif($_POST['stage'] == '6') {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));

        $sched = "DELETE FROM schedule WHERE title LIKE ?";
        $sched_process = $DB_con->prepare($sched);
        $sched_process->execute(array("%".$_POST['sname']."%"));

    } elseif($_POST['stage'] == '7') {
        if (isset($_POST["official"])) {
            $process = "UPDATE users24 SET status = :status, isofficial = 1 WHERE uniqid = :uniqid";
            $process_statement = $DB_con->prepare($process);
            $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));
        } elseif (isset($_POST["unofficial"])) {
            $process = "UPDATE users24 SET status = :status, isofficial = 0 WHERE uniqid = :uniqid";
            $process_statement = $DB_con->prepare($process);
            $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));
        }

    } elseif($_POST['stage'] == '8') {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));

        $getstudentdetails = $DB_con->prepare("SELECT * FROM users24 WHERE uniqid = :uniqid");
        $getstudentdetails->execute(array(':uniqid' => $_POST['ern']));
        $result = $getstudentdetails->fetchAll();
    } elseif($_POST['stage'] == '9') {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));

        $getstudentdetails = $DB_con->prepare("SELECT * FROM users24 WHERE uniqid = :uniqid");
        $getstudentdetails->execute(array(':uniqid' => $_POST['ern']));
        $result = $getstudentdetails->fetchAll();
        var_dump($_POST);
        die();


        foreach($result as $row) {
            $to = "newstudent@westfields.edu.ph";
            $subject = "NEW ENROLLMENT ALERT!";

            $message = "
            <html>
            <head>
            <title>A Student has enrolled!</title>
            </head>
            <style>
                   td {
                        padding:10px;
                   }
                   th {
                        text-align:center;
                   }
            </style>
            <body>
            <p>A new student has joined Westfields!</p>
            <table>
            <tr>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Gender</th>
            <th>DOB</th>
            <th>Grade Level</th>
            <th>Section</th>
            <th>House</th>
            </tr>
            <tr>
            <td>".$row["fname"]."</td>
            <td>".$row["lname"]."</td>
            <td>".$row["gender"]."</td>
            <td>".$row["dob"]."</td>
            <td>".$row["grade"]."</td>
            <td>".$row["section"]."</td>
            <td>".$row["house"]."</td>
            </tr>
            </table>
            </body>
            </html>
            ";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <no-reply@westfields.edu.ph>' . "\r\n";

            mail($to,$subject,$message,$headers);
        }

    } else {
        $process = "UPDATE users24 SET status = :status WHERE uniqid = :uniqid";
        $process_statement = $DB_con->prepare($process);
        $process_statement->execute(array(':status' => $_POST['stage'], ':uniqid' => $_POST['ern']));
    }



    // var_dump($recommendationQuery);
    // die();

    $log = "INSERT INTO logs_enroll ( ern, stage, usertouch, touch, notes ) VALUES ( :ern, :stage, :user, NOW(), :notes )";
    $logstmt = $DB_con->prepare($log);
    $logstmt->execute(array(':ern' => $_POST['ern'], ':stage' => $_POST['stage'], ':user' => $_SESSION['fname'] . " " . $_SESSION['lname'], ':notes' => $_POST['notes']));

    switch ($_POST['stage']) {
        case "2":
            header("Location: registrardocs.php?ern=" . $_POST['ern']);
            die();
        case "3":
            header("Location: cashier.php?ern=" . $_POST['ern']);
            die();
        case "4":
            header("Location: admissions.php?ern=" . $_POST['ern']);
            die();
        case "5":
            // if check esl the value is 1 if not the value is null
            $esl = isset($_POST['esl']) ? 1 : NULL;

            // if check star the value is 1 if not the value is null
            $star = isset($_POST['star']) ? 1 : NULL;

            // if check completion the value is 1 if not the value is null
            $completion = isset($_POST['completion']) ? 1 : NULL;

            $recommendationQuery = $DB_con->prepare("INSERT INTO s_recommendations (user_id, esl, star, completion) VALUES (?, ?, ?, ?)");
            $recommendationQuery->execute([
                $_POST['username'], $esl, $star, $completion
            ]);
            header("Location: guidance.php?ern=" . $_POST['ern']);
            die();
        case "6":
            header("Location: interview.php?ern=" . $_POST['ern']);
            die();
        case "7":
            header("Location: registrar.php?ern=" . $_POST['ern']);
            die();
        case "8":
            header("Location: payment.php?ern=" . $_POST['ern']);
            $to = "info@westfields.edu.ph";
            $subject = "NEW STUDENT " . $_POST['ern'];
            $head = implode("\r\n", [
                "MIME-Version: 1.0",
                "Content-type: text/html; charset=utf-8"
            ]);
            $html = file_get_contents("mailtemplate.html");
            $html = str_replace("{ERN}", $_POST['ern'], $html);
            mail($to, $subject, $html, $head);
            die();
        default:
            header("Location: index.php?ern=" . $_POST['ern']);
            die();
    }
} else {
    header("Location: cashier.php?ern=" . $_POST['ern']);
    die();
}
