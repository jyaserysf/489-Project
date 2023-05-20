
<?php 

// can be used for student and instructor
// match $days value to course days (split days into single characters)
// should add parameters to get specific user data or create another function then call it in this one
function schedule(){ 
    $days=['1'=>'U', '2'=>'M', '3'=>'T','4'=>'W','5'=>'H'];
    echo '<table>'; 
    for($i=0; $i<10; $i++){
     echo '<tr>';
        foreach($days as $header){
            if ($i==0)
                echo '<th>'.$header.'</th>'; //day header
            else{
                // if statement to add course (if course day from db match $header add to sched)
                echo '<td> data </td>'; // courses
            }
        }
     echo'</tr>';
     }
     echo '</table>';
}

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