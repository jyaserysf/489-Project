<?php 

try {
    require('Database/connection.php');
    if (isset($_POST['sectionId'])) {
        $sql_sectionDetails = "SELECT course_sections.*, courses.preRequisites, instructors.fullName FROM course_sections join courses on course_sections.courseID=courses.ID join instructors on course_sections.instructorID=instructors.ID where course_sections.ID=" . $_POST['sectionId'];
        $sectionDetailsrec = $db->query($sql_sectionDetails);
        if ($sectionDetailsrec->rowCount() > 0) {
            $sectionDetails = $sectionDetailsrec->fetch(PDO::FETCH_ASSOC);
            echo json_encode($sectionDetails);
        } else {
            echo "No section details available";
        }
    }
} catch(PDOException $e) {
    die($e->getMessage());
}
?>