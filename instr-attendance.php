<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance </title>
    <link rel="stylesheet" href="generalstyling.css">
    <link rel="stylesheet" href="css/Attendance_instractor.css">
    

</head>

<body>

<div class="wrapper">
    <div class="sidebar-wrapper">
            <?php include 'sidenav/instr-sidenav.html'; ?>
        </div>

    <!-- Page content -->

    <div class="pagecontent-wrapper" id="main">
        
            <div class="row row-col-6 ">
                <div class="col-4">
                    <div class="row ms-3 d-inline p-2 ">
                        <h3>Semester:20XX/20XX</h3>
                        <form action="" method="get">
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
                        </form>
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
                        <form method="post"></form>
                            <tbody>
                                <?php  ?>
                                <tr class="student">
                                    <td class="name-col"> XXXXXXXXXXXX XXXXXXXXXXXXX </td>
                                    <td class="ID-col"> 202XXXXXXXX </td>
                                    <td class="attend-col"><input type="checkbox" ></td>
                                    <td class="missed-col">0</td>
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

</div>

   <!-- Javascript file -->
   <script src="js/sidenav.js"></script>

      


</body>