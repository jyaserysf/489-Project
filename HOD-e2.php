<?php
 try {
    require("Database/connection.php");
    $db->beginTransaction();
    $stmt = $db->prepare("INSERT INTO course_sections (ID, semesterID, courseID, sectionNumber, startTime, endTime, days, room, availableSeats, finalDate, instructorID) 
    VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    for ($i = 0; $i < count($_POST['room']); $i++) {
        $sectionNumber = $i+1;
        $startTime = $_POST['startTime'][$i];
        $endTime = $_POST['endTime'][$i];
        $days = $_POST['days'][$i];
        $room = $_POST['room'][$i];
        $availableSeats = $_POST['seats'][$i];
        $instructorID = $_POST['instructorID'][$i];

        $finalDate = $_POST['finalDate'];
        $semesterID = $_POST['semesterID'];
        $courseID = $_POST['courseID'];
        
        $stmt->execute(array($semesterID, $courseID, $sectionNumber, $startTime, $endTime, $days, $room, $availableSeats, $finalDate, $instructorID));
    }

    // commit transaction
    $db->commit();

    // close the connection
    $db = null;

    echo "<h2>Section(s) has been added successfully!</h2>";
    $db=null;
 }
    catch(PDOException $e) {
        echo "An Error Has Occured";
        die($e->getMessage());
    }
?>