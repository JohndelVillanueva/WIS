<?php
    $row = "SELECT COUNT(actype) AS MaxCol From subjects WHERE actype='Quarterly';";
    $rowData = $DB_con->query($row)->fetchAll();
    $rowMax = $rowData[0]['MaxCol'];

    if($rowMax!=0) {
        for($i=1;$i <= $rowMax; $i++) {
            $val = $i - 1;
       
            $getActName = "SELECT actype, actnum ,actname,type FROM subjects WHERE actype='Quarterly' ORDER BY actnum ASC;";
            $actNameData = $DB_con->query($getActName)->fetchAll();
            $actName = $actNameData[$val]['actname'];

            $actTypeData = $DB_con->query($getActName)->fetchAll();
            $actType = $actTypeData[$val]['type'];
            echo "<th class='text-center' data-mdb-toggle='tooltip' title='$actName - $actType'> Quarter $i </th> ";
           
        }
    }
    else {
        // echo "<script>alert('asdasd') </script>";
    }
 

?>