
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
?>