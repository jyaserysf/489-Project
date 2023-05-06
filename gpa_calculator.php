<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPA calc </title>

    <link rel="stylesheet" href="css/GPAcalc.css">

</head>

<body>

    <!-- The sidebar -->
    <div class="sidebar">

        <div class="logo"><img src="./img/logo.png" alt="University">
            <h4>University</h4>
        </div>

        <div class="sideElement">
            <img id="icon" src="icons/house.svg" alt="">
            <a href="#home">Home</a>
        </div>

        <div class="sideElement">
            <img id="icon" src="icons/calendar-plus.svg" alt="">
            <a href="#">Course Registration</a>
        </div>

        <div class="sideElement">
            <img id="icon" src="icons/exam.svg" alt="">
            <a href="#">Grades</a>
        </div>

        <div class="sideElement">
            <img id="icon" src="icons/user.svg" alt="">
            <a href="#">Attendance</a>
        </div>

        <div class="sideElement">
            <img id="icon" src="icons/calendar-blank.svg">
            <a href="#">Schedule Planner</a>
        </div>

        <div class="sideElement" id="active">
            <img id="icon" src="icons/calculator.svg" alt="">
            <a href="#">GPA Calculater</a>
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

<h3>202X-202X</h3>
<h3>XXXXXXXX XXXXXX</h3> <!--student name-->



                    <table>
                        <thead>

                            <tr>
                                <th class="name-col">Course code</th>
                                <th> Course Title</th>
                                <th>CH </th>

                                <th>Grade </th>

                            </tr>
                        </thead>


                        <div class="parent-container">

                            <div class="table-container">

                                <tbody>
                                    <tr class="courses ">
                                        <td class="CID-col"> ITCS489 </td>
                                        <td class="CName-col"> SE2 </td>
                                        <td class="CH-col">3 </td>
                                        <td class="GRADE-col">


                                            <select class="form-select border-secondary-subtle w-75 me-1 light-select"
                                                aria-label="Default select example">
                                                <br>
                                                <option selected> Grade</option>
                                                <option value="1"> A</option>
                                                <option value="2">A-</option>
                                                <option value="3">B+</option>
                                                <option value="4"> B</option>
                                                <option value="5">B-</option>
                                                <option value="6">C+</option>
                                                <option value="7"> C</option>
                                                <option value="8">C-</option>
                                                <option value="9">D+</option>
                                                <option value="10">D</option>
                                                <option value="11">F</option>





                                            </select>

                                        </td>
                                    </tr>

                                    </tr>




                                </tbody>

                    </table>




                </div>
               

            </div>
            <div class="bu">
                <button type="button" class="light-btn">Calcualte GPA </button>
            </div>
    </div>


  
    </div>
    </div>


</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
crossorigin="anonymous"></script>


</html>