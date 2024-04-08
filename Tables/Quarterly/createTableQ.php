<?php
    
   

    // COUNT ALL THE STUDENTS FROM DB
    $getCount = "SELECT COUNT(DISTINCT name) AS MaxStud FROM quarterly ORDER BY gender DESC, name ASC;";
    $nameCount = $DB_con->query($getCount)->fetchAll();
    $maxStud = $nameCount[0]['MaxStud'];
    
    // GET THE NUMBER OF ACTIVITIES
    $getAct = "SELECT COUNT(actype) AS MaxCol From subjects WHERE actype = 'Quarterly';";
    $actCount = $DB_con->query($getAct)->fetchAll();
    $maxAct = $actCount[0]['MaxCol'];


    echo "<tbody id='tableWB'>";
    if($maxAct == 0){
        for ($s=0; $s<$maxStud; $s++){
            $actnum = $s+1;
            $name= "SELECT DISTINCT name FROM `quarterly` ORDER BY gender DESC,name ASC;";
            $nameData = $DB_con->query($name)->fetchAll();
            $nameList = $nameData[$s]['name'];
            // CREATE ROW FOR STUDENT   
            echo "<tr class='tableInput'>";
            echo "   <td class='text-center'>";
            echo "       <div class='d-flex align-items-center'>";
            echo "          <div class='ms-3'>";
            echo "            <p class='fw-bold mb-1' id='$nameList'>$nameList</p>";
            echo "          </div>";
            echo "       </div>";
            echo "    </td>";
            echo "
            <td class='text-center'>
                <p>No activities found</p>
            </td>";
          
        }
          
       
    } else{
        for ($i=0; $i<$maxStud; $i++){
            // GET ALL STUDENTS FROM DB
           $name= "SELECT name FROM `quarterly` WHERE actnum = '$maxAct'  ORDER BY gender DESC,name ASC;";
           $nameData = $DB_con->query($name)->fetchAll();
           $nameList = $nameData[$i]['name'];
           // CREATE ROW FOR STUDENT   
     
           echo "<tr class='tableInput'>";
           echo "   <td class='text-center'>";
           echo "       <div class='d-flex align-items-center'>";
           echo "          <div class='ms-3'>";
           echo "            <p class='fw-bold mb-1' id='$nameList'>$nameList</p>";
           echo "          </div>";
           echo "       </div>";
           echo "    </td>";
   
   
       
           
           // $getActPer = "SELECT qq$val, COUNT(activity) AS actMax FROM activities WHERE actype = 'Quarterly' GROUP BY name ORDER BY gender DESC, name ASC";
           // $actperCount = $DB_con->query($getActPer)->fetchAll();
           // $maxActPerStud = $actperCount[$i]['actMax'];
           
           // $nextAct = $maxActPerStud+1;
           // INSERT A COLUMN DEPENDING ON NUMBER OF MAX ACTIVITIES AND ADD A DEFAULT SCORE OF ZERO (0);
           // if($maxAct>$maxActPerStud){
           //     $insertData = "INSERT INTO `activities` (`id`, `rfid`, `subject`, `glevel`, `student`, `activity`, `actqtr`, `actype`, `actdate`, `actgrade`, `maxPossibleScore`) 
           //     VALUES (NULL, '1298211122', 'English 1', '6', '$nameList', '$nextAct', '0', 'Quarterly', '2023-01-20 00:28:28', 'null', '10');";
           //     $insertToDB = $DB_con->query($insertData)->fetchAll();
           // } 
           // else if($maxAct<$maxActPerStud){
           //     $deleteAct = "DELETE FROM activities WHERE activity > $maxAct;";
           //     $deleteDB = $DB_con->query($deleteAct)->fetchAll();
           //     include_once("../../reset.php");
           // }
   
          if($maxAct>0){
               // GET ACTIVITIES
               $val = $i +1;
               for($j=0; $j<$maxAct; $j++){
                   $val = $j +1;
                   $studScore = "SELECT actscore From quarterly WHERE actnum='$val' AND actype='Quarterly' ORDER BY gender DESC, name ASC ";
                   $studData =  $DB_con->query($studScore)->fetchAll();
                   $studGrade = $studData[$i];

                   $wData = "SELECT mps From subjects WHERE actnum = '$val' AND actype='Quarterly'";
                   $wTotal =  $DB_con->query($wData)->fetchAll();
                   $maxWTotal = $wTotal[0]['mps'];
   
                   $check = 100*($studGrade[0]/$maxWTotal);
   
   
                   if($check<50){
                       echo "
                       <td class='text-center'>
                           <form method='post' action='save.php'>
                               <input type='text'  maxlength='2' size='3' class='fail border-1 fw-normal mb-1 text-center qq$val' value='$studGrade[0]' name='actScore' disabled>
                               <input type='hidden' name='student' value='$nameList'>
                               <input type='hidden' name='val' value='$val'>
                               <input type='hidden' name='actype' value='Quarterly'>
                           </form>
                       </td>";
                   } else{
                       echo "
                       <td class='text-center'>
                           <form method='post' action='save.php'>
                               <input type='text'  maxlength='2'  size='3' class='border-1 fw-normal mb-1 text-center qq$val' value='$studGrade[0]' name='actScore' disabled>
                               <input type='hidden' name='student' value='$nameList'>
                               <input type='hidden' name='val' value='$val'>
                               <input type='hidden' name='actype' value='Quarterly'>
                           </form>
                       </td>";
                   }
                   
                   
               }
   
          } else{
           echo "
           <td class='text-center'>
               <p>No activities found</p>
           </td>";
          }
   
           // echo "<script>alert($studGrade[$i])</script>";
       
   
           echo "</tr>";
       }
    }
    echo "</tbody>";


?>
