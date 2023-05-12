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
            <?php include 'sidenav/instr-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
        <div class="title" >
                <h1>Welcome Instructor Name</h1> 
            </div>
            <div class="instr-sched">
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