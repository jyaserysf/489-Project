<?php
 try {
    require("Database/connection.php");
    $stmt = $db->prepare("INSERT INTO course_sections (ID, semesterID, courseID, sectionNumber, startTime, endTime, days, room, availableSeats, finalDate, instructorID) 
    VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sectionNumber = $_POST['secNumber'];
    $startTime = $_POST['startTime'];
    $endTime = substr($startTime,0,3) . ":50:00";
    if($_POST['days'] != "UTH" && $_POST['days'] != "MW")
        die("Please Select Valid Days");

    $days = $_POST['days'];

    $room = $_POST['room'];
    if(!preg_match('/^(0[1-9][0-9]|[12]0[1-9][0-9])$/', $room))
        die("Please Write A Valid Room number");

    $availableSeats = $_POST['seats'];
    if($_POST['instructorID'] == "" || $_POST['instructorID'] < 0)
        die("Please Select A Valid instructor");

    $instructorID = $_POST['instructorID'];

    $finalDate = $_POST['finalDate'];
    $checkTime = $db->prepare("SELECT * FROM semester WHERE ID=?");
    $checkTime->execute(array($_POST['semesterID']));
    $semInfo = $checkTime->fetch();
    if($finalDate < $semInfo['beginDate'] || $finalDate > $semInfo['endDate'])
        die("Please Select A Time Between The Semester Begin And End Date");

    $semesterID = $_POST['semesterID'];
    $courseID = $_POST['courseID'];
    
    $stmt->execute(array($semesterID, $courseID, $sectionNumber, $startTime, $endTime, $days, $room, $availableSeats, $finalDate, $instructorID));

    $db = null;
    header('location: manageSemesters.php');
 }
    catch(PDOException $e) {
        echo "An Error Has Occured";
        die($e->getMessage());
    }
?>