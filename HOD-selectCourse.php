<?php 
session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
}

if(isset($_POST['submit']))
    header('location: manageSemesters.php');

if(!isset($_POST['semesterID']) || $_POST['semesterID'] == "")
    header('location: manageSemesters.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Course</title>
    
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
            <?php include 'sidenav/instr-sidenav.php'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Select Course</h1> 
            </div>
            <div class="container">
                <form method='post' action='HOD-manageSections.php'>
                    <div class="row">
                        <h3>Select a course</h3>
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
                                $semesterID = $_POST['semesterID'];
                                $coursesInSemSQL = $db->prepare("SELECT * FROM course_sections WHERE semesterID=? GROUP BY courseID");
                                $coursesInSemSQL->execute(array($semesterID));
                                echo "<select class='input-field' name='courseID' >";
                                echo "<option disabled ";
                                if(!isset($_GET['CourseID'])) 
                                    echo "selected";
                                echo ">Select Course</option>";
                                if ($rs = $coursesInSemSQL->fetchAll()) {
                                    foreach($rs as $option) {
                                        $courseID = $option['courseID'];
                                        $courseInfoSQL = $db->prepare("SELECT * FROM courses WHERE ID=?");
                                        $courseInfoSQL->execute(array($courseID));
                                        if($courseInfo = $courseInfoSQL->fetch()) {
                                            $courseName = $courseInfo['courseName'];
                                            $courseCode = $courseInfo['courseCode'];
                                        }
                                        echo "<option value='$courseID'";
                                        if(isset($_GET['courseID']) && $courseID == $_GET['courseID'])
                                            echo "selected";
                                        echo "> ". $courseCode . "  " . $courseName . "</option>";
                                    }
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

                    <input type="hidden" name="semesterID" value="<?php echo $_POST['semesterID']; ?>">

                    <div class="row" id="submitDiv">
                        <input class="manageBtn" type="submit" value="Edit Sections" />
                    </div>
                </form>
                <form method="post" action="HOD-addCourse.php">
                    <div class="row" id="submitDiv">
                        <input class="manageBtn" type="submit" value="Add Section" />
                    </div>
                    <input type="hidden" name="semesterID" value="<?php echo $_POST['semesterID']; ?>">
                </form>

                <form method="post">
                    <div class="row" id="submitDiv">
                        <input class="manageBtn" type="submit" name="submit" value="Cancel" />
                    </div>
                </form>

                 </div> 
            </div>
        </div>
    </div>
            

    
    <!-- Javascript file -->
    <script src="js/sidenav.js"></>
</body>
</html>