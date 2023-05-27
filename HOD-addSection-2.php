<?php
 try {
    require("Database/connection.php");
    $stmt = $db->prepare("INSERT INTO course_sections (ID, semesterID, courseID, sectionNumber, startTime, endTime, days, room, availableSeats, finalDate, instructorID) 
    VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sectionNumber = $_POST['secNumber'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $days = $_POST['days'];
    $room = $_POST['room'];
    $availableSeats = $_POST['seats'];
    $instructorID = $_POST['instructorID'];

    $finalDate = $_POST['finalDate'];
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