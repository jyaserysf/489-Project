<?php

session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
}

if(!isset($_POST['semesterID']) || !isset($_POST['courseID']) || $_POST['courseID']=="")
    die("Please Select A Course");

try{
    require('Database/connection.php');
    $stmt = $db->prepare("SELECT MAX(sectionNumber) AS max_number FROM course_sections WHERE semesterID=? AND courseID=?");
    $stmt->execute(array($_POST['semesterID'], $_POST['courseID']));
    if($sec = $stmt->fetch())
        $nextSec = $sec['max_number'] + 1;
    else
        $nextSec = 0;
    $stmt1 = $db->prepare("SELECT * FROM course_sections WHERE semesterID=? AND courseID=?");
    $stmt1->execute(array($_POST['semesterID'], $_POST['courseID']));
    if($final = $stmt1->fetch())
        $finalDate = $final['finalDate'];
    else
        $finalDate = 0;
    $db=null;
}
catch(PDOException $e){
    die($e->getMessage());
}
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
                <form method="post" action="HOD-addSection-2.php">
                    <div class='row'>
                    <div class='col-25'>
                        <label for='startTime'>Start Time</label>
                    </div>
                    <div class='col-75'>
                        <input 
                            class='input-field'
                            name='startTime'
                            type='time'
                            autocomplete='off'
                            required
                        />
                    </div>
                </div>

                <div class='row'>
                    <div class='col-25'>
                        <label for='endTime'>End Time</label>
                    </div>
                    <div class='col-75'>
                        <input 
                            class='input-field'
                            name='endTime'
                            type='time'
                            autocomplete='off'
                            required
                        />
                    </div>
                </div>

                <div class='row'>
                    <div class='col-25'>
                        <label for='Section Days'>Section Days</label>
                    </div>
                    <div class='col-75'>
                        <select class='input-field' name='days' >
                            <option disabled selected>Select Section Days</option>
                            <option value='UTH'>UTH</option>
                            <option value='MW'>MW</option>
                        </select>
                    </div>
                </div> 

                <div class='row'>
                    <div class='col-25'>
                        <label for='Room'>Room</label>
                    </div>
                    <div class='col-75'>
                        <input 
                            class="input-field"
                            type="text"
                            maxlength="10"
                            name="room"
                            autocomplete="off"
                            required
                        >
                    </div>
                </div>

                <div class='row'>
                    <div class='col-25'>
                        <label for='Room'>Number of Seats</label>
                    </div>
                    <div class='col-75'>
                        <input 
                            class="input-field"
                            type="number"
                            min="25"
                            max="35"
                            name="seats"
                            autocomplete="off"
                            required
                        >
                    </div>
                </div>

                <div class="row">
                    <div class='col-25'>
                        <label for='fname'>Instructor</label>
                    </div>
                    <div class='col-75'>
                        <?php
                            echo "<select name='instructorID' class='input-field'>";
                            echo "<option disabled selected>Select instructor</option>";

                            try {
                                require('Database/connection.php');
                                $sql = "SELECT ID, fullName FROM instructors ORDER BY departmentID";
                                $rs2 = $db->query($sql);
                                $db=null;
                            }
                            catch(PDOException $e) {
                                die($e->getMessage());
                            }
                            
                            // loop through and display Instructors FullName
                            foreach($rs2 as $option2) {
                            // Get the ID of the selected Instructor
                            $instructorID = $option2['ID'];
                            echo "<option value='$instructorID'> ". $option2['fullName'] . "</option>";
                            }
                            echo "</select>";
                        ?>
                    </div>
                </div>

                <?php
                    if($finalDate != 0)
                        echo "<input type='hidden' name='finalDate' value=' " . $finalDate . " '>";
                    else {
                        echo "
                                <div class='row'>
                                    <div class='col-25'>
                                        <label for='finalDate'>Final Date</label>
                                    </div>
                                    <div class='col-75'>
                                        <input 
                                            class='input-field'
                                            name='finalDate'
                                            type='date'
                                            autocomplete='off'
                                            required
                                        />
                                    </div>
                                </div>
                             ";
                    }
                ?>

                <input type="hidden" name="secNumber" value="<?php echo $nextSec ?>">
                <input type="hidden" name="semesterID" value="<?php echo $_POST['semesterID'] ?>">  
                <input type="hidden" name="courseID" value="<?php echo $_POST['courseID'] ?>"> 

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