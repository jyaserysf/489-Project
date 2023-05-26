<?php
    session_start();

    if(!isset($_SESSION['activeUser'])){
        header('Location: login.php');
        exit();
    }

    if(isset($_SESSION['activeUser'])) {
        if($_SESSION['activeUser'] == "instructor")
            header('location: instructor-homep.php');
        elseif($_SESSION['activeUser'] == "admin")
            //header('location:');
            echo "admin";
    }
    else {
        header('location: login.php');
    }
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
    
    <link rel="stylesheet" href="generalstyling.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.php'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Welcome Student Name</h1> 
            </div>
            <div class="student-sched">
                <div class="semester-no">
                    Your semester number Schedule
                </div>
                <div class="sched">
                    <?php 
                    require('schedule.php');
                    schedule();?>
                </div>
            </div>
            
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>