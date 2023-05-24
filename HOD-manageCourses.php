<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    
    <link rel="stylesheet" href="generalstyling.css">

    <style>
        .row-flex {
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            margin: 0 20px;
        }

        .manageBtn {
            width: 10rem;
            height: 4rem;
            background-color:rgba(0, 0, 0, 0.8);
            color: #fff;
            border: none;
            padding: 12px 20px;
            /*finger*/
            cursor: pointer;
            float: right;
            border-radius: 5px;
            font-size: 1rem;
            transition: 0.3s;
            margin: 0 10px 0 10px;
        }

        .manageBtn:hover {
        background-color: #A0BCC2;
        }

        .hidden {
        display: none;
        }

        .content {
            border-radius: 5px;
            background-color: #f4f1de /* rgba(236, 232, 221, 0.7)*/;
            padding: 20px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('button');
        const divs = document.querySelectorAll('.content');

        buttons.forEach((button) => {
            button.addEventListener('click', function () {
            const targetDivId = this.id.replace('btn', 'div');
            const targetDiv = document.getElementById(targetDivId);

            divs.forEach((div) => {
                div.classList.toggle('hidden', div !== targetDiv);
            });
            });
        });
        });
    </script>   

</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/hod-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Manage Courses</h1> 
            </div>
            <?php if(!isset($_POST['semesterID']) && !isset($_GET['CourseID'])) {?>
            <div class="container">
                <form method='post'>
                    <div class="row">
                        <h3>Select A Semester To Manage</h3>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="semesterID">Semester</label>
                        </div>
                        <div class="col-75">
                        <?php        
                            // <select>
                            try {
                                require('Database/connection.php');
                                $semesterSQL = $db->prepare("SELECT * FROM semester WHERE NOW() BETWEEN modifyStart AND modifyEnd");
                                $semesterSQL->execute();

                                $nextSemesterSQL = $db->prepare("SELECT * FROM semester WHERE modifyStart = (
                                    SELECT MIN(modifyStart) FROM semester WHERE modifyStart > NOW())"
                                );
                                $nextSemesterSQL->execute();

                                echo "<select class='input-field' name='semesterID' >";
                                echo "<option disabled selected>Select Semester</option>";
                                if($semesterInfo = $semesterSQL->fetch()) {
                                    $semesterID = $semesterInfo['ID'];
                                    echo "<option value='$semesterID'> ". $semesterInfo['year'] . " - " . $semesterInfo['number'] . " (Coming Semester)" ."</option>";
                                    }
                                    $nextSemesterID = $nextSemesterSQL->fetch();
                                    echo "<option value=' " . $nextSemesterID['ID'] . "'> " . $nextSemesterID['year'] . " - " . $nextSemesterID['number'] . " (Next Semester)" . "</option>";
                                    echo "</select>";
                                $db=null;
                            }
                            catch(PDOException $e) {
                                die("Error: " . $e->getMessage());
                            }
                        ?>
                        </div>
                    </div>
                    <div class="row" id="submitDiv">
                        <input class="submitBtn" type="submit" value="Select Course" />
                    </div>
                </div> 
                </form>
        </div>
    </div>
    <?php   } 
            else {
    ?>
    
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
                            try {
                                require('Database/connection.php');
                                $checkSemesterSQL = $db->prepare("SELECT * FROM semester WHERE NOW() BETWEEN modifyStart AND modifyEnd");
                                $checkSemesterSQL->execute();
                                if($row = $checkSemesterSQL->fetch()) {
                                    if($_POST['semesterID'] == $row['ID']) {
                                        $coursesInSemSQL = $db->prepare(
                                            "SELECT courses.courseCode, courses.courseName, courses.ID
                                            FROM courses
                                            JOIN course_sections
                                            ON courses.ID = course_sections.courseID 
                                            WHERE course_sections.courseID IS NOT NULL 
                                            GROUP BY courses.courseCode
                                            ORDER BY courses.ID
                                            ");
                                        $coursesInSemSQL->execute();

                                        echo "<select class='input-field' name='courseID' >";
                                        echo "<option disabled ";
                                        if(!isset($_GET['CourseID'])) 
                                            echo "selected";
                                        echo ">Select Course</option>";
                                        $rs = $coursesInSemSQL->fetchAll();
                                        foreach($rs as $option) {
                                            $courseID = $option['ID'];
                                            echo "<option value='$courseID'";
                                            if(isset($_GET['courseID']) && $courseID == $_GET['courseID'])
                                                echo "selected";
                                            echo "> ". $option['courseCode'] . "  " . $option['courseName'] . "</option>";
                                        }

                                        echo "</select>";
                                    }
                                }
                                $db=null;
                            }
                            catch(PDOException $e) {
                                die("Error: " . $e->getMessage());
                            }
                        ?>
                        </div>
                    </div>

                    <div class="row" id="submitDiv">
                        <input class="submitBtn" type="submit" value="Select Course" />
                    </div>

                </div> 
                </form>
                
                <div class="row">
                    <div class="row-flex">
                        <button id="btn1" class="manageBtn">Add New Course</button>
                        <button id="btn2" class="manageBtn">Update Course</button>
                        <button id="btn3" class="manageBtn">Manage Sections</button>
                    </div>
                </div> 
            </div>
            <h1></h1>
            
            <div id="div1" class="content hidden">
                <?php 
                    require('HOD-createCourse.php')
                ?>
            </div>

            <div id="div2" class="content hidden">
                <?php 
                if(isset($_GET['courseID']))
                    require('HOD-updateCourse.php');
                else
                    // POP-UP Error Message: PLease Select A Course To Update 
                ?>
            </div>

            <div id="div3" class="content hidden">
                <?php
                if(isset($_GET['courseID']))
                    require('HOD-manageSections.php');
                else
                    // POP-UP Error Message: PLease Select A Course To Manage Its Sections       
                ?>
            </div>
        <?php } ?>
        </div>
    </div>

    
    <!-- Javascript file -->
    <script src="js/sidenav.js"></>
</body>
</html>