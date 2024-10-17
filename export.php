<?php
include_once "includes/config.php";
session_start();

if (isset($_POST["Export"])) {
    // Fetch filters from the POST request
    $gradelevel = $_POST["gradelevel"];
    $section = $_POST["section"];
    $type = $_POST["type"];
    $house = $_POST["house"];

    // Start the CSV export process
    $filename = "students_" . date("Ymd") . ".csv";
    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=\"$filename\"");

    // Open output stream for CSV
    $output = fopen("php://output", "w");

    // CSV headers
    fputcsv($output, array("Last Name", "First Name", "Middle Name", "Date of Birth", "Gender", "LRN", "Previous School", "Nationality", "House", "Religion"));

    // Construct SQL query
    $sql = "SELECT lname, fname, mname, dob, gender, lrn, prevsch, nationality, house, religion 
            FROM users24 WHERE 1 = 1"; // Using "1 = 1" to allow appending conditions

    // Prepare parameters array for binding
    $params = array();

    // Add conditions based on the filters
    if (!empty($gradelevel)) {
        $sql .= " AND grade = :grade";
        $params[":grade"] = $gradelevel;
    }
    if (!empty($section)) {
        $sql .= " AND section = :section";
        $params[":section"] = $section;
    }
    if (!empty($type)) {
        $sql .= " AND type = :type";
        $params[":type"] = $type;
    }
    if (!empty($house)) {
        $sql .= " AND house = :house";
        $params[":house"] = $house;
    }

    // Prepare and execute the statement
    $pdo_statement = $DB_con->prepare($sql);
    $pdo_statement->execute($params);

    // Fetch and write the data to the CSV file
    $result = $pdo_statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        fputcsv($output, $row);
    }

    // Close output stream
    fclose($output);
    exit;
}
