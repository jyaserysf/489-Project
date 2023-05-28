<?php 
    try{
        require('Database/connection.php');
        $stmt = $db->prepare("UPDATE course_sections SET startTime=?, endTime=?, days=?, room=?, instructorID=? WHERE ID=?");

        $startTime = $_POST['startTime'];
        $endTime = $_POST['endTime'];
        $days = $_POST['days'];
        $room = $_POST['room'];
        $instructorID = $_POST['instructorID'];

        $sectionID = $_POST['sectionID'];

        $stmt->execute(array($startTime, $endTime, $days, $room, $instructorID, $sectionID));

        header('location: manageSemesters.php');
    }
    catch(PDOException $e){
        die($e->getMessage());
        }
?> 