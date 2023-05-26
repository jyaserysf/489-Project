<?php 
session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Grading</title>
    
    <link rel="stylesheet" href="generalstyling.css">
    <link rel="stylesheet" href="courseGrading.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/instr-sidenav.php'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h2>Course Grading</h2> 
            </div>
            
       <div class="grading lg-px-5 lg-py-4">
            <form action="" method="get" >
                <div class="row row-col-2 ">
                    <div class="col">
                        <div class="row ms-1">
                            <select class="form-select border-secondary-subtle w-75 me-1" aria-label="Default select example">
                            <option selected>Course</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="3">Four</option>
                            </select>

                            <select class="form-select border-secondary-subtle"  style="width: 20%"  aria-label="Default select example">
                            <option selected>Section</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="3">Four</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 offset-1">
                        Semester:
                    </div>
                </div>
            </form>
        </div>

            <div class="student-list lg-mx-4 my-4" style="background-color: #FDF7CF" style="width:85%">
                <table class="table table-borderless">
                    <thead>
                        <tr> <th style="width: 8%"> ID </th> <th style="width: 15%"> Name </th>  <th class="" >Grade</th> </tr>
                    </thead>
                    <tbody>
                        <form method="post">
                        <tr>  
                        <td> 2019XXXX</td> <td> SName </td> 
                        <td>  
                            <select class=" " style="width: 10%" aria-label="Default select example">
                            <?php 
                               require 'gradesfunc.php';
                               selectGrade();
                            ?>
                            </select> 
                        </td> 
                        </tr>
                    </tbody>
                </table>
                <button type="submit" name="sb" value="">Save Section Grades</button>
            </form>
            </div>
            
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>