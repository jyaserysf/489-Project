<?php
require( 'Database/connection.php');
try {
    if (isset($_POST["courseID"])) {
        $query = "SELECT DISTINCT courses.courseCode, semester.ID, course_sections.courseID, courses.courseName,
                  instructors.ID, instructors.fullName, course_sections.sectionNumber 
                  FROM course_sections 
                  JOIN courses ON course_sections.courseID=courses.ID 
                  JOIN instructors ON course_sections.instructorID=instructors.ID 
                  JOIN semester ON course_sections.semesterID=semester.ID 
                  WHERE courseCode = " . $_POST['courseID'];

        $output = $db->query($query);
        if ($output->rowCount() > 0) {
            echo '<option value="">Section Number </option>';
            while ($row = $output->fetchAll()) {
                echo '<option value="' . $row[6] . '</option>';
            }
        }
    }
} catch (PDOException $e) {
    die($e->getMessage());
}
?>