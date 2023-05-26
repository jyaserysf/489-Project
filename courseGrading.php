
<?php
session_start();
if (!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    $_SESSION['activeUser']['ID'];
}
try{
    
require('Database/connection.php');
{


//  $TheCourse= $db->prepare ("SELECT * FROM course_sections WHERE semesterID=? AND instructorID=? ORDER BY courseID");
//  $TheCourse->execute(array($semesterID, $instructorID)); 

  $Courses="SELECT DISTINCT courses.courseCode, courses.courseName  FROM `course_sections` JOIN courses ON courseID=courses.ID WHERE course_sections.instructorID = ".$_SESSION['activeUser']['ID'];
  $ViewC=$db->query($Courses);
 $Sections="SELECT Distinct  sectionNumber FROM course_sections WHERE instructorID=".$_SESSION['activeUser']['ID'];
  $viewSec=$db->query($Sections);

$SQLfull="SELECT* FROM semester JOIN students JOIN programs on students.studyProgram = programs.PID JOIN course_sections
 JOIN courses on courses.ID=course_sections.courseID JOIN instructors ON instructors.ID=course_sections.instructorID WHERE NOW() 
 BETWEEN beginDate AND endDate and instructors.ID=".$_SESSION['activeUser']['ID'];
 $SQLfull=$db->query($full);
 $row=$SQLfull->fetch($SQLfull);
$db=null;
}

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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Grading</title>
    <link rel="stylesheet" href="generalstyling.css">
    <link rel="stylesheet" href="courseGrading.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/instr-sidenav.php'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h2>Course Grading</h2> 
            </div>
            
            <div class="grading lg-px-5 lg-py-4">
            <div class="grading lg-px-5 lg-py-4">
            <form method="POST">
                <div class="row row-col-2 ">
                    <div class="col">
                        <div class="row ms-1">
                            <select class="form-select border-secondary-subtle w-75 me-1" aria-label="Default select example" id="courses">
                          <?php  foreach($ViewC as $Course) 
                          {
                            $courseID = $Course['ID'];
                            echo "<option value='$courseID'> ". $Course['courseCode'] . "  " .$Course['courseName'] . "</option>";
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
                                    <button type="submit" name="sb" value="sb">view students </button>
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
                            <?php 
                             if(isset($_POST['sb']))
                        { 
                            foreach($viewS as $viewStudent){
                                echo $viewStudent[1].$viewStudent[2]."<br>";
                            }
                          //  $SelectedCourse=$_POST[ $Course['courseCode']];
                          //  $SelectedSection=$_POST[$Section['sectionNumber']];
                            //var_dump();
                        
                      

                        //foreach($viewS as $display){
                               // echo"<li> ".$display[1]. $display[2] ."</li>";
                           // }
                       
                              }?>
                    </thead>
                    <tbody>
                       
                                </td>  
                            </tr> 
                            <br>
                    
                    </tbody>
                </table>
                <form method="POST">


                <button type="submit" name="Save" value="">Save Section Grades</button>
                </form>


                <?php 
                if (isset( $_POST['Save']))
                {?>

                    <script>swal("student Grades !", "student Grades has been updated!", "success");</script>



               <?php }?>
            </div>
        </div>
    </div>
</div>

<!-- Javascript file -->
<script src="js/sidenav.js"></script>