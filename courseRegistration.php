
<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title><link rel="stylesheet" href="css/courseReg.css">
    <script src="https://kit.fontawesome.com/8f65530edf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="generalstyling.css">
    
    
</head>
<body>
    
        <?php 
            # to grab logged in student ID
            try{
                require('Database/connection.php');
                //print_r( $_SESSION['activeUser']) ;
                $keys = array_keys($_SESSION['activeUser']);
                $ID = $keys[0];
                $stInfo = "SELECT students.*, programs.name, programs.year, programs.departmentID, programs.PID FROM students JOIN programs ON students.studyProgram=programs.PID where students.studentID=$ID ";
                $semesterInfo="SELECT* from semester";
                $enrolled_sections="SELECT course_sections.*, enrollments.* from course_sections Join enrollments on course_sections.ID = enrollments.sectionID";
                $studentRec = $db->query($stInfo);
                $semester =$db->query($semesterInfo);
                $row=$studentRec->fetch();
                $sql_courses = "SELECT courses.* FROM courses JOIN program_courses ON courses.ID = program_courses.courseID JOIN programs ON program_courses.programID = programs.PID WHERE programs.PID=".$row['PID'];
                $programCourses=$db->query($sql_courses);
                $courses=$programCourses->fetch();
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
                        echo "<div class=''>Student Name: ".$row['fullName']." </div>
                            <div class=''>Major: ".$row['name']."</div>
                            <div class=''>Credit Hours:".$row['creditsPassed']."</div>";
                            if ($sem=$semester->fetch()){
                                echo "<div class=''>Semester: ".$sem['year']."</div>";
                            }
                        }
                        
                }
                catch(PDOException $e){
                    die($e->getMessage());
                }
        
            ?>
            </div>
            <div class="3 " id="course-section">
                 <form action="" method="post">
                     <div class="select-cs">
                      
                      <?php
                        try{
                            // display courses offered to student via student program 
                            echo "<label>Course: </label>";
                            echo "<select class='select' id='selectcourse'>
                                <option hidden disabled selected value> Select a course </option>";
                                if($courses){
                                    echo 
                                    "<option value='".$courses['ID']."'>".$courses['courseCode']." | ".$courses['courseName']."</option>
                                    ";
                                }
                                // not sure why i wanted this, i wanted the sudents department
                                // $stDepartment= "SELECT* from departments where ID=".$row['departmentID'];
                                // $departmentrec = $db->query($stDepartment);
                                // print_r($departmentrec);
                                // if($dep=$departmentrec->fetch()){
                                //     $depName=$dep['name'];
                                //     echo $depName;
                                // }
                            
                             echo "</select> ";
                        }catch(PDOException $e){
                            die($e->getMessage());
                        }
                        
                      ?>
                      
                     </div>
                     <!-- <label for="selectcourse">Select Course</label> aria-label="Floating label select example"</div> -->
                     <div class="select-cs">
                         <label>Section: </label> 
                         <button type="submit" name="option" value="option1"> 01 | UTH</button>
                         <button type="submit" name="option" value="option2">02 | UTH</button>
                         <button type="submit" name="option" value="option3">3 | MW</button>
                     </div>
                 </form>
             </div>
            <div id="course-manage">
                <div class="course-info" id="c-info"> 
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
                <div class="course-info" id="course-toolb">
                    <div> <button name="addcourse" ><i class="fa-regular fa-plus" style="color: rgba(0, 0, 0, 0.7);"></i> </button> </div>
                    <div> <button name="switchsection" ><i class="fa-solid fa-rotate" style="color: rgba(0, 0, 0, 0.7);"></i> </button> </div>
                    <div> <button name="dropcourse" ><i class="fa-solid fa-trash"  style="color: rgba(0, 0, 0, 0.7);"></i> </button> </div>
                </div>
            </div>
            <div class="display-sched">
                <div class="sched">
                    <?php 
                    require('schedule.php');
                    schedule();?>
                </div>
                <div class="sched-toolb">
                <div> <button name="export" > <i class="fa-solid fa-download"style="color: rgba(0, 0, 0, 0.7);"></i> </button> </div>
                <div> <button name="print" > <i class="fa-solid fa-print"style="color: rgba(0, 0, 0, 0.7);"></i>  </button> </div>
                </div>
            </div>
       

            
        </div>
    </div>
    <!-- Javascript file -->
    <script src="js/sidenav.js"></script>
</body>


</html>