<?php 
session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
}

    var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Registeration</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="generalstyling.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.php'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h2>Swap Section</h2> 
            </div>
            <?php 

            require('courseRegSQL.php');
            
            $switchSectionEnroll=$db->prepare("UPDATE  enrollments set sectionID=? where ID=? ");
                    $sql_coursesSec = "SELECT courses.*, course_sections.* FROM courses JOIN program_courses ON courses.ID = program_courses.courseID JOIN programs ON program_courses.programID = programs.PID JOIN course_sections on course_sections.ID = courses.ID WHERE programs.PID=".$row['PID']." and course_sections.semesterID=".$semm['ID'];
                    $programCoursesSec=$db->query($sql_coursesSec);

                    $sectionInf=$db->prepare("SELECT course_sections.*, courses.preRequisites, courses.courseCode FROM course_sections join courses on course_sections.courseID=courses.ID where course_sections.ID=?");
                
                    

                       
                        echo "
                            <div class='container' id='popup'>
                            
                            ";
                                    // $selectedSecInfo=$_POST['selectedSection'];
                                    // $selectedSecDetails=explode(' | ',$selectedSecInfo);

                                echo" 
                                <form method='post'> 
                                <div> <label>Section: </label>
                                
                                   <select name='selectSwC'>";

                                    foreach($enrollsectSemALL as $section){
                                        $sectionInf->execute(array($section['sectionID']));
                                        $currSec=$sectionInf->fetch();
                                        echo"   <option selected value=".$section['sectionID']."> ".$currSec['courseCode']." | ".$section['sectionNumber']." </option>";
                                    }
                                    
                            echo"   </select> 
                                </div>
                                <div> <label>Section To Swap: </label>
                                <select name='selectToSwC'>
                                <option hidden disabled selected value> Select a course and section </option>";
                                while ($courses=$programCoursesSec->fetch(PDO::FETCH_ASSOC)) {
                                    $enrolled=false;
                                    $prevEnrolled_sections->execute(); 
                                    while($passedCourses=$prevEnrolled_sections->fetch(PDO::FETCH_ASSOC)){
                                            if ($courses['ID'] == $passedCourses['courseID'] ){
                                                
                                                // get section number from course id for this SEMESTER
                                                $enrolled=true;
                                                break;
                                            }
                                    } 
                                    if (!$enrolled){
                                        $sql_currentSections="SELECT course_sections.ID, course_sections.sectionNumber, courses.courseCode FROM course_sections join courses on course_sections.courseID=courses.ID WHERE courseID=".$courses['ID']." and semesterID=".$semm['ID'];
                                        $currentSectionsrec=$db->query($sql_currentSections);
                                        $currentSections=$currentSectionsrec->fetch(PDO::FETCH_ASSOC);
                                        if($currentSections){
                                            echo "<option  value='".$currentSections['ID']."'>".$currentSections['courseCode']." | ".$currentSections['sectionNumber']."</option>  ";
                                        echo $currentSections['ID'];}
                                        
                                    } 
                                }  
                                echo"</select>
                                </div>
                                <div>
                                <a href='courseRegistration.php'> <button id='close-popup'>Back</button></a> 
                                <button type='submit' id='sW' name='swapSections'>Swap</button>
                                </div>
                            </form>
                            </div>";
                        
                                ?> 
                                <script> var back=document.getElementById('close-popup');
                                        back.addEventListener('click', function(){
                                            event.preventDefault();
                                            window.location.href = "courseRegistration.php";
                                        });
                                </script>
                                <?php
                            if(isset($_POST['selectSwC']) && isset($_POST['selectToSwC']) ){
                                $oldSID=$_POST['selectSwC'];
                                $newSID=$_POST['selectToSwC'];
                                
                                
                                $enrollID=$db->prepare("SELECT ID from enrollments where sectionID=? and studentID=?");
                                $enrollID->execute(array($oldSID, $stID));
                                $eID=$enrollID->fetch();

                                $sectionInf->execute(array($newSID));
                                $newSect=$sectionInf->fetch();
                                
                                $preReqs=$newSect['preRequisites'];
                                $lectureAtSTimerec=$db->query("SELECT enrollments.ID, enrollments.sectionID, 
                                COUNT(*) as num FROM enrollments join course_sections on enrollments.sectionID=course_sections.ID 
                                WHERE startTime='".$newSect['startTime']."' AND endTime='".$newSect['endTime']."' 
                                AND days='".$newSect['days']."' AND semesterID=".$semm['ID']." and enrollments.studentID=$stID");

                                $lectureSTime=$lectureAtSTimerec->fetch();

                                $lectureConflictsrec=$db->query("SELECT enrollments.ID, enrollments.sectionID, COUNT(*) as num FROM enrollments join course_sections on enrollments.sectionID=course_sections.ID WHERE startTime<='".$newSect['startTime']."' AND endTime>='".$newSect['endTime']."' AND days='".$newSect['days']."' AND semesterID=".$semm['ID']." and enrollments.studentID=$stID");
                        
                                $lectureConf=$lectureConflictsrec->fetch();

                                $finalConflictrec=$db->query(" SELECT enrollments.ID, enrollments.sectionID, COUNT(*) as num FROM enrollments join course_sections on enrollments.sectionID=course_sections.ID WHERE course_sections.finalDate=".$newSect['finalDate']." AND  course_sections.semesterID=".$semm['ID']." AND enrollments.studentID=$stID");
                            
                                $finalConf=$finalConflictrec->fetch();
                                $check=true;
                                $preReqC=0;
                                $preReq= explode(',',$preReqs);
                                //print_r($preReq);
                                //check for seats, preReqs and conflicts again 
                                    if($newSect['availableSeats']>=1){
                                        if( $finalConf['num'] <1 || $lectureSTime['num']!=1){
                                            if($lectureConf['num']<1){
                                                while($passedCourses=$prevEnrolled_sections->fetch()){
                                                for($i=0; $i<count($preReq); $i++){
                                                    if($passedCourses['courseCode']==$preReq[$i]){
                                                        $preReqC++;
                                                        }   
                                                    }     
                                                }
                                            }else{
                                                $check=false;
                                            }
                                            
                                        }
                                        else{

                                            $check=false;
                                            //pop up?>
                                            <script>swal("Conflict detected!", "You have a conflict with another section.", "error");</script>
                                            <?php // echo 'conflict error';
                                            
                                        }
                                    }else{
                                        // echo 'no seats';
                                        //pop up
                                        ?>
                                        <script>swal("Course is full", "There are no available seats for this section. Choose another section.", "error");</script>
                                        <?php
                                        $check=false;
                                    }
                                    //echo $preReqC;
                                    //echo $check;

                                    foreach($enrollsectSemALL as $enrollS){
                                        if($newSect['ID']==$enrollS['sectionID']){
                                            $enrolled=false;
                                        }
                                    }

                                    if($check && count($preReq)>=$preReqC){
                                    
                                        $switchSectionEnroll->execute(array($newSID, $eID['ID']));
                                        $newSect['availableSeats']=$newSect['availableSeats']-1; 
                                        $updateAvailbSeats->bindParam(':seats',$newSect['availableSeats']);
                                        $updateAvailbSeats->bindParam(':secID',$newSID);
                                        $updateAvailbSeats->execute();

                                        //$updateAvailbSeats->execute(array($newSect['availableSeats'], $newSID));
                                        $sectionInf->execute(array($oldSID));
                                        $oldSect=$sectionInf->fetch();
                                        $oldSect['availableSeats']=$oldSect['availableSeats']+1;
                                       
                                        $updateAvailbSeats->bindParam(':seats',$oldSect['availableSeats']);
                                        $updateAvailbSeats->bindParam(':secID',$oldSID);
                                        $updateAvailbSeats->execute();
                                        //$updateAvailbSeats->execute(array($oldSect['availableSeats'],$oldSID));
                                        ?>
                                        <script>swal("Seats swap successful!", "Two course seats have been swapped.", "success");</script>
                                        <?php
                                        // echo "<h5>switched seat successfully! </h5>";
                                        unset($_GET);
                                    }
                                    else{
                                        ?>
                                        <script>swal("Failed to swap seats", "Unable to complete the swap.", "error");</script>
                                        <?php
                                            //echo "<h5>course has not been switched </h5>";
                                         unset($_GET);
                                    }
                                

                            }elseif(empty($_GET['selectSwC']) || empty($_GET['selectToSwC'])){
                                echo "<h5> select a section to switch with </h5>";
                               
                            }
                       
                        //echo "<h5>switched seat successfully! </h5>";
                        
                        unset($_POST);
            ?>
            <div  id='display-sched'>
                <div class='container' id='sched'>
                    <?php 
                    require('schedule.php');
                    yourSched($enrollsectSemALL);?>
         </div>
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>
</html>