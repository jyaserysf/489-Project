
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
    <script src="https://kit.fontawesome.com/8f65530edf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="generalstyling.css">
    <link rel="stylesheet" href="css/courseReg.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Course Registeration</h1> 
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
                      Course:<select class="form-select border-secondary-subtle" id="selectcourse"  >
                         <option hidden disabled selected value> Select a course </option>
                         <option value="1">One</option>
                         <option value="2">Two</option>
                         <option value="3">Three</option>
                         <option value="3">Four</option>
                      </select> 
                     </div>
                     <!-- <label for="selectcourse">Select Course</label> aria-label="Floating label select example"</div> -->
                     <div class=" ">
                         Section: 
                         <button type="submit" name="option" value="option1"> 01 | UTH</button>
                         <button type="submit" name="option" value="option2">02 | UTH</button>
                         <button type="submit" name="option" value="option3">3 | MW</button>
                     </div>
                 </form>
             </div>
            <div class=" course-manage">
                <div class="course-info"> 
                    <div> 
                        Instructor Name: <br>
                        Lecture Timing: <br>
                        Available Seats: <br>
                        Pre-requisite: <br>
                        Final Exam Date: <br>
                    </div>
                    <div>
                        Lecture Conflict: <br>
                        Final Conflict: <br>
                    </div>
                </div>
                <div class="course-toolb">
                    <div> <button name="addcourse" ><i class="fa-regular fa-plus" style="color: rgba(0, 0, 0, 0.7);"></i> </button> </div>
                    <div> <button name="switchsection" ><i class="fa-solid fa-rotate" style="color: rgba(0, 0, 0, 0.7);"></i> </button> </div>
                    <div> <button name="dropcourse" ><i class="fa-solid fa-trash"  style="color: rgba(0, 0, 0, 0.7);"></i> </button> </div>
                </div>
            </div>
            <div class="display-sched">
                <div class="sched">
                    <?php 
                    require('schedule.php');
                    schedule();?>
                </div>
                <div class="sched-toolb">
                <div> <button name="export" > <i class="fa-solid fa-download"style="color: rgba(0, 0, 0, 0.7);"></i> </button> </div>
                <div> <button name="print" > <i class="fa-solid fa-print"style="color: rgba(0, 0, 0, 0.7);"></i>  </button> </div>
                </div>
            </div>
       

            
        </div>
    </div>
    <!-- Javascript file -->
    <script src="js/sidenav.js"></script>
</body>


</html>