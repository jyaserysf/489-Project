<?php
    session_start();


    if(isset($_SESSION['activeUser'])) {
        if($_SESSION['activeUser']['role'] == "instructor")
            header('location: instructor-homep.php');
        elseif($_SESSION['activeUser']['role'] == "student")
            header('location: student-homep.php');
        elseif($_SESSION['activeUser']['role'] == "HOD")
            header('location: HOD-homep.php');
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
    <title>Admin Home Page</title>
    
    <link rel="stylesheet" href="generalstyling.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/admin-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Welcome Admin Name</h1> 
            </div>
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>