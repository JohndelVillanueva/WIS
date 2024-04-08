<?php 

    // GET ALL STUDENTS FROM DB
    $name= "SELECT DISTINCT(student) As studName From activities WHERE actype = 'Written'";
    $nameData = $DB_con->query($name)->fetchAll();



    // COUNT ALL THE STUDENTS FROM DB
    $getCount = "SELECT COUNT(DISTINCT student) AS MaxStud FROM activities WHERE actype = 'Written';";
    $nameCount = $DB_con->query($getCount)->fetchAll();
    $maxStud = $nameCount[0]['MaxStud'];

    
    for($i=1;$i <= 1; $i++) {
        echo "<th class='text-center'> Final Grade</th> ";
    }

  
    echo "<tr> <th class='opacity-0'>asd</th> </tr>";
    echo "<tr><td class='opacity-0'>spacer</td></tr>";
    echo "<tbody>";
    for ($i=0; $i<$maxStud; $i++){
        $nameList = $nameData[$i]['studName'];
        // CREATE ROW FOR STUDENT   

        // GET THE TOTAL MAX SCORE OF WRITTEN
        $wData = "SELECT SUM(actgrade) AS maxScore,SUM(maxPossibleScore) AS MaxTotal FROM activities WHERE student = '$nameList'and actype = 'Written';";
        $wTotal =  $DB_con->query($wData)->fetchAll();
        $maxWTotal = $wTotal[0]['MaxTotal'];
        $maxWScore = $wTotal[0]['maxScore'];
        
        // GET THE TOTAL MAX SCORE OF performance
        $pData = "SELECT SUM(actgrade) AS maxScore,SUM(maxPossibleScore) AS MaxTotal FROM activities WHERE student = '$nameList'and actype = 'Performance';";
        $pTotal =  $DB_con->query($pData)->fetchAll();
        $maxPTotal = $pTotal[0]['MaxTotal'];
        $maxPScore = $pTotal[0]['maxScore'];

        // GET THE TOTAL MAX SCORE OF Quarterly
        $qData = "SELECT SUM(actgrade) AS maxScore,SUM(maxPossibleScore) AS MaxTotal FROM activities WHERE student = '$nameList'and actype = 'Quarterly';";
        $qTotal =  $DB_con->query($qData)->fetchAll();
        $maxQTotal = $qTotal[0]['MaxTotal'];
        $maxQScore = $qTotal[0]['maxScore'];


        $computedWritten = ($maxWScore/$maxWTotal)*.20;
        $computedPerformance = ($maxPScore/$maxPTotal)*.60;
        $computedQuarterly =($maxQScore/$maxQTotal)*.20;
        $computedGrade = round(($computedWritten+$computedPerformance+$computedQuarterly)*100 ,2);

        
        // for($j=0; $j<1; $j++){
        //     $val = $j +1;
        //     echo "   <td class='text-center'>";
        //     echo "      <p class='fw-normal mb-1 text-center act$val'> $computedGrade</p>";
        //     echo "   </td>";
        // }
        

      
        
        // echo "<script>alert($studGrade[$i])</script>";
    

        echo "</tr>";
    }



?>