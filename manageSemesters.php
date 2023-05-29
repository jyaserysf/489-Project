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
    <title>Manage Semesters</title>
    
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
                <h1>Manage Courses</h1> 
            </div>

            <div class="container">
                <form method='post' action='HOD-selectCourse.php'>
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
                        <input class="manageBtn" type="submit" value="Select Semester" />
                    </div>
                </div> 
                </form>
        </div>
    </div>
            
    <!-- Javascript file -->
    <script src="js/sidenav.js"></>
</body>
</html>