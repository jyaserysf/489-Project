<?php 

session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
}

$instructorID = $_SESSION['activeUser']['ID'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List</title>
    
    <link rel="stylesheet" href="generalstyling.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/instr-sidenav.php'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Course List</h1> 
            </div>
            <?php
            try{
                require('Database/connection.php');
                $semesterSQL = $db->prepare("SELECT * FROM semester WHERE NOW() BETWEEN beginDate AND endDate");
                $semesterSQL->execute();
                if($semester = $semesterSQL->fetch())
                    $semesterID = $semester['ID'];
                
                $sectionsSQL = $db->prepare("SELECT * FROM course_sections WHERE semesterID=? AND instructorID=? ORDER BY courseID");
                $sectionsSQL->execute(array($semesterID, $instructorID));
                $count = 0;
                while($section = $sectionsSQL->fetch()) {
                    if($count == 0) {
                        $courseNameSQL = $db->prepare("SELECT * FROM courses WHERE ID=?");
                        $courseNameSQL->execute(array($section['courseID']));
                        $courseName = $courseNameSQL->fetch();
                        echo "<div>";
                        echo $courseName['courseName'];
                        echo "</div>";
                        echo "<div>";
                        echo $section['sectionNumber'] . "-  " . $section['days'] . ",    " . $section['startTime'] . " - " . $section['endTime'];
                        echo "</div>";
                        $count++;
                        $prevCourseName = $courseName['courseName'];
                        continue;
                    }

                    $courseNameSQL = $db->prepare("SELECT * FROM courses WHERE ID=?");
                    $courseNameSQL->execute(array($section['courseID']));
                    $courseName = $courseNameSQL->fetch();

                    if($prevCourseName == $courseName['courseName']) {
                        echo "<div>";
                        echo $section['sectionNumber'] . "-  " . $section['days'] . ",    " . $section['startTime'] . " - " . $section['endTime'];
                        echo "</div>";
                    }
                    else {
                        echo "<div>";
                        echo $courseName['courseName'];
                        echo "</div>";
                        $prevCourseName = $courseName['courseName'];
                        echo "<div>";
                        echo $section['sectionNumber'] . "-  " . $section['days'] . ",    " . $section['startTime'] . " - " . $section['endTime'];
                        echo "</div>";
                    }
                }
                $db=null;
            }
            catch(PDOException $e){
                die($e->getMessage());
                }
            ?>
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>
</html>