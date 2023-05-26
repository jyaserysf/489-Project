
<?php 
session_start();

    if(!isset($_SESSION['activeUser'])){
        header('Location: login.php');
        exit();
    }

var_dump($_POST);
//print_r( $_SESSION['activeUser']) ;
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

        // document.getElementById("addS").addEventListener("click", function() {
        //     var xhttp = new XMLHttpRequest();
        //     xhttp.onreadystatechange = function() {
        //       if (this.readyState == 4 && this.status == 200) {
        //         // response from PHP function
        //         console.log(this.responseText);
        //       }
        //     };
        //     xhttp.open("POST", "schedule.php?function=addS", true);
        //     xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        //     xhttp.send("addcourse=true&selectC=" + encodeURIComponent(document.getElementById("selectcourse").value) + "&selectS=" + encodeURIComponent(document.getElementById("selectSection").value));
        // });

        // Attach a click event listener to the button that opens the pop up
        
        
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
                $semesterInfo="SELECT* from semester";
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
                        echo "<div class=''>Student Name: ".$row['fullName']." </div>
                            <div class=''>Major: ".$row['name']."</div>
                            <div class=''>Credit Hours:".$row['creditsPassed']."</div>";
                            if ($sem){
                                $currentY=$sem['year'];
                                $nextY=$currentY + 1;
                                echo "<div class=''>Semester: ".$currentY."/".$nextY."</div>";
                            }
                        }
                        
                }
                catch(PDOException $e){
                    die($e->getMessage());
                }

            ?>
            </div>
            <div class="3 " id="course-section">
                <form method="post" > 
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
                                    //echo " courses: ".$courses['ID'];
                                    $prevEnrolled_sections->execute(); 
                                    while($passedCourses=$prevEnrolled_sections->fetch(PDO::FETCH_ASSOC)){
                                            if ($courses['ID'] == $passedCourses['courseID'] ){
                                                $enrolled=true;
                                                break;
                                            }
                                        //echo $passedCourses['courseID'];
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
                            <div class="st-info-lb"><label> Instructor Name:</label></div> 
                            <div class="st-info-lb"><label>Lecture Timing: </label></div>
                            <div class="st-info-lb"><label>Available Seats: </label></div>
                            <div class="st-info-lb"><label>Pre-requisite: </label></div>
                            <div class="st-info-lb"><label>Final Exam Date: </label> </div>
                        </div>
                        <div class="st-info" id="conflict">
                            <div class="st-info-lb"><label>Lecture Conflict: </label></div>
                            <div class="st-info-lb"><label>Final Conflict:</label></div>
                        </div>
                    </div>
                    <div class="container" id="course-toolb">
                        <div> <button id="addS" name="addcourse" type="submit"> <i class="fa-regular fa-plus" ></i> </button> </div>
                        <div> <button id="switchS" name="switchsection" ><i class="fa-solid fa-rotate" ></i> </button> </div>
                        <div> <button id="dropS" name="dropcourse" type="submit"><i class="fa-solid fa-trash"  ></i> </button> </div>
                    </div>
                </form>
                </div>
                   
                    

            <?php 

                try{
                    $stID=$_SESSION['activeUser']['ID'];
                    $ID = $_SESSION['activeUser']['username'];
                    $db->beginTransaction();
                    $currentTime=date('Y-m-d');
                    $semesterInfo="SELECT* from semester where now() BETWEEN semester.modifyStart and semester.modifyEnd";
                    $semester =$db->query($semesterInfo);
                    $semm=$semester->fetch();

                    $stInfo = "SELECT students.*, programs.name, programs.year, programs.departmentID, programs.PID FROM students JOIN programs ON students.studyProgram=programs.PID where students.studentID=$ID ";
                    $studentRec = $db->query($stInfo);
                    $row=$studentRec->fetch();

                    $prevenrolled_sectionsrec="SELECT course_sections.*, enrollments.grade, enrollments.paid, enrollments.studentID, courses.courseCode from course_sections Join enrollments on course_sections.ID = enrollments.sectionID join courses on courses.ID=course_sections.courseID where enrollments.studentID=".$row['ID'];
                    $prevEnrolled_sections=$db->query($prevenrolled_sectionsrec);
                    $passedCourses=$prevEnrolled_sections->fetch();

                    $sql_stEnrollID="SELECT students.ID from students where studentID=$ID";
                                $stEnrollIDrec=$db->query($sql_stEnrollID);
                                $stEnrollID=$stEnrollIDrec->fetch();

                    $enrolledSectionsthisSem=$db->prepare("SELECT enrollments.* , course_sections.*, semester.* from enrollments join course_sections on enrollments.sectionID=course_sections.ID join semester on course_sections.semesterID=semester.ID where semester.ID=:sID and enrollments.studentID=:stID");
                    $enrolledSectionsthisSem->bindParam(':sID', $semm['ID']);
                    $enrolledSectionsthisSem->bindParam(':stID', $stID);
                    $enrolledSectionsthisSem->execute();
                    $enrollSectSem=$enrolledSectionsthisSem->fetch();
                    $enrollsectSemALL=$enrolledSectionsthisSem->fetchAll();
                    $checkCourse=$db->prepare("SELECT * FROM courses where ID=:courID");
                    

                    // ************************* ADD COURSE ***************************

                     if(isset($_POST['addcourse'])&& isset($_POST['selectC']) && isset($_POST['selectedSection'])){
                        $selectedCour=$_POST['selectC'];
                        $selectedSecInfo=$_POST['selectedSection'];
                        $selectedSecDetails=explode(' | ',$selectedSecInfo);
                        //print_r($selectedSecDetails);
                        
                        $checkCourse->bindParam(':courID',$selectedCour);
                        $checkCourse->execute();
                        $checkThisCourse=$checkCourse->fetch();
                        //print_r($checkThisCourse);
                        $preReqs=$checkThisCourse['preRequisites'];

                        $sql_lectureConflicts = "SELECT enrollments.ID, enrollments.sectionID, COUNT(*) as num FROM enrollments join course_sections on enrollments.sectionID=course_sections.ID WHERE startTime<= '".$selectedSecDetails[5]."' AND endTime>='" . $selectedSecDetails[4] ."' AND days='". $selectedSecDetails[1]."' AND  semesterID=".$sem['ID']." and enrollments.studentID=".$stEnrollID['ID'];
                        $lectureConflictsrec = $db->query($sql_lectureConflicts);
                        $lectureConf=$lectureConflictsrec->fetch()['num'];

                        $sql_finalConflict=" SELECT enrollments.ID, enrollments.sectionID, COUNT(*) as num FROM enrollments join course_sections on enrollments.sectionID=course_sections.ID WHERE finalDate=".$selectedSecDetails[8]." AND  semesterID=".$sem['ID']." AND enrollments.studentID=".$stEnrollID['ID'];
                        $finalConflictrec=$db->query($sql_finalConflict);
                        $finalConf=$finalConflictrec->fetch()['num'];
                        
                        $enrolled=true;
                        $preReqC=0; 
                                // Check if enrolled sections are 6 or less, then check if there are available seats, then check for conflicts, then check prerequisites       
                                
                                if(count($enrollsectSemALL)<7){  
                                    if($selectedSecDetails[6]>=1){
                                        if( $finalConf <1 || $lectureConf<1){
                                            while($passedCourses=$prevEnrolled_sections->fetch()){
                                                $preReq= explode(',',$preReqs);
                                                //print_r($preReq);
                                                for($i=0; $i<count($preReq); $i++){
                                                    if($passedCourses['courseCode']==$preReq[$i]){
                                                        $preReqC++;}   
                                                }     
                                            }
                                        }
                                        else{
                                            //pop up
                                            $enrolled=false;
                                        }
                                    }else{
                                        //pop up
                                        $enrolled=false;
                                    }
                                }else{
                                    //pop up
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
                                $updateAvailbSeats=$db->prepare("UPDATE course_sections set availableSeats=:seats where sectionID=:sectionID ");
                                $updateAvailbSeats->bindParam(':sectionID',$selectedSecDetails[7]);

                                if($enrolled && count($preReq)==$preReqC){
                                    
                                    $addSectionEnroll->execute();
                                    $selectedSecDetails[6]=$selectedSecDetails[6]--;
                                    
                                    $updateAvailbSeats->bindParam(':seats',$selectedSecDetails[6]);
                                    $updateAvailbSeats->execute();
                                    echo "<h5>added seat successfully! </h5>
                                    ";
                                }
                                else{
                                    echo "<h5>course has not been added </h5>
                                     ";
                                }


                    }elseif(isset($_POST['addcourse'])&& isset($_POST['selectC'])){
                        //popup -> must select course section
                        echo "select course section before adding";
                    }elseif(isset($_POST['addcourse'])){
                        // popup-> must select course
                        echo "select course section before adding";
                    } 
                    

                    // ************************* SWITCH COURSE ***************************
                    $switchSectionEnroll=$db->prepare("UPDATE  enrollments set sectionID=? where ID=? ");
                    $sql_coursesSec = "SELECT courses.*, course_sections.* FROM courses JOIN program_courses ON courses.ID = program_courses.courseID JOIN programs ON program_courses.programID = programs.PID JOIN course_sections on course_sections.ID = courses.ID WHERE programs.PID=".$row['PID']." and course_sections.semesterID=".$semm['ID'];
                    $programCoursesSec=$db->query($sql_coursesSec);
                
                    if(isset($_POST['switchsection']) && isset($_POST['selectedSection'])){
                        
                        $selectedSecInfo=$_POST['selectedSection'];
                        $selectedSecDetails=explode(' | ',$selectedSecInfo);
                        echo "
                            <div class='container' id='popup'>
                                <div> <label>Section: </label>
                                    <select name='selectSwC'>
                                    <option selected value=".$selectedSecDetails[7]."> ".$selectedSecDetails[9]." | ".$selectedSecDetails[0]." </option>";
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
                                                $enrolled=true;
                                                break;
                                            }
                                    } 
                                    if (!$enrolled){
                                        echo "<option  value='".$courses['ID']."'>".$courses['courseCode']." | ".$courses['sectionNumber']."</option>  ";
                                    } 
                                }  
                                

                                echo"</select>
                                </div>
                                <div><button id='close-popup'>Cancel</button> <div id='swap'>Swap</div>
                                </div>
                        
                            </div>";
                       
                        //echo "<h5>switched seat successfully! </h5>";
                        

                    
                    }elseif(!isset($_POST['selectedSection'])){
                        // popup-> must select course
                        echo "select course before ";
                    } 
                   
                    // ************************* DROP COURSE ***************************
                    // this needs changing
                    $deleteEnroll=$db->prepare("DELETE FROM `enrollments` WHERE `sectionID`=?");
                    $updateAvailbSeats=$db->prepare("UPDATE course_sections set availableSeats=:seats where sectionID=:sectionID ");
                                
                    if(isset($_POST['dropcourse'])&&  isset($_POST['selectedSection'])){
                        
                       
                        $selectedSecInfo=$_POST['selectedSection'];
                        $selectedSecDetails=explode(' | ',$selectedSecInfo);
                        
                        if(count($enrollsectSemALL)<=3){
                            echo "you cannot have less than 3 courses ";

                        }else{
                            $deleteEnroll->execute(array($selectedSecDetails[7]));
                            $selectedSecDetails[6]=$selectedSecDetails[6]-1;
                            $updateAvailbSeats->execute(array($selectedSecDetails[6],$selectedSecDetails[7]));
                            echo "<h5>removed seat successfully! </h5>";
                        };
                        
                    }elseif(isset($_POST['dropcourse'])){
                        // popup-> must select course
                        echo "select course before dropiing";
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
                                            require('schedule.php');
                                            

                                            yourSched($enrollsectSemALL);

                                            ?>
                                        </div>
                <div class="container" id="sched-toolb">
                <div> <button name="export" > <i class="fa-solid fa-download"></i> </button> </div>
                <div> <button name="print" > <i class="fa-solid fa-print"></i>  </button> </div>
                </div>
            </div>
       

            
        </div>
    </div>
    <!-- Javascript file -->
    <script src="js/sidenav.js"></script>
    <script>


        // Get references to the button and pop up elements
        var openButton = document.getElementById('switchS');
        var popup = document.getElementById('popup');
        var closeButton = document.getElementById('close-popup');

        // Add an event listener to the open button to show the pop up
        openButton.addEventListener('click', function() {
            //event.preventDefault();
            popup.style.display = 'block';
        });

        // Add an event listener to the close button to hide the pop up
        closeButton.addEventListener('click', function() {
        popup.style.display = 'none';
        });



    </script>
</body>


</html>