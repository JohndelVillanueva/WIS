<?php 

    // GET ALL STUDENTS FROM DB
    $name= "SELECT DISTINCT(student) As studName From activities WHERE actype = 'Written'";
    $nameData = $DB_con->query($name)->fetchAll();



    // COUNT ALL THE STUDENTS FROM DB
    $getCount = "SELECT COUNT(DISTINCT student) AS MaxStud FROM activities WHERE actype = 'Written';";
    $nameCount = $DB_con->query($getCount)->fetchAll();
    $maxStud = $nameCount[0]['MaxStud'];

    
    for($i=1;$i <= 1; $i++) {
        echo "<th class='text-center'> Initial Grade</th> ";
    }

  
    echo "<tr> <th class='opacity-0'>spacer</th> </tr>";
    echo "<tr><td class='opacity-0'>spacer</td></tr>";
    echo "<tbody>";
    for ($i=0; $i<$maxStud; $i++){
        $nameList = $nameData[$i]['studName'];
        // CREATE ROW FOR STUDENT   

        /// GET THE TOTAL MAX SCORE OF WRITTEN
        $wData = "SELECT SUM(actScore) AS maxScore FROM written WHERE name = '$nameList' AND actype ='Written'  ORDER BY gender DESC, name ASC;";
        $wScore =  $DB_con->query($wData)->fetchAll();
        $maxWScore = $wScore[0]['maxScore'];
        $wTData = "SELECT SUM(mps) AS maxTotal FROM subjects WHERE actype='Written'";
        $wTotal =  $DB_con->query($wTData)->fetchAll();
        $maxWTotal = $wTotal[0]['maxTotal'];
        
        // GET THE TOTAL MAX SCORE OF performance
        $pData = "SELECT SUM(actScore) AS maxScore FROM performancetask WHERE name = '$nameList' AND actype ='Performance'  ORDER BY gender DESC, name ASC;";
        $pScore =  $DB_con->query($pData)->fetchAll();
        $maxPScore = $pScore[0]['maxScore'];
        $pTData = "SELECT SUM(mps) AS maxTotal FROM subjects WHERE actype='Performance'";
        $pTotal =  $DB_con->query($pTData)->fetchAll();
        $maxPTotal = $pTotal[0]['maxTotal'];

        // GET THE TOTAL MAX SCORE OF Quarterly
        $qData = "SELECT SUM(actScore) AS maxScore FROM quarterly WHERE name = '$nameList' AND actype ='Quarterly'  ORDER BY gender DESC, name ASC;";
        $qScore =  $DB_con->query($qData)->fetchAll();
        $maxQScore = $qScore[0]['maxScore'];
        $qTData = "SELECT SUM(mps) AS maxTotal FROM subjects WHERE actype='Quarterly'";
        $qTotal =  $DB_con->query($qTData)->fetchAll();
        $maxQTotal = $qTotal[0]['maxTotal'];

        if($maxWTotal==null || $maxPTotal == null || $maxQTotal==null){
            echo "   <td class='text-center'>";
            echo "      <p class='fw-normal mb-1 text-center '> N/A</p>";
            echo "   </td>";
       } else{
            $computedWritten = ($maxWScore/$maxWTotal)*.20;
            $computedPerformance = ($maxPScore/$maxPTotal)*.60;
            $computedQuarterly =($maxQScore/$maxQTotal)*.20;
            $computedGrade = round(($computedWritten+$computedPerformance+$computedQuarterly)*100 ,2);

            
            for($j=0; $j<1; $j++){
                $val = $j +1;
                echo "   <td class='text-center'>";
                echo "      <p class='fw-normal mb-1 text-center act$val'> $computedGrade</p>";
                echo "   </td>";
            }
       }

       
        

      
        
        // echo "<script>alert($studGrade[$i])</script>";
    

        echo "</tr>";
    }



?>