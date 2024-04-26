<?php
include_once "includes/config.php";
session_start();
$getstudentdetails = $DB_con->prepare("SELECT * FROM users24 WHERE uniqid = :uniqid");
$getstudentdetails->execute(array(':uniqid' => "WNS-6629dfee0cff7"));
$result = $getstudentdetails->fetchAll();

foreach($result as $row) {
    $to = "chester.sigua@westfields.edu.ph";
    $subject = "NEW ENROLLMENT ALERT!";

    $message = "
            <html>
            <head>
            <title>A Student has enrolled!</title>
            </head>

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