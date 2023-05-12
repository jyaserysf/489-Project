
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
    
    <link rel="stylesheet" href="generalstyling.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h2>Welcome</h2> 
            </div>
            <div class="" id="student-info">
          <?php  echo
           '<div class=" ">Student Name: Jood Yaser AlYusuf </div>
            <div class="">Major: Computer Science </div>
            <div class="">Credit Hours: 76</div>
            <div class="">Semester: 2022/2023 </div>'; ?>
       </div>
       <div class="3 " id="course-section">
            <form action="" method="post">
                <div class="">
                 <select class="form-select border-secondary-subtle" id="selectcourse"  >
                    <option hidden disabled selected value> Select a course </option>
                    <option >Course</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                    <option value="3">Four</option>
                </select> 
                </div>
                <!-- <label for="selectcourse">Select Course</label> aria-label="Floating label select example"</div> -->
                <div class="" id="selectsection">
                    <span> Section: </span> 

                </div>
            </form>
            <div class=" col my-2">
                <div class="row"> </div>
            </div>
       </div>

            
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>



<h1 class=" mb-lg-5 mb-4">Course Registeration</h1>
       