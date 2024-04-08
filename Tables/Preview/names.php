<?php
    
    // GET ALL STUDENTS FROM DB
    $name= "SELECT DISTINCT(student) As studName From activities WHERE actype = 'Written' ORDER BY gender DESC,student ASC ";
    $nameData = $DB_con->query($name)->fetchAll();
    // COUNT ALL THE STUDENTS FROM DB
    $getCount = "SELECT COUNT(DISTINCT student) AS MaxStud FROM activities WHERE actype = 'Written' ORDER BY gender DESC,student ASC ;";
    $nameCount = $DB_con->query($getCount)->fetchAll();
    $maxStud = $nameCount[0]['MaxStud'];

    // GET THE NUMBER OF ACTIVITIES
    $getAct = "SELECT COUNT(actnum) AS MaxCol From subjects ";
    $actCount = $DB_con->query($getAct)->fetchAll();
    $maxAct = $actCount[0]['MaxCol'];

    $row = "SELECT COUNT(actnum) AS MaxCol From subjects ";
    $rowData = $DB_con->query($row)->fetchAll();
    $rowMax = $rowData[0]['MaxCol'];
    
  
    echo "<tr> <th class='text-end'> Activity </th></tr>";
    echo "<tr>";
    for($i=0; $i<1;$i++){
        echo "<th class='text-end'> Highest Possible Score </th>";
    }
    echo"</tr>";
    echo "<tr>";
    echo " <th class='text-end opacity-0'> 0 </th>";
    echo "</tr>";
    echo "<tbody>";
    for ($i=0; $i<$maxStud; $i++){
        
        $nameList = $nameData[$i]['studName'];
        // CREATE ROW FOR STUDENT   
  
        echo "<tr>";
        echo "   <td class='text-center'>";
        echo "       <div class='d-flex align-items-center'>";
        echo "          <div class='ms-2'>";
        echo "            <p class='fw-bold mb-1' id='$nameList'>$nameList</p>";
        echo "          </div>";
        echo "       </div>";
        echo "    </td>";
        echo "</tr>";
    }
    echo "</tbody>";


?>
