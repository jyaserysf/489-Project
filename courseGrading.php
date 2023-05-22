<?php
session_start();
if (!isset($_SESSION['activeUser'])){
    die ("Please login first <a href='Login.php'>Login</a>");
}
try{
    
require('Database/connection.php');
{
$Courses="SELECT DISTINCT courses.courseCode FROM `course_sections` JOIN courses ON courseID=courses.ID WHERE course_sections.instructorID = ".$_SESSION['activeUser']['ID'];
$ViewC=$db->query($Courses);

$Sections="SELECT DISTINCT sectionNumber FROM `course_sections` where ".$_SESSION['activeUser']['ID'];
$viewSec=$db->query($Sections);
$db=null;
 

}

///-------------------- IGNORE------------------------------------------------------------------
//$query="SELECT DISTINCT courses.courseCode, semester.ID,course_sections.courseID, courses.courseName,
//instructors.ID ,instructors.fullName, course_sections.sectionNumber FROM course_sections JOIN 
//courses on course_sections.courseID=courses.ID JOIN instructors 
//ON course_sections.instructorID=instructors.ID join semester on
 //course_sections.semesterID=semester.ID";
//$CCode=$db->prepare($query);
//$CCode->execute();
//$CourseCode=$CCode->fetchAll();
// to find students from sec 
// get the sec ID from course section . and connect it 
//course ID AND the Semster ID 
//only the input for sec ID and from the sec id we get the student id from the enrollement table 
// using the student id we get the student name and ID from student Table 
// to get the student name 
//-----------------------------------------------------------------
//SELECT DISTINCT  students.ID ,students.fullName,
// course_sections.ID ,courseID ,semesterID, courses.courseCode
// FROM `course_sections` JOIN courses JOIN semester JOIN students where NOW()
// BETWEEN semester.beginDate and semester.endDate;
//
//$StudentName_ID="SELECT  studentID, fullName FROM `students`;";
//$SNID=$db->prepare($StudentName_ID);
//$SNID->execute();
//$SNI_D=$SNID->fetchAll();



}
catch(PDOException $EXC)
{
    
die('ERROR:'.$EXC->getMessage());
}

?>
<script>
    $(document).ready(function(){
$('#courses').change(function(){
   var CourseName_code= $('#courses').val();
$.ajax({
url:'ajaxinstructor.php',
method:'POST',
data:'CourseName_code'+courseID,
}).DONE(function(Sections){
console.log(Sections);
})
})
    })




</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Grading</title>
    <link rel="stylesheet" href="generalstyling.css">
    <link rel="stylesheet" href="courseGrading.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/instr-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h2>Course Grading</h2> 
            </div>
            
            <div class="grading lg-px-5 lg-py-4">
            <div class="grading lg-px-5 lg-py-4">
            <form method="Post">
                <div class="row row-col-2 ">
                    <div class="col">
                        <div class="row ms-1">
                            <select class="form-select border-secondary-subtle w-75 me-1" aria-label="Default select example" id="courses">
                          <?php  foreach($ViewC as $Course) 
                          {
                                // Get the ID of the selected semester
                            $courseID = $Course['ID'];
                            echo "<option value='$courseID'> ". $Course['courseCode'] . "  " . $Course['courseName'] . "</option>";
                            }
                            echo "</select>";
                        ?>
                           <?php
                            echo "<select>";
                            foreach($viewSec as $Section) {
                                
                            $Section_number = $Section['courseID'];
                            echo "<option value='$Section'> ". $Section['sectionNumber'] . "  " . "</option>";
                            }
                            echo "</select>";
                            ?>
                                    <button type="submit" name="sb" value="">view students </button>
                        </div>
                    </div>
                    <div class="col-lg-4 offset-1">
                        Semester: 
                    </div>
                </div>
            </form>

            <div class="student-list lg-mx-4 my-4" style="background-color: #FDF7CF" style="width:85%">
                <table class="table table-borderless">
                    <thead>
                        <tr> 
                            <th style="width: 8%"> ID </th> 
                            <th style="width: 15%"> Name </th>  
                            <th class="">Grade</th> 
                        </tr>
                    </thead>
                    <tbody>
                       
                                </td>  
                            </tr> 
                            <br>
                    
                    </tbody>
                </table>
                <button type="submit" name="sb" value="">Save Section Grades</button>
            </div>
        
        </div>
    </div>
</div>
<!-- Javascript file -->
<script src="js/sidenav.js"></script>