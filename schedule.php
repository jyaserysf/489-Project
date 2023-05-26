
<?php

 


//print_r($enrollSectSemAll);


    function yourSched($arr){

      try{
          require('Database/connection.php');
          $db->beginTransaction();
          $checkCourse=$db->prepare("SELECT * FROM courses where ID=?");
      

          

            
            $schedule = array();
            // Define the time slots for each day
            $timeslots = array(
                '8:00:00-9:00:00',
                '9:00:00-10:00:00',
                '10:00:00-11:00:00',
                '11:00:00-12:00:00',
                '12:00:00-13:00:00',
                '13:00:00-14:00:00',
                '14:00:00-15:00:00',
                '15:00:00-16:00:00',
                '16:00:00-17:00:00',
                '17:00:00-18:00:00',
            );

            //$days=['1'=>'U', '2'=>'M', '3'=>'T','4'=>'W','5'=>'H'];
            $daysOfWeek = array('U', 'M', 'T', 'W', 'H');

            foreach($arr as $enrollSect){
              $checkCourse->execute(array($enrollSect['courseID']));
              if($checkThisCourse=$checkCourse->fetch()){
                
                $courseC=$checkThisCourse['courseCode'];
              }
              
              
              $sectionNo=$enrollSect['sectionNumber'];
              $room=$enrollSect['room'];
              $final=$enrollSect['finalDate'];
              $days=str_split($enrollSect['days']);
              $startT=$enrollSect['startTime'];
              $endT=$enrollSect['endTime'];

              foreach($days as $day){
                $dayIndex = array_search($day, $daysOfWeek);
                for ($i = 0; $i < count($timeslots); $i++){
                  //echo $timeslots[1];
                  //echo strtotime($timeslots[0]);
                  $start = DateTime::createFromFormat('H:i:s', explode('-', $timeslots[$i])[0]);
                        $end =DateTime::createFromFormat('H:i:s', explode('-', $timeslots[$i])[1]);
                  $startEnrollment = DateTime::createFromFormat('H:i:s', $startT);
                  
                  $endEnrollment = DateTime::createFromFormat('H:i:s', $endT);
                        //print_r($start) .'<br>';
                        if ($startEnrollment >= $start && $endEnrollment<=$end) {
                          
                          $schedule[$dayIndex][$i][] = array(
                              'courseCode' => $courseC,
                              'sectionNumber' => $sectionNo,
                              'location' => $room,
                          );
                        }
                }
              }

            }

            $db->commit();
            $db=null;
          
          }catch(PDOException $e){
        $db->rollBack();
        die("Error: " . $e->getMessage());
      }

            // Generate the HTML table
            echo '<table width="700px">';
            echo '<tr><th>Time</th><th>U</th><th>M</th><th>T</th><th>W</th><th>H</th></tr>';

            foreach ($timeslots as $index => $timeslot) {
                echo '<tr>';
                echo '<td>' . $timeslot . '</td>';
                for ($dayIndex = 0; $dayIndex < count($daysOfWeek); $dayIndex++){
                  echo '<td>';
                  
                  if (isset($schedule[$dayIndex][$index])){
                    foreach ($schedule[$dayIndex][$index] as $class) {
                      echo $class['courseCode'] . ' - section: ' . $class['sectionNumber'] . '<br> room: ' . $class['location'] . '<br>';
                    }
                  }echo '</td>';
                }echo '</tr>';
              }
              echo '</table>';
}

//yourSched($enrollSectSemAll);








// can be used for student and instructor
// match $days value to course days (split days into single characters)
// should add parameters to get specific user data or create another function then call it in this one
// function schedule($enrollSectSemAll){ 
//     $days=['1'=>'U', '2'=>'M', '3'=>'T','4'=>'W','5'=>'H'];
//     $courseDay=[];

//     foreach($enrollSectSemAll as $enrollSect){
//       for($j=0; $j<strlen($enrollSect['days']); $j++){
//         $courseDay[$j]=$enrollSect['days'][$j];
//       }

//     }
//     print_r($courseDay);
//     echo "<table id='schedule'>"; 
//     for($i=0; $i<count($enrollSectSemAll)+1; $i++){
//      echo '<tr>';
//         foreach($days as $header){
//             if ($i==0)
//                 echo '<th>'.$header.'</th>'; //day header
//             else{
//               foreach($enrollSectSemAll as $enrollSect){
//                 foreach($courseDay as $day){
//                   if($day=='U')
//                     echo '<td> data </td>';
//                 }

//                 // if statement to add course (if course day from db match $header add to sched)
//                  // courses
//               }
              
//             }
//         }
//      echo'</tr>';
//      }
//      echo '</table>';
// }

// schedule($enrollSectSemAll);


// another schedule format 
    //  for($i=0; $i<10; $i++){
    //     echo '<tr>';
            
    //        if($i==0){
    //            for ($k=0; $k<12; $k++){
    //                echo '<th> '.$i+$k.' </th>'; //time
    //            }
    //        }
    //        else{
    //            for ($j=0; $j<12; $j++){
    //                if($j==0){
    //                    echo '<th> '.$i+$j.' </th>';//days
    //                }
    //                else
    //                    echo '<td> '.$i+$j.' </td>'; //data
    //        }
    //        }
            
           
          
    //     echo'</tr>';
    //     }



    // registering logic
    // add button
    /** once user presses on '+' section should be added to schedule 
     * (use php submit or ajax click? php would reload the page and insert into db ajax doesnt reload and can insert but idk how to manipulate other data but in theory it could work?)
     * check amount of courses enrolled {should not exceed 6 in a semester}
     * 4. check first for preReq {students needs to have passed the course (check past enrollment exists and grade not fail)}
     * 5. then check lecture conflict (how to compare time)
     * 6. then check final conflict (same time and day)
     * 7. THEN add course section to enrollment 
     * 8. then decrease available seats in course sections 
     * how to check if student has payed??? to confirm seat (should be within enrollment period from db)
     *  */



    if (isset($_POST['function'])) {
      $functionName = $_POST['function'];
      if (function_exists($functionName)) {
        call_user_func($functionName);
      }
    }
    
    // function addS() {
    //   //echo" myFunction called! ";
    //   if(isset($_POST['addcourse'])&& isset($_POST['selectC']) && isset($_POST['selectS'])){
    //     echo "<h5>added seat successfully! </h5>";
    //   }elseif(isset($_POST['addcourse'])&& isset($_POST['selectC'])){
    //       //popup -> must select course section
    //       echo "select course section before adding";
    //   }elseif(isset($_POST['addcourse'])){
    //       // popup-> must select course
    //       echo "select course before adding";
    //   }
    // }
    
    function anotherFunction() {
      // your PHP code here
      echo "anotherFunction called!";
    }
     

    // replace course section (seat)
    /** use UPDATE to sql
     * user should select course to be replaced first (make course in schedule clickable ((same ajax call as section button)) -> info appears in info box then resubmit again through buttons)
     * available sections appear in section area
     * student can select another section
     * apply steps 4-7 from add
     * increase original section seat , decrease new section seat
     * 
     */

     //delete or drop seat
     /**
      * user should select course to be dropped first (make course in schedule clickable ((same ajax call as section button)) -> info appears in info box then resubmit again through buttons)
      * use DELETE to remove enrollment record
      * pop up should appear (js console) {are you sure you want to drop this course etc etc}
      * if yes -> delete record , increase section seat  
      * if cancel -> break function
      */

      // general notes
      /** 
       *  should add 'approve' button at end to check if student has appropriate amount of courses {3-6}
       *  how to check if student has payed??? to confirm seat (should be within enrollment period from db)
       * each of above should be seperate function that is called in courseReg page
       * each function should call other function that adds course to schedule visually 
       */
    
    
?>