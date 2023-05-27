
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
   ON semester.ID = course_sections.semesterID JOIN enrollments ON students.ID=enrollments.studentID JOIN courses ON course_sections.courseID = 
  courses.ID JOIN instructors ON course_sections.instructorID = instructors.ID WHERE 
  instructors.ID = ". $_SESSION['activeUser']['ID']." AND course_sections.sectionNumber = ". $section_num ;//." AND courses.courseCode = ". $course_Code;
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
    <title>Attendance </title>
    <link rel="stylesheet" href="generalstyling.css">
    <link rel="stylesheet" href="css/Attendance_instractor.css">
    

</head>

<body>

<div class="wrapper">
    <div class="sidebar-wrapper">
            <?php include 'sidenav/instr-sidenav.php'; ?>
        </div>

    <!-- Page content -->

    <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Student Attendance</h1> 
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
                   
                </form> 
                <table>
                    <thead>
                        <tr>
                            <th class="name-col">Student Name</th>
                            <th>Student ID </th>
                            <th>absent </th>
                            <th> absent number </th>
                            <th>absent Percentage </th>

                        </tr>
                    </thead> 
                             
                    <form method="POST" id="btn">
                                
                            <tbody>
                             <?php if(isset($_POST['sb']))
                                {   //echo"meoww";
                                    //var_dump($semesterResult);    
                                 foreach($semesterResult as $StudentsR)
                                 {    $SID=$StudentsR[8];
                                    $Abnum=$StudentsR['absence'];
                                 ?>
                                     <tr>
                                     <td> <?php echo $StudentsR[9] ?> </td>
                                   <td><?php echo $StudentsR[10] ?> </td>
                                   <td> <input type="checkbox" id="attendance['<?php echo $SID?>'"> </td>
                                  <td><?php echo $StudentsR['absence'] ?> </td>
                                     </tr>     
                                <?php  }   ?> 
                                </tbody>
                                  </table> 
                                <button type="submit" value="update" name="update" id="update">Save</button>
                                <button type="submit" name="reset" id="reset" >Reset</button>         
                     </form>    
                                 <?php 
                                        if(isset($_POST['update'])){

                                            $attendance=$_POST['attendance'];
                                          foreach($attendance as $SID=>$attendance)
                                            {
                                          try{

                                         require('Database/connection.php');
                                          {echo"mow";
                                            $stmt=$db->prepare("UPDATE enrollments 
                                            JOIN students ON enrollments.studentID =students.ID
                                            SET absence = absence + 1 
                                             WHERE enrollments.studentID =?");
                                            $stmt->execute(array($attendance,$SID));
                                                $db=null;
    ?>
                                          <script>swal("student Grades !", "student Grades has been updated!", "success");</script>
                                           <?php 
                                        }}
                                            
            
                    
                         catch(PDOException $EXC)
                         {
                               die('ERROR:'.$EXC->getMessage());
                              } }
               
                            
                            }
     
                          }?>
                   
                         

                            

       


    </div>

    </div>

    </div>
    </div>
    </div>

</div>

   <!-- Javascript file -->
   <script src="js/sidenav.js"></script>

      

                        
</body>