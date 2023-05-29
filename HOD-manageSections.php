<?php 
session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
}

if(isset($_POST['submit']))
    header('location: manageSemesters.php');

if(!isset($_POST['courseID']) || $_POST['courseID'] == "")
    header('location: manageSemesters.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Section</title>
    
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
                <h1>Select Section</h1> 
            </div>
            <div class="container">
                <form method='post' action='HOD-manageSections-2.php'>
                    <div class="row">
                        <h3>Select a section</h3>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Course ID">Section</label>
                        </div>
                        <div class="col-75">
                        <?php        
                            // <select>
                            try {
                                require('Database/connection.php');
                                $semesterID = $_POST['semesterID'];
                                $courseID = $_POST['courseID'];
                                $coursesInSemSQL = $db->prepare("SELECT * FROM course_sections WHERE courseID=? AND semesterID=?");
                                $coursesInSemSQL->execute(array($courseID, $semesterID));
                                echo "<select class='input-field' name='sectionID' >";
                                echo "<option disabled selected>Select Section</option>"; 
                                if ($rs = $coursesInSemSQL->fetchAll()) {
                                    foreach($rs as $option) {
                                        $sectionID = $option['ID'];
                                        $sectionNumber = $option['sectionNumber'];
                                        $courseInfoSQL = $db->prepare("SELECT * FROM courses WHERE ID=?");
                                        $courseInfoSQL->execute(array($courseID));
                                        if($courseInfo = $courseInfoSQL->fetch()) {
                                            $courseName = $courseInfo['courseName'];
                                            $courseCode = $courseInfo['courseCode'];
                                        }
                                        echo "<option value='$sectionID'> ". $courseCode . "  " . $courseName . ", Section " . $sectionNumber . "</option>";
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
                    <input type="hidden" name="courseID" value="<?php echo $_POST['courseID']; ?>">

                    <div class="flex-c">
                    <div class="row" id="submitDiv">
                        <input class="manageBtn" type="submit" value="Edit Section" />
                    </div>
                </form>

                
                <form method="post">
                    <div class="row" id="submitDiv">
                        <input class="manageBtn" type="submit" name="submit" value="Cancel" />
                    </div>
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