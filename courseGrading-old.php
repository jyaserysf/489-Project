<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Grading</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="courseGrading.css">
</head>
<body>
    <?php include 'sidenav-only.html'; ?>
   
    <div class="content px-5 py-4">
     
       <h1 class=" px-4 py-4">Course Grading</h1>
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
                    <tr> <th style="width: 8%"> ID </th> <th style="width: 10%"> Name </th>  <th class="w-25" >Grade</th> </tr>
                    <tr>  <td> 2019XXXX</td> <td> SName </td> 
                         <td >  
                         <select class="form-select border-secondary-subtle" style="width: 10%" aria-label="Default select example">
                         <option selected>  </option>
                         <option value="1">A</option>
                         <option value="2">A-</option>
                         <option value="3">B+</option>
                         <option value="3">B-</option>
                         </select> </td> 
                    </tr>
                </table>
            </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>