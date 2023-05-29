<?php 

try{

    require('Database/connection.php');
    $db->beginTransaction();
    $stID=$_SESSION['activeUser']['ID'];
                    
    $ID = $_SESSION['activeUser']['username'];
                    
                    
                    $semesterInfo="SELECT* from semester where now() BETWEEN semester.modifyStart and semester.modifyEnd";
                    $semester =$db->query($semesterInfo);
                    $semm=$semester->fetch();

                    $stInfo = "SELECT students.*, programs.name, programs.year, programs.departmentID, programs.PID FROM students JOIN programs ON students.studyProgram=programs.PID where students.studentID=$ID ";
                    $studentRec = $db->query($stInfo);
                    $row=$studentRec->fetch();

                    $prevenrolled_sectionsrec="SELECT course_sections.*, enrollments.grade, enrollments.paid, enrollments.studentID, courses.courseCode from course_sections Join enrollments on course_sections.ID = enrollments.sectionID join courses on courses.ID=course_sections.courseID where enrollments.studentID=".$row['ID'];
                    $prevEnrolled_sections=$db->query($prevenrolled_sectionsrec);
                    $passedCourses=$prevEnrolled_sections->fetch();

                    $sql_stEnrollID="SELECT students.ID from students where studentID=$ID";
                                $stEnrollIDrec=$db->query($sql_stEnrollID);
                                $stEnrollID=$stEnrollIDrec->fetch();
                                

                    $enrolledSectionsthisSem=$db->prepare("SELECT enrollments.* , course_sections.*, semester.* from enrollments join course_sections on enrollments.sectionID=course_sections.ID join semester on course_sections.semesterID=semester.ID where semester.ID=:sID and enrollments.studentID=:stID");
                    $enrolledSectionsthisSem->bindParam(':sID', $semm['ID']);
                    $enrolledSectionsthisSem->bindParam(':stID', $stID);
                    $enrolledSectionsthisSem->execute();
                    
                    $enrollsectSemALL=$enrolledSectionsthisSem->fetchAll(PDO::FETCH_ASSOC);
                    $checkCourse=$db->prepare("SELECT * FROM courses where ID=:courID");
                    //print_r($enrollsectSemALL);

                    
                    
                    $updateAvailbSeats=$db->prepare("UPDATE course_sections set availableSeats=:seats where ID=:secID ");

                    $db->commit();
                    

}catch(PDOException $e){
    $db->rollBack();
    die("Error: " . $e->getMessage());

}

?>