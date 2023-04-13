<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Grading</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="courseReg.css">
</head>
<body>
<div class="content-wrapper px-5 py-4">
     
       <h1 class=" mb-lg-5 mb-4">Course Registeration</h1>
       <div class="row row-cols-1 row-cols-lg-4" id="student-info">
          <?php  echo
           '<div class="col col-lg-4  ">Student Name: Jood Yaser AlYusuf </div>
            <div class="col col-lg-3">Major: Computer Science </div>
            <div class="col col-lg-2">Credit Hours: 76</div>
            <div class="col ">Semester: 2022/2023 </div>'; ?>
       </div>
       <div class="row my-3 " id="course-section">
            <form action="" method="get">
                <div class="col">
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
                <div class="col my-2" id="selectsection">
                    <span> Section: </span> 

                </div>
            </form>
            <div class=" col my-2">
                <div class="row"> </div>
            </div>
       </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>