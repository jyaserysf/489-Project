<?php 

    // New report types are to be entered here as key(report type)=>value(report identifier) pair.
    $reportTypes = ["Academic Transcript"=>"1"];
    require('gradesfunc.php');

    session_start();
    if(!isset($_SESSION['activeUser'])){
        header('Location: login.php');
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="generalstyling.css">
    <style>
        /*
        th, td {
            padding: 10px;
            text-align: center;
        }
        */

        table {
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        /* For tablet view */
        @media screen and (max-width: 768px) {
            th, td {
                padding: 4px;
            }
        }

        /* For mobile view */
        @media screen and (max-width: 480px) {
            th, td {
                display: block;
                padding: 4px;
            }
        
            th {
                text-align: center;
            }
        
            td:before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                text-transform: uppercase;
            }
        }

        
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.php'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Requests</h1> 
            </div>
            <div class="container">
                <form method='get'>
                    <div class="row">
                        <h3>Select Report Type</h3>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Report">Report</label>
                        </div>
                        <div class="col-75">
                        <?php        
                            echo "<select class='input-field' name='reportID' >";
                            echo "<option disabled selected>Select Report</option>";
                            foreach($reportTypes as $type=>$id) 
                                echo "<option value='$id'";
                                if(isset($_GET['reportID']))
                                    if($_GET['reportID'] == $id)
                                        echo "selected";
                                echo "> " . $type . "</option>";
                            echo "</select>";
                        ?>
                        </div>
                    </div>

                    <div class="row" id="submitDiv">
                        <input class="submitBtn" type="submit" value="Select Report" name="selectReportSubmit" />
                    </div>

                </form>
            </div>
        </div>
            
            <?php
                if(isset($_GET['selectReportSubmit']) && !isset($_GET['reportID'])) {
                    //pop up
                    ?>
                    <script>swal("No report type selected", "Choose a report type to continue.", "error");</script>
                    <?php
                }

                if(isset($_GET['selectReportSubmit']) && isset($_GET['reportID'])) {

                    $reportID = $_GET['reportID'];

                    if($reportID == '')
                        die("Please Select A Valid Report Type");

                    $valid = false;
                    foreach($reportTypes as $type=>$id) {
                        if($reportID == $id)
                            $valid = true;
                    }
                    if(!$valid)
                        die("Please Select A Valid Report Type");
                    
                    try {
                        $ID = $_SESSION['activeUser']['ID'];
                        require('Database/connection.php');
                        $stuInfoSQL = $db->prepare("SELECT * FROM students WHERE ID=?");
                        $stuInfoSQL->execute(array($ID));
                        $db=null;
                    }
                    catch(PDOException $e) {
                        die($e->getMessage());
                    }

                    if($stuInfo = $stuInfoSQL->fetch()) {
            ?>
                <div class="pagecontent-wrapper" id="main">
                    <div class="container">

                        <div class="row">
                            <h3>Student Information</h3>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <p>Student Name</p>
                            </div>
                            <div class="col-75">
                            <?php        
                            echo $stuInfo['fullName'];
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <p>Student ID</p>
                            </div>
                            <div class="col-75">
                            <?php        
                            echo $stuInfo['studentID'];
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <p>Study Program</p>
                            </div>
                            <div class="col-75">
                            <?php
                                try {
                                    require('Database/connection.php');
                                    $programSQl = $db->prepare("SELECT * FROM programs WHERE PID=?");
                                    $programSQl->execute(array($stuInfo['studyProgram']));
                                    $db=null; 
                                }
                                catch(PDOException $e) {
                                    die($e->getMessage());
                                }
                                $program = $programSQl->fetch();        
                                echo $program['name'];
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <p>Credit Hours Passed</p>
                            </div>
                            <div class="col-75">
                            <?php        
                            echo $stuInfo['creditsPassed'];
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <p>Semester GPA</p>
                            </div>
                            <div class="col-75">
                            <?php        
                                try {
                                    require('Database/connection.php');
                                    $lastSemester = $db->prepare("SELECT ID
                                    FROM semester
                                    WHERE beginDate < (SELECT beginDate FROM semester WHERE endDate >= CURDATE() LIMIT 1)
                                    AND endDate < CURDATE()
                                    ORDER BY endDate DESC
                                    LIMIT 1;
                                    ");
                                    $lastSemester->execute();
                                    $sum = 0;
                                    $sumCredits = 0;
                                    if($semesterID = $lastSemester->fetch()) {
                                        $courses = $db->prepare("SELECT * FROM course_sections WHERE semesterID=?");
                                        $courses->execute(array($semesterID['ID']));
                                        $sectionsID = $courses->fetchAll();
                                        foreach($sectionsID as $section) {
                                            $enrollment = $db->prepare("SELECT * FROM enrollments WHERE studentID=? AND sectionID=?");
                                            $enrollment->execute(array($_SESSION['activeUser']['ID'], $section['ID']));
                                            if($enroll = $enrollment->fetch()) {
                                                $creditsIndo = $db->prepare("SELECT * FROM courses WHERE ID=?");
                                                $creditsIndo->execute(array($section['courseID']));
                                                if($course = $creditsIndo->fetch())
                                                    $credits = $course['creditHours'];
                                                if($enroll['grade']){
                                                    $sum += $gradesW[$enroll['grade']] * $credits;
                                                    $sumCredits += $credits;
                                                }
                                                
                                            }
                                            if($sumCredits!=0){
                                                echo $sum/$sumCredits;
                                            }
                                        
                                        }
                                    }
                                    $db=null;
                                }
                                catch(PDOException $e) {
                                    die("Error: " . $e->getMessage());
                                }
                            ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-25">
                                <p>Cumulative GPA</p>
                            </div>
                            <div class="col-75">
                            <?php        
                                 try {
                                    require('Database/connection.php');
                                    $lastSemesters = $db->prepare("SELECT ID
                                    FROM semester
                                    WHERE beginDate < (SELECT beginDate FROM semester WHERE beginDate >= CURDATE() LIMIT 1)
                                    ORDER BY beginDate DESC
                                    ");
                                    $lastSemesters->execute();
                                    $sum = 0;
                                    $sumCredits = 0;
                                    while($semesterID = $lastSemesters->fetch()) {
                                        $courses = $db->prepare("SELECT * FROM course_sections WHERE semesterID=?");
                                        $courses->execute(array($semesterID['ID']));
                                        $sectionsID = $courses->fetchAll();
                                        foreach($sectionsID as $section) {
                                            $enrollment = $db->prepare("SELECT * FROM enrollments WHERE studentID=? AND sectionID=?");
                                            $enrollment->execute(array($_SESSION['activeUser']['ID'], $section['ID']));
                                            if($enroll = $enrollment->fetch()) {
                                                $creditsIndo = $db->prepare("SELECT * FROM courses WHERE ID=?");
                                                $creditsIndo->execute(array($section['courseID']));
                                                if($course = $creditsIndo->fetch())
                                                    $credits = $course['creditHours'];
                                                if($enroll['grade']!=NULL){
                                                    $sum += $gradesW[$enroll['grade']] * $credits;
                                                $sumCredits += $credits;
                                                }
                                                
                                            }
                                        }
                                    }
                                    echo $sum/$sumCredits;
                                    $db=null;
                                }
                                catch(PDOException $e) {
                                    die("Error: " . $e->getMessage());
                                }
                            ?>
                            </div>
                        </div>

                    </div>
                </div>
                
                <?php
                    if($reportID == 1) {
                ?> 

                <div class="pagecontent-wrapper" id="main">
                    <div class="container">

                        <div class="row">
                            <h3>Academic Transcript</h3>
                        </div>

                        <?php
                            try {
                                require('Database/connection.php');
                                $enrollmentsSQL = $db->prepare("SELECT * FROM enrollments WHERE studentID=?");
                                $enrollmentsSQL->execute(array($_SESSION['activeUser']['ID']));
                                if ($enrollments = $enrollmentsSQL->fetchAll()) {
                                    $transcript = [];
                                    foreach($enrollments as $enrollment) {
                                        $sectionID = $enrollment['sectionID'];
                                        $sectionsSQL = $db->prepare("SELECT * FROM course_sections WHERE ID =?");
                                        $sectionsSQL->execute(array($sectionID));
                                        $section = $sectionsSQL->fetch();
                                        $semesterID = $section['semesterID'];
                                        $courseID = $section['courseID'];
                                        $transcript[$courseID] = $semesterID;
                                    }
                                    $semesterSQL = $db->prepare("SELECT * FROM semester");
                                    $semesterSQL->execute();
                                    $semesters = $semesterSQL->fetchAll();
                                    $sortedTranscript = [];
                                    foreach ($semesters as $semester) {
                                        $semesterId = $semester['ID'];
                                        $beginDate = $semester['beginDate'];
                                        foreach ($transcript as $courseId => $associatedSemester) {
                                            if ($associatedSemester == $semesterId) {
                                                $sortedTranscript[$beginDate][$courseId] = $semesterId;
                                            }
                                        }
                                    }
                                    ksort($sortedTranscript);
                                    foreach($sortedTranscript as $date=>$courseSemester) {
                                        echo "<div class='row'>";
                                        echo "<table border='1' width='70%' align='center'>";
                                        $count = 0;
                                        foreach($courseSemester as $course=>$semester) {
                                            if($count == 0) {
                                                echo "<tr>";
                                                echo "<th colspan='4'>";
                                                $semesterInfoSQL = $db->prepare("SELECT * FROM semester WHERE ID=?");
                                                $semesterInfoSQL->execute(array($semester));
                                                $semesterInfo = $semesterInfoSQL->fetch();
                                                echo $semesterInfo['year'] . "  -  Semester  " . $semesterInfo['number'];
                                                echo "</th>";
                                                echo "</tr>";
                                                echo "<tr>";
                                                echo "<th>";
                                                echo "Course Code";
                                                echo "</th>";
                                                echo "<th>";
                                                echo "Course Name";
                                                echo "</th>";
                                                echo "<th>";
                                                echo "Credit Hours";
                                                echo "</th>";
                                                echo "<th>";
                                                echo "Course Grade";
                                                echo "</th>";
                                                echo "</tr>";
                                                $count++;
                                            }
                                            echo "<tr>";
                                            echo "<td>";
                                            $courseNameSQL = $db->prepare("SELECT * FROM courses WHERE ID=?");
                                            $courseNameSQL->execute(array($course));
                                            $courseInfo = $courseNameSQL->fetch();
                                            $courseCode = $courseInfo['courseCode'];
                                            echo $courseCode;
                                            echo "</td>";
                                            echo "<td>";
                                            $courseName = $courseInfo['courseName'];
                                            echo $courseName;
                                            echo "</td>";
                                            echo "<td>";
                                            $courseCredits = $courseInfo['creditHours'];
                                            echo $courseCredits;
                                            echo "</td>";
                                            echo "<td>";
                                            $sectionSQL = $db->prepare("SELECT * FROM course_sections WHERE semesterID=? AND courseID=?");
                                            $sectionSQL->execute(array($semester, $course));
                                            $secInfo = $sectionSQL->fetch();
                                            $enrollSQL = $db->prepare("SELECT * FROM enrollments join course_sections on enrollments.sectionID=course_sections.ID WHERE studentID=? AND sectionID=?");
                                            $enrollSQL->execute(array($_SESSION['activeUser']['ID'], $secInfo['ID']));
                                            $enrollInfo = $enrollSQL->fetch();

                                            $registerSec=$db->prepare('SELECT enrollments.*, course_sections.* FROM `enrollments`join course_sections on enrollments.sectionID=course_sections.ID JOIN semester on semester.ID=course_sections.semesterID WHERE NOW() BETWEEN semester.modifyStart and semester.modifyEnd and enrollments.studentID=?;');
                                            $registerSec->execute(array($_SESSION['activeUser']['ID']));
                                            $rSec=$registerSec-> fetch();

                                            if($enrollInfo['grade'] != NULL)
                                                echo $enrollInfo['grade'];
                                            elseif($enrollInfo['semesterID']==$rSec['semesterID']){
                                                echo "Registeration Period";
                                            }
                                            else
                                                echo "Current Semester";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                        echo "</table>";
                                        echo "</div>";
                                        echo "<br><br>";
                                    }
                                }
                                else {
                                    echo "<div><p>No Data Available</p></div>";
                                }
                                $db=null;
                            }
                            catch(PDOException $e) {
                                die($e->getMessage());
                            }
                        ?>

                    </div>
                </div>


            <?php
                    }
                    }
                }
            ?>

    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>
</html>