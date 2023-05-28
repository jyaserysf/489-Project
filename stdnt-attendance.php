<?php 

session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
}

    try{
        require('Database/connection.php');
        $Courses = " SELECT DISTINCT enrollments.*, courses.courseCode, courses.courseName FROM `enrollments`JOIN students ON enrollments.studentID=students.ID JOIN course_sections on enrollments.sectionID=course_sections.ID join courses on course_sections.courseID=courses.ID JOIN semester on course_sections.semesterID=semester.ID WHERE students.ID =".  $_SESSION['activeUser']['ID']." AND NOW() BETWEEN beginDate AND endDate";
       
         $ViewC = $db->query($Courses);
      
         
        
    }
    catch(PDOException $e){
        die($e->getMessage());
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/Attendance_instractor.css">
    <link rel="stylesheet" href="generalstyling.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.php'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1> Course Attendance </h1> 
            </div>
            <div class="attend-table">
                <table>
             <tr>
                        <th>Course Code</th>
                       
                     
                        <th>Course Name</th>
                       
              
                        <th>Absence No.</th> 
                    
                   
                 
                        <th>Absence %</th> 
 </tr>     

<?php
// echo $_SESSION['activeUser']['ID'];
foreach($ViewC as $display){
    if($display['absence']>=1){?>
        <tr>
        <td> <?php echo $display['courseCode']?> </td>
        <td> <?php echo $display['courseName']?> </td>
        <td> <?php echo $display['absence']?> </td>

        <?php $P=$display['absence']/30;$P  ?>    
        <td <?php if($display['absence']>=5)echo'style="background-color: red"'?>><?php echo number_format($P*100,2) ."%";  ?></td>
    <?php }
}?> 


</tr>
</td>
                 

                </table>
            </div>
            
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>
<style>
       td{
            text-align: center;
        }
        table{
            margin-left: 10%;
            
        }
        h1{
            text-align: center;
        }
</style>