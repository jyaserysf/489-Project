<?php 

session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
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
                <h1> Course Attendance </h1> 
            </div>
            <div class="attend-table">
                <table>
                    <tr> 
                        <th>Course Code</th><th>Course Name</th><th>Absence No.</th> <th>Absence %</th> <th>Excused Absence No.</th> <th>Excused Absence %</th> <th>Warning No.</th> 
                    </tr>
                    <?php 
                        // add rows for every absence, get from  enrollments table after instructor has assigned an absence
                        echo '<tr>
                                <td> </td>
                        </tr>';
                    ?>
                </table>
            </div>
            
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>