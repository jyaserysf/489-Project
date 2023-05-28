
<?php
session_start();
if (!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    $_SESSION['activeUser']['ID'];
}
try{

require('Database/connection.php');
{
    if(isset($_POST['sb'])){
    $section_num = $_POST['Sections'];
    //$course_Code=$_POST['Course'];

  $semesterQuery = "SELECT DISTINCT * FROM semester 
  JOIN students JOIN programs 
  ON students.studyProgram = programs.PID
   JOIN course_sections
   ON semester.ID = course_sections.semesterID JOIN courses ON course_sections.courseID = 
  courses.ID JOIN instructors ON course_sections.instructorID = instructors.ID WHERE 
  instructors.ID = " . $_SESSION['activeUser']['ID']." AND course_sections.sectionNumber = ". $section_num ." AND NOW() BETWEEN beginDate AND endDate";//." AND courses.courseCode = ". $course_Code;  
  // we need to insert data for dr taher for  this semester  
$semesterResult = $db->query($semesterQuery);
    }
//  $TheCourse= $db->prepare ("SELECT * FROM course_sections WHERE semesterID=? AND instructorID=? ORDER BY courseID");
//  $TheCourse->execute(array($semesterID, $instructorID)); 

  $Courses="SELECT DISTINCT courses.courseCode, courses.courseName  FROM `course_sections` JOIN courses ON courseID=courses.ID 
  WHERE course_sections.instructorID = ".$_SESSION['activeUser']['ID'];
  $ViewC=$db->query($Courses);

 $Sections="SELECT DISTINCT  sectionNumber FROM course_sections WHERE instructorID=".$_SESSION['activeUser']['ID'];
  $viewSec=$db->query($Sections);


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
   <link rel="stylesheet" href="css/GPAcalc.css">
    
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
                                 <?php 
                       // echo "<select name='Course' >";
                         foreach($ViewC as $Course){
                      //  $course_Code=$Course['courseCode'];
                        $course_Code= $Course['courseID'];
                         echo "<option value={$Course['courseCode']} > ". $Course['courseCode'] . "  " .$Course['courseName'] . "</option>";
                        }
                        echo "</select>";
                        ?>
                        
                           <?php
                            echo "<select name='Sections' >";
                            foreach($viewSec as $Section) {
                            $Section_number = $Section['courseID'];
                            echo "<option value= {$Section['sectionNumber']}> ". $Section['sectionNumber'] . "  " . "</option>";
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
                            <th> Student ID </th> 
                            <th > student Name </th>  
                            <th class=""> Student Grade</th> 
                        </tr>
                    </thead>
                    <tbody>
                    <tr>                 
                        
                <form method="POST" id="btn">
                             <?php if(isset($_POST['sb']))
                                {  require 'reversegardesfunc.php'; 
                                    //var_dump($semesterResult);
                                 foreach($semesterResult as $StudentsR)
                                 {    $SID=$StudentsR[8];
                                    //echo $StudentsR[8];
                                 ?>
                            
                                 <td> <?php echo $StudentsR[9] ?> </td>
                                   <td><?php echo $StudentsR[10] ?> </td>
                                   <td>
                                    <!-- sid=>grade -->
                                   <select name="grade[<?php echo $SID?>]">
                                 <?php  
                                   selectGradeM();
                                 echo" </tr>"; 
                                }?> 
                                 </select>
                                  </td>
                                   </table>
                                    </tbody>  


                    
                    <button type="submit" name="Save" value="save" id="save" >Save Section Grades</button>  

                    </form>                
                    <?php  
                }
                ?>      
                <?php 
                if (isset($_POST['Save']))
                {
                    $grades=$_POST['grade'];
                foreach($grades as $SID=>$grades)
                {
                    try{
                    require('Database/connection.php');
                        {
                    $stmt=$db->prepare("UPDATE `enrollments` SET `grade`=?  WHERE studentID=? ");
                    $stmt->execute(array($grades,$SID));
                    $db=null;
                  
                         }
                        }

        
             catch(PDOException $EXC)
             {
                   die('ERROR:'.$EXC->getMessage());
            }

                    //var_dump($_POST);
         }   

         ?>

         <script>swal("student Grades !", "student Grades has been updated!", "success");</script>
         <?php // stolean  from fatimas group  non function :reusability ?>
    


               <?php }?>
            </div>
        </div>
    </div>
</div>


<!-- Javascript file -->
<script src="js/sidenav.js"></script>
<style> 
/* #btn
{
display: flex;
justify-content: center;
padding-right: 25%;
} */
#save
{
    margin-left: auto;
    margin-right: 55%;
 display: flex;
justify-content: center;

}
table
{
    justify-content: center;
}
</style>