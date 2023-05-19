<?php 
    try{
        require('Database/connection.php');
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
    <title>Document</title>
    
    <link rel="stylesheet" href="form.css">
    <link rel="stylesheet" href="generalstyling.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Manage Courses</h1> 
            </div>
            
            <div id="manageCoursesContainer">
                <a href="HOD-createCourse.php">
                    <button id="manageCoursesButton">
                        <h4> Create a new course </h4>
                    </button>
                </a>
                <a href="HOD-addSection.php">
                    <button id="manageCoursesButton">
                        <h4> Add new section </h4>
                    </button>
                </a>
            </div>
            
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>