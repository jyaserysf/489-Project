
<?php 
session_start();
//session_unset();
//var_dump($_POST);
//print_r( $_SESSION['activeUser']) ;
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
                        $('#selectedSectioninfo').val(sectionDetails.sectionNumber + ' | ' + sectionDetails.days + ' | ' + sectionDetails.room + ' | ' + sectionDetails.fullName + ' | '+ sectionDetails.startTime + ' - ' + sectionDetails.endTime);
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
        
    </script>
    
</head>
<body>
    
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
                $sql_courses = "SELECT courses.* FROM courses JOIN program_courses ON courses.ID = program_courses.courseID JOIN programs ON program_courses.programID = programs.PID WHERE programs.PID=".$row['PID'];
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
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.html'; ?>
        </div>
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
                        <div> <button id="switchS" name="switchsection" type="submit" ><i class="fa-solid fa-rotate" ></i> </button> </div>
                        <div> <button id="dropS" name="dropcourse" type="submit"><i class="fa-solid fa-trash"  ></i> </button> </div>
                    </div>
                </form>
                </div>
            <?php 
                
               if(isset($_POST['addcourse'])&& isset($_POST['selectC']) && isset($_POST['selectedSection'])){
                echo "<h5>added seat successfully! </h5>";
              }elseif(isset($_POST['addcourse'])&& isset($_POST['selectC'])){
                  //popup -> must select course section
                  echo "select course section before adding";
              }elseif(isset($_POST['addcourse'])){
                  // popup-> must select course
                  echo "select course before adding";
              } 
            ?>
            <div  id="display-sched">
                <div class="container" id="sched">
                    <?php 
                    require('schedule.php');
                    schedule();?>
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
</body>


</html>