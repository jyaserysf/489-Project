<?php 
session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
}

if(isset($_POST['submit']))
    header('location: manageSemesters.php');

if(isset($_POST['sectionID'])) {
    $sectionID = $_POST['sectionID'];
    try{
        require('Database/connection.php');
        $stmt = $db->prepare("SELECT * FROM course_sections WHERE ID=?");
        $stmt->execute(array($sectionID));
        $db=null;
    }
    catch(PDOException $e){
        die($e->getMessage());
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Section</title>
    
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
<div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/instr-sidenav.php'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Edit Section</h1> 
            </div>

            <div class="container">
                
                <form method='post' action='HOD-updateSection1.php'>

                    <div class="row">
                        <td><h3>Edit or Remove Section</h3></td>
                    </div>

                    <?php
                        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>

                    
                    <div class="row">
                        <div class="col-25">
                            <label for="Course Code">Start Time</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="time"
                                name="startTime"
                                value="<?php echo $row['startTime'];?>"
                                autocomplete="off"
                                required
                            >
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Course Code">End Time</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="time"
                                name="endTime"
                                value="<?php echo $row['endTime'];?>"
                                autocomplete="off"
                                required
                            >
                        </div>
                    </div>
                    
                    <div class='row'>
                        <div class='col-25'>
                            <label for='Section Days'>Days</label>
                        </div>
                        <div class='col-75'>
                            <select class='input-field' name='days' >
                                <option value='UTH'
                                <?php
                                    if("UTH" == $row['days'])
                                        echo "selected"; 
                                ?>
                                >UTH</option>
                                <option value='MW'
                                <?php
                                    if("MW" == $row['days'])
                                        echo "selected"; 
                                ?>
                                >MW</option>
                            </select>
                        </div>
                    </div> 
                    
                    <div class="row">
                        <div class="col-25">
                            <label for="Credit Hours">Room</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="text"
                                maxlength="10"
                                name="room"
                                value="<?php echo $row['room'];?>"
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
                                    // <select>
                                    echo "<select name='instructorID' class='input-field'>";
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
                                    echo "<option value='$instructorID'";
                                    if($row['instructorID'] == $instructorID)
                                        echo "selected";
                                    echo "> ". $option2['fullName'] . "</option>";
                                    }
                                    echo "</select>";
                                ?>
                            </div>
                        </div>
                    
                    <input type="hidden" name="sectionID" value="<?php echo $sectionID ?>">

                    <div class="row" id="submitDiv">
                        <input class="manageBtn" type="submit" value="Update Section" name="updateCourseSubmit" />
                    </div>
                </form>
                <?php } ?>
                
                <form method="post" action="HOD-deleteSection.php">
                    <div class="flex-c">
                    <div class="row" id="submitDiv">
                        <input class="manageBtn" type="submit" name="submit" value="Remove Section" />
                    </div>
                    <input type="hidden" name="sectionID" value="<?php echo $sectionID ?>">
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
    
    <!-- Javascript file -->
    <script src="js/sidenav.js"></>
</body>
</html>