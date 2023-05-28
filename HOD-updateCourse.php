<?php 

session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
}

    if(isset($_GET['courseID'])) {
        $courseID = $_GET['courseID'];
        try{
            require('Database/connection.php');
            $stmt = $db->prepare("SELECT * FROM courses WHERE ID=?");
            $stmt->execute(array($courseID));
            $db=null;
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
    }
    else {
        die("Please Select a Valid Course");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Course</title>
    
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
                <h1>Update Course</h1> 
            </div>

            <div class="container">
                
                <form method='post' action='HOD-updateCourse-2.php'>

                    <div class="row">
                        <td><h3>Enter Course Information</h3></td>
                    </div>

                    <?php
                        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>

                    <div class="row">
                        <div class="col-25">
                            <label for="Course Code">Course Code</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="text"
                                name="courseCode"
                                value="<?php echo $row['courseCode'];?>"
                                maxlength="8"
                                autocomplete="off"
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-25">
                            <label for="Course Name">Course Name</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="text"
                                maxlength="50"
                                name="courseName"
                                value="<?php echo $row['courseName'];?>"
                                autocomplete="off"
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-25">
                            <label for="Credit Hours">Credit Hours</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="number"
                                min="2"
                                max="4"
                                name="creditHours"
                                value="<?php echo $row['creditHours'];?>"
                                autocomplete="off"
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-25">
                            <label for="PreRequisites">PreRequisites</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="text"
                                name="preRequisites"
                                value="<?php echo $row['preRequisites'];?>"
                                maxlength="100"
                                autocomplete="off"
                            >
                        </div>
                    </div>
                    
                    <input type="hidden" name="courseID" value="<?php echo $courseID ?>">

                    <div class="row" id="submitDiv">
                        <input class="manageBtn" type="submit" value="Update Course" name="updateCourseSubmit" />
                    </div>
                </form>
                <?php } ?>
                <form method='get' action="HOD-manageCourses.php">
                    <div class="row" id="submitDiv">
                        <input class="manageBtn" type="submit" value="Cancel" name="Cancel" />
                    </div>
                </form>
            </div>
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>