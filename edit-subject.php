<?php
include_once "includes/config.php";
session_start();

$editsubject = $DB_con->prepare("UPDATE s_subjects SET percentww = :percentww, percentpt = :percentpt, percentqt = :percentqt, tid = :tid, assignedby = :assignedby, assigndate = NOW()");

header( "Location: assignsubj.php ");