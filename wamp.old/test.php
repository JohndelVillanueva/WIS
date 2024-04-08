<?php

if($_POST["type"]=="New Student") {
    $check = $DB_Con->prepare("SELECT * FROM users24 WHERE username LIKE '%S0%' ORDER BY username DESC");
    $check->execute();
    $check->fetchAll();

    foreach($check as $detail) {
        $newstudentno = $detail["username"]+1;

        $insert = $DB_Con->prepare("INSERT DASDASDASDAS username = :username");
        $insert->execute(array(":username"=>$newstudentno));
        $insert->fetchAll();

    }
} elseif ($_POST["type"]=="Old Student") {
    
}
