<?php
    
    // GET ALL nameS FROM DB
    $name= "SELECT DISTINCT(name) As studName From performancetask  ORDER BY gender DESC,name ASC";
    $nameData = $DB_con->query($name)->fetchAll();
    // COUNT ALL THE nameS FROM DB
    $getCount = "SELECT COUNT(DISTINCT name) AS MaxStud FROm performancetask ORDER BY gender DESC,name ASC;";
    $nameCount = $DB_con->query($getCount)->fetchAll();
    $maxStud = $nameCount[0]['MaxStud'];

    // GET THE NUMBER OF ACTIVITIES
    $getAct = "SELECT COUNT(actnum) AS MaxCol From subjects WHERE actype = 'Performance';";
    $actCount = $DB_con->query($getAct)->fetchAll();
    $maxAct = $actCount[0]['MaxCol'];


    $row = "SELECT COUNT(actnum) AS MaxCol From subjects WHERE actype = 'Performance';";
    $rowData = $DB_con->query($row)->fetchAll();
    $rowMax = $rowData[0]['MaxCol'];

    if($rowMax!=0) {
        for($i=1;$i <= $rowMax; $i++) {
            echo "<th class='text-center'> $i </th>";
        }
    }
    else {
        // echo "<script>alert('asdasd') </script>";
    }


    echo "<th class='text-center'> Total </th>";
    echo "<th class='text-center'> PS </th>";
    echo "<th class='text-center'> WS </th>";

    echo "<tr>";
    for($i=1; $i<=$rowMax; $i++){
        $maxScore = "SELECT MAX(mps) AS maxScore, SUM(mps) AS maxTotal FROM subjects WHERE actype='Performance' and actnum='$i';";
        $maxScoreTotal = $DB_con->query($maxScore)->fetchAll();
        $maxTotal = $maxScoreTotal[0]['maxScore'];
        echo "<th class='text-center'>$maxTotal</th>";
    }
    $maxScore = "SELECT SUM(mps) AS maxTotal FROM subjects WHERE actype='Performance';";
    $maxScoreTotal = $DB_con->query($maxScore)->fetchAll();
    $total = $maxScoreTotal[0]['maxTotal'];
    if($total ==null){
        echo "<th class='text-center'>N/A</th>";
        echo "<th class='text-center'>100.00</th>";
        echo "<th class='text-center'>60%</th>";
    } else{
        echo "<th class='text-center'>$total</th>";
        echo "<th class='text-center'>100.00</th>";
        echo "<th class='text-center'>60%</th>";
    }
  


   
    echo"</tr>";
    if ($rowMax<1){
        echo "<tr><td>asd</td></tr>";

    }else{
        echo "<tr>";
        for($i=0;$i<$rowMax;$i++){
            $val = $i+1;
            $getTypeData = "SELECT type FROM subjects WHERE actype ='Performance' and actnum = '$val'";
            $getType = $DB_con->query($getTypeData)->fetchAll();
            $type = $getType[0]['type'];
            if($type=='Quiz'){
                echo "<th class='text-center'>Quiz</th>";
            }if($type=='PT'){
                echo "<th class='text-center'>PT</th>";
            }
    
        }
        echo "</tr>";

    }
    echo "<tbody>";
    for ($i=0; $i<$maxStud; $i++){
        
        $nameList = $nameData[$i]['studName'];
        // CREATE ROW FOR name   
        // GET ACTIVITIES
        $val = $i +1;
        $studScore = "SELECT actScore,name From performancetask WHERE actnum= '$val' ORDER BY gender DESC, name ASC;";
        $studData =  $DB_con->query($studScore)->fetchAll();
        
        $getActPer = "SELECT COUNT(actnum) AS actMax FROM subjects WHERE actype='Performance'";
        $actperCount = $DB_con->query($getActPer)->fetchAll();
        $maxActPerStud = $actperCount[0]['actMax'];

       
        // GET THE TOTAL MAX SCORE OF Performance
        $maxTOTAL = "SELECT SUM(mps) AS maxTotal FROM subjects WHERE actype='Performance';";
        $maxTOTAL = $DB_con->query($maxTOTAL)->fetchAll();
        $maxTOTAL = $maxTOTAL[0]['maxTotal'];
        
        $maxScore = "SELECT SUM(actScore) AS maxScore FROm performancetask WHERE name = '$nameList'";
        $maxScoreTotal = $DB_con->query($maxScore)->fetchAll();
        $maxScore = $maxScoreTotal[0]['maxScore'];

        if($maxTOTAL==null){
          
            echo "
            <td class='text-center'>
                <p type='text' class='border-1 fw-normal mb-1 text-center ww' name='actScore' disabled>N/A</p>
            </td> <script>console.log('WLA')</script>";
               
            echo "
            <td class='text-center'>
                <p type='text' class='border-1 fw-normal mb-1 text-center ww' name='actScore' disabled>N/A</p>
            </td>
            <td class='text-center'>
                <p type='text' class='border-1 fw-normal mb-1 text-center ww' name='actScore' disabled>N/A</p>
            </td> ";
            // echo "<script>alert($studGrade[$i])</script>";
        }
        else{
            $computedPerformance = round(100*($maxScore/$maxTOTAL)*.60 ,2);
            $computedPerformanceTotal = round(100*($maxScore/$maxTOTAL) ,2);

            for($j=0; $j<$maxActPerStud; $j++){
                $val = $j +1;
                    $studScore = "SELECT actScore From performancetask WHERE actnum='$val' ORDER BY gender DESC, name ASC ";
                    $studData =  $DB_con->query($studScore)->fetchAll();
                    $studGrade = $studData[$i];
                    echo "
                    <td class='text-center'>
                        <p type='text' class='border-1 fw-normal mb-1 text-center ww$val' name='actScore' disabled>$studGrade[0]</p>
                    </td>";
               
            }
            echo "
            <td class='text-center'>
                <p type='text' class='border-1 fw-normal mb-1 text-center ww$val' name='actScore' disabled>$maxScore</p>
            </td>
            <td class='text-center'>
                <p type='text' class='border-1 fw-normal mb-1 text-center ww$val' name='actScore' disabled>$computedPerformanceTotal</p>
            </td>
            <td class='text-center'>
                <p type='text' class='border-1 fw-normal mb-1 text-center ww$val' name='actScore' disabled>$computedPerformance</p>
            </td>
            ";
            // echo "<script>alert($studGrade[$i])</script>";
        
        }

        

        echo "</tr>";
    }
    echo "<tr class='TR'>";
    for($i=0;$i<$rowMax;$i++){
        $getTypeData = "SELECT actname FROM subjects WHERE actype ='Performance' and actnum = '$val'";
        $getType = $DB_con->query($getTypeData)->fetchAll();
        $actname = $getType[0]['actname'];
        echo "<th class='rotate border-0'>$actname</th>";
    }
    echo "</tr>";
    echo "</tbody>";


?>
