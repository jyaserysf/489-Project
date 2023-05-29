<?php

session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
}

?>
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
            width: 10.5rem;
            height: 40px;
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
            margin: 2rem 1rem 0 0;
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

</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/instr-sidenav.php'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Manage Courses</h1> 
            </div>
            <div class="container">
                <form method='get' action='HOD-updateCourse.php'>

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
                                        $depSQL = $db->prepare("SELECT * FROM departments WHERE departmentHead=?");
                                        $depSQL->execute(array($_SESSION['activeUser']['ID']));
                                        $dep = $depSQL->fetch();
                                        $depID = $dep['ID'];
                                        $coursesInSemSQL = $db->prepare("SELECT * FROM courses WHERE courseDepartment=? ORDER BY courseCode");
                                        $coursesInSemSQL->execute(array($depID));
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
                                        $db=null;
                            }
                            catch(PDOException $e) {
                                die("Error: " . $e->getMessage());
                            }
                        ?>
                        </div>
                    </div>

                    <div class="flex-c">
                    <div class="row" id="submitDiv">
                        <input class="manageBtn" type="submit" value="Manage Course" />
                    </div>

                </form>

                <form method="get" action="HOD-createCourse.php">
                    <div class="row" id="submitDiv">
                        <input class="manageBtn" type="submit" value="Add Course" />
                    </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Javascript file -->
    <script src="js/sidenav.js"></>
</body>
</html>