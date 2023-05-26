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
                
                <form method='post' action='HOD-e3.php'>

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
                                required
                            >
                        </div>
                    </div>
                    
                    <input type="hidden" name="courseID" value="<?php echo $courseID ?>">

                    <div class="row" id="submitDiv">
                        <input class="submitBtn" type="submit" value="Update Course" name="updateCourseSubmit" />
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>