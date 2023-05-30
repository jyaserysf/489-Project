
<?php 
session_start();

    if(!isset($_SESSION['activeUser'])){
        header('Location: login.php');
        exit();
    }

//var_dump($_POST);

// page should only be accessed betweeen modifyStart and end (use js popup and date), i can use the semester id from modifyStart and end
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <title>Course Registration</title><link rel="stylesheet" href="css/courseReg.css">
    <script src="https://kit.fontawesome.com/8f65530edf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="generalstyling.css">
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#selectcourse').on('change',function(){
                var cID=$(this).val();
                if(cID){
                    $.ajax({
                        type:'POST',
                        url:'ajaxSections.php',
                        data:'ID='+cID,
                        success:function(html){
                            $('#selectSection').html(html);
                        }
                    });
                }else{
                    $('#selectSection').html('<option hidden disabled selected value> Select a section first </option>')

                }
            });
        });

        $(document).ready(function (){
            $(document).on('click', '.section-button', function() {
                event.preventDefault();
                var sectionId = $(this).data('section-id');
                $.ajax({
                    url: 'ajaxsectionDetails.php',
                    method: 'POST',
                    data: {sectionId: sectionId},
                    success: function(response) {
                        var sectionDetails = JSON.parse(response);
                        $('#c-info .st-info:nth-child(1) .st-info-lb:nth-child(1)').html('<label>Instructor Name: ' + sectionDetails.fullName + '</label>');
                        $('#c-info .st-info:nth-child(1) .st-info-lb:nth-child(2)').html('<label>Lecture Timing: ' + sectionDetails.startTime +' - '+sectionDetails.endTime + '</label>');
                        $('#c-info .st-info:nth-child(1) .st-info-lb:nth-child(3)').html('<label>Available Seats: ' + sectionDetails.availableSeats + '</label>');
                        $('#c-info .st-info:nth-child(1) .st-info-lb:nth-child(4)').html('<label>Pre-requisite: ' + sectionDetails.preRequisites + '</label>');
                        $('#c-info .st-info:nth-child(1) .st-info-lb:nth-child(5)').html('<label>Final Exam Date: ' + sectionDetails.finalDate + '</label>');
                        $('#c-info').show();
                        $('#selectedSectioninfo').val(sectionDetails.sectionNumber + ' | ' + sectionDetails.days + ' | ' + sectionDetails.room + ' | ' + sectionDetails.fullName + ' | '+ sectionDetails.startTime + ' | ' + sectionDetails.endTime +' | '+ sectionDetails.availableSeats+' | '+sectionDetails.ID+' | '+sectionDetails.finalDate+' | '+sectionDetails.courseCode);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        
                    }
                });
            });
        });

    </script>
    
</head>
<body>

        
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php require 'sidenav/student-sidenav.php'; ?>
        </div>
        <?php 
            # to grab logged in student ID
            try{
                require('Database/connection.php');
                //print_r( $_SESSION['activeUser']) ;
                //$keys = array_keys($_SESSION['activeUser']);
                $ID = $_SESSION['activeUser']['username'];
                //echo $ID;
                $stInfo = "SELECT students.*, programs.name, programs.year, programs.departmentID, programs.PID FROM students JOIN programs ON students.studyProgram=programs.PID where students.studentID=$ID ";
                $enrolled_sections="SELECT course_sections.*, enrollments.* from course_sections Join enrollments on course_sections.ID = enrollments.sectionID";
                $studentRec = $db->query($stInfo);
                $row=$studentRec->fetch();
                $semesterInfo="SELECT * from semester where now() BETWEEN semester.modifyStart and semester.modifyEnd";
                $semester =$db->query($semesterInfo);
                $sem=$semester->fetch();
                $sql_courses = "SELECT courses.*, course_sections.semesterID FROM courses JOIN program_courses ON courses.ID = program_courses.courseID JOIN programs ON program_courses.programID = programs.PID JOIN course_sections on course_sections.ID = courses.ID WHERE programs.PID=".$row['PID']." and course_sections.semesterID=".$sem['ID'];
                $programCourses=$db->query($sql_courses);
                $courses=$programCourses->fetch(PDO::FETCH_ASSOC);
                //$courses = array();    
                //print_r($courses);
                //echo $row['ID'];
                $prevenrolled_sectionsrec="SELECT course_sections.*, enrollments.grade, enrollments.paid, enrollments.studentID from course_sections Join enrollments on course_sections.ID = enrollments.sectionID where enrollments.studentID=".$row['ID'];
                $prevEnrolled_sections=$db->query($prevenrolled_sectionsrec);
                $passedCourses=$prevEnrolled_sections->fetch();
                //print_r($passedCourses); 
                $sql_coursesInCurrentSem="SELECT distinct c.* FROM courses c JOIN course_sections cs ON c.ID = cs.courseID JOIN semester s ON cs.semesterID = s.ID WHERE s.year=".date('Y');
                $coursesInCurrentSemrec=$db->query($sql_coursesInCurrentSem);
                $coursesCurrentSem=$coursesInCurrentSemrec->fetch(PDO::FETCH_ASSOC);
                $currentYear= date('Y');
                
            }
            catch(PDOException $e){
                die($e->getMessage());
                }
        ?>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Course Registeration</h1> 
            </div>
            <div class="" id="student-info">
            <?php  
                try{
                     if($row){
                            // need to calculate credit hours, add cgpa maybe?
                            
                        echo "<div class='upper-container'>
                            <div class=''>Student Name: ".$row['fullName']." </div>
                            <div class=''>Major: ".$row['name']."</div>
                            <div class=''>Credit Hours:".$row['creditsPassed']."</div>";
                            if ($sem){
                                $currentY=$sem['year'];
                                $nextY=$currentY + 1;
                                echo "<div class=''>Semester: ".$currentY."/".$nextY."</div>";
                                echo "</div>";
                            }
                        }
                        
                }
                catch(PDOException $e){
                    die($e->getMessage());
                }

            ?>
            </div>
            <div class="3 " id="course-section">
                <form method="post" id='form'> 
                     <div class="select-cs" id="select-container">
                      <?php
                        try{ 
                            // display courses offered to student via student program 
                            echo "<label>Course: </label>";
                            echo "<select class='select' id='selectcourse' name='selectC'>
                                <option hidden disabled selected value> Select a course </option>";
                                // display courses offered this SEM that have NOT been already enrolled
                                while ($courses=$programCourses->fetch(PDO::FETCH_ASSOC)) {
                                    $enrolled=false;
                                    
                                    $prevEnrolled_sections->execute(); 
                                    while($passedCourses=$prevEnrolled_sections->fetch(PDO::FETCH_ASSOC)){
                                            if ($courses['ID'] == $passedCourses['courseID'] ){
                                                $enrolled=true;
                                                break;
                                            }
                                       
                                    } 
                                    if (!$enrolled){
                                        echo "<option  value='".$courses['ID']."'>".$courses['courseCode']." | ".$courses['courseName']."</option>  ";
                                    } 
                                }  
                             echo "</select> 
                                </div>
                             <div class='select-cs' id='selectSection' name='selectS'>
                                 <label>Section: </label>
                             </div>
                             <input type='hidden' id='selectedSectioninfo' name='selectedSection'>
                             ";
                        }catch(PDOException $e){
                            die($e->getMessage());
                        }   
                      ?> 
                    </div>
                <div id="course-manage">
                    <div class="container" id="c-info"> 
                        <div class="st-info">  
                            <div class="st-info-lb"><label> Instructor Name: </label></div> 
                            <div class="st-info-lb"><label>Lecture Timing: </label></div>
                            <div class="st-info-lb"><label>Available Seats: </label></div>
                            <div class="st-info-lb"><label>Pre-requisite: </label></div>
                            <div class="st-info-lb"><label>Final Exam Date: </label> </div>
                        </div>
                        <div class="st-info" id="conflict">
                            <div class="st-info-lb"><label>Lecture Conflict: </label></div>
                            <div class="st-info-lb"><label>Final Conflict: </label></div>
                        </div>
                    </div>
                    <div class="container" id="course-toolb">
                        <div> <button id="addS" name="addcourse" type="submit"> <i class="fa-regular fa-plus" ></i> </button> </div>
                        <div> <a href='swapSection.php' id="switchS"> <i class="fa-solid fa-rotate" ></i>  </a> </div>
                        <div> <button id="dropS" name="dropcourse" type="submit"><i class="fa-solid fa-trash"  ></i> </button> </div>
                    </div>
                </form>
                </div>
                   
                    

            <?php 

                try{
                    
                    //print_r($enrollsectSemALL);

                    require('courseRegSQL.php');
                    require('schedule.php');
                    $db->beginTransaction();
                    // ************************* ADD COURSE ***************************

                     if(isset($_POST['addcourse'])&& isset($_POST['selectC']) && isset($_POST['selectedSection']) && !empty($_POST['selectedSection'])){
                        $selectedCour=$_POST['selectC'];
                        $selectedSecInfo=$_POST['selectedSection'];
                        $selectedSecDetails=explode(' | ',$selectedSecInfo);
                        //print_r($selectedSecDetails);
                        
                        $checkCourse->bindParam(':courID',$selectedCour);
                        $checkCourse->execute();
                        $checkThisCourse=$checkCourse->fetch();
                        //print_r($checkThisCourse);
                        $preReqs=$checkThisCourse['preRequisites'];

                        $lectureConflictsrec=$db->query("SELECT enrollments.ID, enrollments.sectionID, COUNT(*) as num FROM enrollments join course_sections on enrollments.sectionID=course_sections.ID WHERE startTime<='$selectedSecDetails[5]' AND endTime>='$selectedSecDetails[4]' AND days='$selectedSecDetails[1]' AND semesterID=".$semm['ID']." and enrollments.studentID=$stID");
                        
                        $lectureConf=$lectureConflictsrec->fetch();

                        $finalConflictrec=$db->query(" SELECT enrollments.ID, enrollments.sectionID, COUNT(*) as num FROM enrollments join course_sections on enrollments.sectionID=course_sections.ID WHERE course_sections.finalDate=$selectedSecDetails[8] AND  course_sections.semesterID=".$semm['ID']." AND enrollments.studentID=$stID");
                    
                        $finalConf=$finalConflictrec->fetch();
                        $error='error';
                        $enrolled=true;
                        $preReqC=0; 
                                // Check if enrolled sections are 6 or less, then check if there are available seats, then check for conflicts, then check prerequisites       
                                
                                if(count($enrollsectSemALL)<7){  
                                    if($selectedSecDetails[6]>=1){
                                        if( $finalConf['num'] <1 ){
                                            if($lectureConf['num']<1){
                                                while($passedCourses=$prevEnrolled_sections->fetch()){
                                                $preReq= explode(',',$preReqs);
                                                //print_r($preReq);
                                                for($i=0; $i<count($preReq); $i++){
                                                    if($passedCourses['courseCode']==$preReq[$i] && $passedCourses['grade']!=NULL){
                                                        $preReqC++;}   
                                                    }     
                                                }
                                            }else{
                                                $enrolled=false;
                                                $error='lect';
                                            }
                                        }
                                        else{
                                            $enrolled=false;
                                            $error='final';
                                            //pop up
                                            
                                        }
                                    }else{
                                        $error='seat';
                                        //pop up
                                        
                                        $enrolled=false;
                                    }
                                }else{
                                    //pop up
                                    $error='course';
                                    
                                    $enrolled=false;
                                }

                                //make sure the section is not added again
                                foreach($enrollsectSemALL as $enrollS){
                                    if($selectedSecDetails[7]==$enrollS['sectionID']){
                                        $enrolled=false;
                                    }
                                }

                                $ID = $_SESSION['activeUser']['username'];
 
                                $addSectionEnroll=$db->prepare("INSERT into enrollments ( studentID, sectionID) values ( :studentID, :sectionID) ");
                                
                                $addSectionEnroll->bindParam(':studentID', $stID);
                                $addSectionEnroll->bindParam(':sectionID', $selectedSecDetails[7]);
                                
                                

                                if($enrolled && count($preReq)==$preReqC){
                                    // insert section in enrollments and decrease available seats
                                    $addSectionEnroll->execute();
                                    $selectedSecDetails[6]=$selectedSecDetails[6]-1;
                                    
                                    $updateAvailbSeats->bindParam(':seats',$selectedSecDetails[6]);
                                    $updateAvailbSeats->bindParam(':secID',$selectedSecDetails[7]);
                                    $updateAvailbSeats->execute();
                                    //$updateAvailbSeats->execute(array($selectedSecDetails[6], $selectedSecDetails[7]));
                                    $error='added';
                                    popup($error);
                                }
                                else{
                                    
                                    popup('notadd');
                                }

                                unset($_POST);

                    }elseif(isset($_POST['addcourse'])&& isset($_POST['selectC'])){
                        //popup -> must select course section ?>

                     <script>swal("No section selected", "Please choose a course section to add and try again.", "error");</script>

                    <?php    // echo "select course section before adding";
                    }elseif(isset($_POST['addcourse'])){
                        // popup-> must select course?>
                        <script>swal("No course selected", "Please choose a course to add and try again.", "error");</script>
                     <?php   // echo "select course section before adding";
                        unset($_POST);
                    } 
                    

                    
                   
                    // ************************* DROP COURSE ***************************
                    
                    $deleteEnroll=$db->prepare("DELETE FROM enrollments WHERE sectionID=:sID and studentID=:stID");

                    // $updateAvailbSeats=$db->prepare("UPDATE course_sections set availableSeats=? where sectionID=? ");
                                
                    if(isset($_POST['dropcourse'])&&  isset($_POST['selectedSection']) && !empty($_POST['selectedSection'])){
                        
                       
                        $selectedSecInfo=$_POST['selectedSection'];
                        $selectedSecDetails=explode(' | ',$selectedSecInfo);
                        $error='error';


                        


                        if(count($enrollsectSemALL)<=3){
                            $error='lessthan3';
                            popup($error);
                            // echo "you cannot have less than 3 courses ";
                            ?> <script>//swal("Unable to proceed", "Minimum of 3 courses required.", "error");</script> <?php

                        }else{
                            $deleteEnroll->bindParam(':sID', $selectedSecDetails[7]);
                            $deleteEnroll->bindParam(':stID', $stEnrollID['ID']);
                            $deleteEnroll->execute();
                            //$deleteEnroll->execute(array($selectedSecDetails[7], $stEnrollID['ID']));
                            $selectedSecDetails[6]=$selectedSecDetails[6]+1;
                            $updateAvailbSeats->bindParam(':seats',$selectedSecDetails[6]);
                            $updateAvailbSeats->bindParam(':secID',$selectedSecDetails[7]);
                            $updateAvailbSeats->execute();
                            //$updateAvailbSeats->execute(array($selectedSecDetails[6],$selectedSecDetails[7]));
                            // echo "<h5>removed seat successfully! </h5>";
                            $error='removed';
                            popup($error);
                           
                        };

                        unset($_POST);
                    }elseif(isset($_POST['dropcourse'])){
                        // popup-> must select course
                        popup('drop');
                        
                        
                        
                        unset($_POST);
                    } 

                    
                    $db->commit();
                    $db=null;

                }catch (PDOException $e) {
                    // rollback transaction in case of errors
                    $db->rollBack();
                    die("Error: " . $e->getMessage());
                }
                
              
            ?>
                <div  id='display-sched'>
                                        <div class='container' id='sched'>
                                            <?php 
                                            //require('schedule.php');
                                            

                                            yourSched($enrollsectSemALL);

                                            ?>
                                        </div>
                </div>
                <div id='payment'>
                    <button class='submitBtn' id='pay' onclick="window.location.href='https://services.bahrain.bh/wps/portal/!ut/p/a1/jZBNj4JADIZ_iweutA6gs94qJnwaYgwR57IZEgQMAhlQ_Pkit012WXtr8zzp24KABEQtH2Uu-7KpZfXuxeqbc8deMs58DCJEovhAfkjM4cYInEfA4sx2gxGIDNNCMoPDNo5cAyP8zLcdcs11iIgmZ-jttu5u_bVH9Faf-fhH0b_7j1LBCcSEzV0xAXMxJ2Amhw8ir5p0-umZ6tTgOQiVXTKVKf2uxnHR92230VDDYRj0VBZKlrWeFhr-phRN10Pyk4T2FsfJ07ta1SMkWixeN0TjPQ!!/dl5/d5/L2dBISEvZ0FBIS9nQSEh/'" >Pay</button>
                </div>
       

            
        </div>
    </div>
    <!-- Javascript file -->
    <script src="js/sidenav.js"></script>
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const dropCourseButton = document.getElementById('dropS');
        //     const enrollmentsForm = document.getElementById('form');

        //     dropCourseButton.addEventListener('click', function(event) {
        //         event.preventDefault();

        //         swal({
        //         title: 'Are you sure?',
        //         text: "You won't be able to revert this!",
        //         icon: 'warning',
        //         buttons: true,
        //         dangerMode: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Yes, delete it!'
        //     }).then((willDelete) => {
        //         if (willDelete) {
        //         enrollmentsForm.submit();
        //         }
        //     });
        //     });
        // });


</script>
   
</body>


</html>