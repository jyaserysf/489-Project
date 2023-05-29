<?php 
    try{
        require('Database/connection.php');
        $stmt = $db->prepare("UPDATE course_sections SET startTime=?, endTime=?, days=?, room=?, instructorID=? WHERE ID=?");

        $startTime = $_POST['startTime'];
        $endTime = substr($startTime,0,3) . ":50:00";  
        $days = $_POST['days'];
        $room = $_POST['room'];
        $instructorID = $_POST['instructorID'];

        $sectionID = $_POST['sectionID'];

        $stmt->execute(array($startTime, $endTime, $days, $room, $instructorID, $sectionID));
        if($stmt->rowCount() < 0)
            die("The selected room is occupied");

        header('location: manageSemesters.php');
    }
    catch(PDOException $e){
        die($e->getMessage());
        }
?> 