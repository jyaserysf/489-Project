<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance </title>
    <link rel="stylesheet" href="css/Attendance_instractor.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>

<body>

    <!-- The sidebar -->
    <div class="sidebar">
        
        <div class="logo"><img src="./img/logo.png" alt="University"><h4>University</h4></div>
        
        <div class="sideElement" id="active">
            <img id="icon" src="icons/house.svg" alt="">
            <a href="#home">Home</a>
        </div>

        <div class="sideElement">
            <img id="icon" src="icons/calendar-plus.svg" alt="">
            <a href="#">view Schedule </a>
        </div>
        
        <div class="sideElement">
            <img id="icon" src="icons/exam.svg" alt="">
            <a href="#">student Grades</a>
        </div>
       
        <div class="sideElement">
            <img id="icon" src="icons/user.svg" alt="">
            <a href="#"> student Attendance</a>
        </div>
        
    
        
        <div class="sideElement">
            <img id="icon" src="icons/tray.svg" alt="">
            <a href="#">Requests</a>
        </div>

        <div class="footer"><a href="#">Help</a><a href="#">Contact Us</a></div>

    </div>

    <!-- Page content -->

    <div class="content">
        <form action="" method="get">
            <div class="row row-col-6 ">
                <div class="col-4">

                    <div class="row ms-3 d-inline p-2 ">
                        <h3>Semester:20XX/20XX</h3>
                        <div class="selection">

                            <select class="form-select border-secondary-subtle w-75 me-1"
                                aria-label="Default select example">
                                <br>
                                <option selected>Course</option>
                                <option value="1"> Software Engeenring 2 -ITCS 489</option>
                                <option value="2">Software Engeenring 1 - ITCS389</option>
                                <option value="3">introduction to Software Engeenring - ITSE201</option>
                            </select>



                            <select class="form-select border-secondary-subtle" style="width: 40%"
                                aria-label="Default select example">
                                <option selected>Section</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                <option value="3">Four</option>
                            </select>
                        </div>
                    </div>
                </div>



                <table>
                    <thead>

                        <tr>
                            <th class="name-col">Student Name</th>
                            <th>Student ID </th>
                            <th>absent </th>
                            <th> absent number </th>
                            <th>absent Percentage </th>

                        </tr>
                    </thead>


                    <div class="parent-container">

                        <div class="table-container">

                            <tbody>
                                <tr class="student">
                                    <td class="name-col"> XXXXXXXXXXXX XXXXXXXXXXXXX </td>
                                    <td class="ID-col"> 202XXXXXXXX </td>
                                    <td class="attend-col"><input type="checkbox"></td>
                                    <td class="missed-col">0</td>
                                </tr>

                                </tr>
                            </tbody>
                </table>




                <div class="bu">
                    <button type="button" class="btn btn-light">Save</button>
                    <button type="button" class="btn btn-light">Reset</button>
            </div>


    </div>

    </div>

    </div>
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

      


</body>