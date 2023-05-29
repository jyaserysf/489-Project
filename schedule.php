<html>
  <head>
    <style>
      .scheduleTable {
        border: 1px solid rgb(249, 235, 200);
        background-color: rgba(249, 235, 200, 0.5);
        text-align: center;
      }

      .daysRow {
        background-color: rgb(249, 235, 200);
        color: rgba(0, 0, 0, 0.65);
      }

      .timeCol {
        background-color: rgb(249, 235, 200);
        width: 7rem;
        height: 1rem;
        font-size: 0.8rem;
        padding: 0.5rem;
        color: rgba(0, 0, 0, 0.65);
      }

      .section-button {
        color: rgba(0, 0, 0, 0.65);
        background: none;
        width: 100%;
        border: none;
        font-size: 0.6rem;
        text-align: center;
        padding: 0;
        margin: 0;
      }

      .courseCol {
        align-items: center;
        margin: 0;
        padding-bottom: 0.5rem ;
      }

      /* General styles for all devices */
      .scheduleTable {
        width: 100%;
        table-layout: fixed;
      }

      /* Tablet view */
      @media only screen and (min-width: 768px) and (max-width: 1023px) {
        .timeCol {
          font-size: 0.75rem;
          padding: 0.25rem;
        }
        
        .section-button {
          font-size: 0.5rem;
        }
      }

      /* Mobile view */
      @media only screen and (max-width: 767px) {
        .timeCol {
          font-size: 0.6rem;
          padding: 0.25rem;
        }
        
        .section-button {
          font-size: 0.4rem;
        }
      }
    
    </style>
  </head>
</html>
<?php

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
            //print_r($arr);
            foreach($arr as $enrollSect){
              $checkCourse->execute(array($enrollSect['courseID']));
              //echo $enrollSect['courseID'];
              if($checkThisCourse=$checkCourse->fetch()){
                $courseC=$checkThisCourse['courseCode'];
                $courseID=$checkThisCourse['ID'];
              }
              $sID=$enrollSect['sectionID'];
              //echo $courseC;
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
                        //echo $courseC;
                        if ($startEnrollment >= $start && $endEnrollment<=$end) {
                          
                          $schedule[$dayIndex][$i][] = array(
                              'courseCode' => $courseC,
                              'sectionNumber' => $sectionNo,
                              'location' => $room,
                              'sID'=> $sID,
                              'cID'=> $courseID
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
            echo '<table class="scheduleTable table-responsive" width="700px">';
            echo '<tr class="daysRow"><th>Time</th><th>U</th><th>M</th><th>T</th><th>W</th><th>H</th></tr>';

              foreach ($timeslots as $index => $timeslot) {
                echo '<tr>';
                echo '<td class="timeCol">' . $timeslot . '</td>';
                for ($dayIndex = 0; $dayIndex < count($daysOfWeek); $dayIndex++){
                  echo '<td class="courseCol">';
                  
                  if (isset($schedule[$dayIndex][$index])){
                    foreach ($schedule[$dayIndex][$index] as $class) {
                      echo '
                      <button  class="section-button"  data-section-id='. $class['sID'].'> <h2>'.$class['courseCode'] . '</h2>SEC ' . $class['sectionNumber'] . '<br><br> ROOM ' . $class['location'] . '</button>';
                    }
                  }echo '</td>';
                }echo '</tr>';
              }
              echo '</table>';
}




function yourInstrSched($arr){

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
        //print_r($arr);
        foreach($arr as $enrollSect){
          $checkCourse->execute(array($enrollSect['courseID']));
          //echo $enrollSect['courseID'];
          if($checkThisCourse=$checkCourse->fetch()){
            $courseC=$checkThisCourse['courseCode'];
            $courseID=$checkThisCourse['ID'];
          }
          
          //echo $courseC;
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
                    //echo $courseC;
                    if ($startEnrollment >= $start && $endEnrollment<=$end) {
                      
                      $schedule[$dayIndex][$i][] = array(
                          'courseCode' => $courseC,
                          'sectionNumber' => $sectionNo,
                          'location' => $room,
                          
                          'cID'=> $courseID
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
        echo '<table class="scheduleTable table-responsive" width="700px">';
        echo '<tr class="daysRow"><th>Time</th><th>U</th><th>M</th><th>T</th><th>W</th><th>H</th></tr>';

          foreach ($timeslots as $index => $timeslot) {
            echo '<tr>';
            echo '<td class="timeCol">' . $timeslot . '</td>';
            for ($dayIndex = 0; $dayIndex < count($daysOfWeek); $dayIndex++){
              echo '<td class="courseCol">';
              
              if (isset($schedule[$dayIndex][$index])){
                foreach ($schedule[$dayIndex][$index] as $class) {
                  echo '
                  <button  class="section-button"  data-section-id=""> <h2>'.$class['courseCode'] . '</h2>SEC ' . $class['sectionNumber'] . '<br><br> ROOM ' . $class['location'] . '</button>';
                }
              }echo '</td>';
            }echo '</tr>';
          }
          echo '</table>';
}




function popup($parr){
  switch($parr){
    case 'lect':
       ?> <script>swal("Conflict detected!", "You have a lecture conflict with another section.", "error");</script><?php
       break;
    case 'final':
      ?> <script>swal("Conflict detected!", "You have a final conflict with another section.", "error");</script><?php
      break;
    case 'seat':
        ?> <script>swal("Course is full", "There are no available seats for this section. Choose another section", "error");</script> <?php
        break;
    case 'course':
          ?> <script>swal("Unable to add course", "You have reached the maximum limit of six courses. Remove a course before adding a new one.", "error");</script> <?php
          break;
    case 'added':
          ?> <script> swal("Registration was successful!", "You are now registered for this course.", "success"); </script> <?php
          break;
    case 'swap':
            ?> <script> swal("Course failed to add", "Looks like the course was not added. Check the details and try again.", "error"); </script> <?php
            break;
    case 'swapped':
            ?> <script>swal("Seats swap successful!", "Two course seats have been swapped.", "success"); </script> <?php
            break;
    case 'error':
      ?> <script> swal("Failed to swap seats", "Unable to complete the swap.", "error"); </script> <?php
      break;
  }
}



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