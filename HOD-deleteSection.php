<?php
    try{
        require('Database/connection.php');
        $sectionID = $_POST['sectionID'];
        $stmt = $db->prepare("SELECT * FROM enrollments WHERE sectionID=?");
        $stmt->execute(array($sectionID));
        $numOfEnrollemnts = $stmt->rowCount();
        if ($numOfEnrollemnts > 10)
            die("Section Cannot Be Deleted There are more Than 10 Students
                Enrolled In This Section");
        else {
            $stmt1 = $db->prepare("DELETE FROM enrollments WHERE sectionID=?");
            $stmt1->execute(array($sectionID));

            $stmt2 = $db->prepare("DELETE FROM course_sections WHERE ID=?");
            $stmt2->execute(array($sectionID));
        }
        $db = null;
        header('location: manageSemesters.php');
    }
    catch(PDOException $e){
        die($e->getMessage());
    }
?>