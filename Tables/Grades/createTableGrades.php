<?php 

    // GET ALL STUDENTS FROM DB
    $name= "SELECT DISTINCT(student) As studName From activities WHERE actype = 'Written' ORDER BY gender DESC, student ASC";
    $nameData = $DB_con->query($name)->fetchAll();

    // COUNT ALL THE STUDENTS FROM DB
    $getCount = "SELECT COUNT(DISTINCT student) AS MaxStud FROM activities WHERE actype = 'Written' ORDER BY gender DESC, student ASC;";
    $nameCount = $DB_con->query($getCount)->fetchAll();
    $maxStud = $nameCount[0]['MaxStud'];

    echo "<tbody>";

    for ($i=0; $i<$maxStud; $i++){
        $nameList = $nameData[$i]['studName'];
        // CREATE ROW FOR STUDENT   
        echo "<tr>";
        echo "   <td class='text-center'>";
        echo "       <div class='d-flex align-items-center'>";
        echo "          <div class='ms-3'>";
        echo "            <p class='fw-bold mb-1'>$nameList</p>";
        echo "          </div>";
        echo "       </div>";
        echo "    </td>";
        // GET ACTIVITIES
        $val = $i +1;
        $studScore = "SELECT actgrade From activities WHERE activity= '$val' AND actype='Written' ORDER BY gender DESC, student ASC";
        $studData =  $DB_con->query($studScore)->fetchAll();
        

        // GET THE TOTAL MAX SCORE OF WRITTEN
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
            echo "      <p class='fw-normal mb-1 text-center act$val'> N/A</p>";
            echo "   </td>";
       }else{
        $computedWritten = ($maxWScore/$maxWTotal)*.20;
        $computedPerformance = ($maxPScore/$maxPTotal)*.60;
        $computedQuarterly =($maxQScore/$maxQTotal)*.20;
        $computedGrade = round(($computedWritten+$computedPerformance+$computedQuarterly)*100);  

        $pdo_statement = $DB_con->prepare("UPDATE studentgrade SET quarter1 = '$computedGrade'
        WHERE student ='$nameList'");
        $pdo_statement->execute();


        for($j=0; $j<1; $j++){
            $val = $j +1;
            $check = $computedGrade;
            if($check<75){
                echo "   <td class='text-center'>";
                echo "      <p class='fail fw-normal mb-1 text-center act$val'> $computedGrade</p>";
                echo "   </td>";
            }else{
                echo "   <td class='text-center'>";
                echo "      <p class='fw-normal mb-1 text-center act$val'> $computedGrade</p>";
                echo "   </td>";
            }
            
        }
        
       }

      
        
    

        echo "</tr>";
    }



?>