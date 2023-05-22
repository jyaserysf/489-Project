<?php
try {
    require('Database/connection.php');
    // course options sql statement
    $sql = "SELECT courses.courseCode, courses.courseName
            FROM courses
            JOIN course_sections
            ON courses.ID = course_sections.courseID 
            WHERE course_sections.courseID IS NOT NULL 
            GROUP BY courses.courseCode
            ORDER BY courses.ID";
    $rs = $db->query($sql);

    $db = null;
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="generalstyling.css">

    <style>
        .row-flex {
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            margin: 0 20px;
        }
    </style>

</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Manage Courses</h1> 
            </div>
            
            <div class="container">
                <form method='get'>
                    <div class="row">
                        <h3>Select course to manage</h3>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Course ID">Course</label>
                        </div>
                        <div class="col-75">
                        <?php        
                            // <select>
                            echo "<select class='input-field' name='courseID' >";
                            echo "<option disabled selected>Select Course</option>";
                            
                            // loop through and display SemesterYear(s) and SemesterNumbers
                            foreach($rs as $option) {
                                // Get the ID of the selected semester
                            $courseID = $option['ID'];
                            echo "<option value='$courseID'> ". $option['courseCode'] . "  " . $option['courseName'] . "</option>";
                            }

                            echo "</select>";
                        ?>
                        </div>
                    </div>

                    
                    
                </form>
            </div>

            <div class="row" class="submitDiv">
                    <div class="row-flex">
                        <button class="updateCourseBtn"> 
                            Update Course Information
                        </button>
                        
                        <button id="deleteCourseBtn">
                            delete
                        </button>
                    </div>
                </div>
            </div>  
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>