<?php
require( 'Database/connection.php');
try {
    if (isset($_POST['CourseName_code'])) {
        $Courses="SELECT DISTINCT courses.courseCode, semester.ID,course_sections.courseID, courses.courseName,
        instructors.ID ,instructors.fullName, course_sections.sectionNumber FROM course_sections JOIN 
         courses on course_sections.courseID=courses.ID JOIN instructors 
        ON course_sections.instructorID=instructors.ID join semester on
         course_sections.semesterID=semester.ID";
        $ViewC=$db->query($Courses);
        
        $Sections="SELECT sectionNumber , courseID FROM `course_sections`;";
        $viewSec=$db->query($Sections);
        $db=null;

    
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