<?php
include_once "includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    $activity = $_POST["activity"];
    $coach = $_POST["coach"];
    $sessions = $_POST["sessions"];
    $rate = $_POST["rate"];

    $updateActivity = $DB_con->prepare("UPDATE afterschool_activities SET activity = :activity, coach = :coach, max = :sessions, rate = :rate WHERE id = :id");
    $updateActivity->execute([
        ":activity" => $activity,
        ":coach" => $coach,
        ":sessions" => $sessions,
        ":rate" => $rate,
        ":id" => $id
    ]);

    header("location: other-activities.php");
    exit;
}
?>