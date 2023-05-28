<?php 
    try{
        require('Database/connection.php');
        $stmt = $db->prepare("UPDATE courses SET courseCode=?, courseName=?, creditHours=?, preRequisites=? WHERE ID=?");

        if(!isset($_POST['courseCode']) || !isset($_POST['courseName']) || !isset($_POST['creditHours']) || !isset($_POST['courseID']))
            die("Enter All Course Information");
        $courseCode = $_POST['courseCode'];
        $courseName = $_POST['courseName'];
        $creditHours = $_POST['creditHours'];
        $preRequisites = $_POST['preRequisites'];
        $courseID = $_POST['courseID'];

        $courseCodePattern = "/^[A-Z]{3,5}[0-9]{1,3}$/";
        $courseNamePattern = "/^[A-Z]{1}[a-z]+(\s{1}[A-Z]{1}[a-z]+)*[1-9]?$/";
        $creditHoursPattern = "/^[2-4]{1}$/";
        $preRequisitesPattern = "/^[A-Z]{3,5}[0-9]{1,3}(,[A-Z]{3,5}[0-9]{1,3})*$/";

        if(!preg_match($courseCodePattern, $courseCode))
            die ("Invalid Course ID");
        if(!preg_match($courseNamePattern, $courseName))
            die ("Invalid Course Name");
        if(!preg_match($creditHoursPattern, $creditHours))
            die ("Invalid Credit Hours");
        if($preRequisites != "" && !preg_match($preRequisitesPattern, $preRequisites))
            die ("Invalid PreRequisites");

        $stmt->execute(array($courseCode, $courseName, $creditHours, $preRequisites, $courseID));

        $db = null;
        header('location: HOD-manageCourses.php');
    }
    catch(PDOException $e){
        die($e->getMessage());
        }
?>
