<?php 
session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
}

if(!isset($_POST['semesterID']))
    header('location: HOD-manageSemesters.php');

$semesterID = $_POST['semesterID'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Section</title>
    
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
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/instr-sidenav.php'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Add Section</h1> 
            </div>
            <div class="container">
                <form method='post' action='HOD-addSection.php'>
                    <div class='row'>
                        <td><h3>Select a course</h3></td>
                    </div>

                    <div class='row'>
                        <div class="col-25">
                            <label for="Course ID">Course</label>
                        </div>
                        <div class="col-75">
                            <?php
                        try {
                            require('Database/connection.php');
                            $coursesListSQL = $db->prepare("SELECT * FROM courses ORDER BY courseCode");
                            $coursesListSQL->execute();
                            $coursesList = $coursesListSQL->fetchAll();
                            echo "<select class='input-field' name='courseID' >";
                            echo "<option disabled selected>Select Course</option>";
                            foreach($coursesList as $course) {
                                $courseID = $course['ID'];
                                $courseName = $course['courseName'];
                                $courseCode = $course['courseCode'];
                                echo "<option value='$courseID'> " . $courseCode . "  " . $courseName . "</option>";
                            }
                            echo "</select>";
                            $db=null;
                        }
                        catch(PDOException $e) {
                            die($e->getMessage());
                        }
                        ?>
                        </div>
                    </div>
                    
                    <input type="hidden" name="semesterID" value="<?php echo $semesterID ?>">  

                    <div class="row" id="submitDiv">
                        <input class="manageBtn" type="submit" name="submit" value="Add Section" />
                    </div>

                </form>
            </div>
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>
</html>




