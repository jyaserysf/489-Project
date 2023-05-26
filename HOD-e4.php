<?php 
    try{
        require('Database/connection.php');
        $stmt = $db->prepare("UPDATE course_sections SET startTime=?, endTime=?, days=?, room=?, finalDate=?, instructorID=? WHERE ID=?");

        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $days = $_POST['days'];
        $room = $_POST['room'];
        $finalDate = $_POST['finalDate'];
        $instructorID = $_POST['instructorID'];

        $sectionID = $_POST['sectionID'];

        $stmt->execute(array($startTime, $endTime, $days, $room, $finalDate, $instructorID, $sectionID));

        header('location: HOD-manageCourses.php');
    }
    catch(PDOException $e){
        die($e->getMessage());
        }
?> 