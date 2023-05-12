<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GPA calc </title>
    <link rel="stylesheet" href="generalstyling.css">
    <link rel="stylesheet" href="css/GPAcalc.css">

</head>

<body>

    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.html'; ?>
        </div>

        <!-- Page content -->

        <div class="pagecontent-wrapper" id="main">
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

                                    </tbody>
                        </table>
                    </div>
                </div>
                <div class="bu">
                    <button type="button" class="light-btn">Calcualte GPA </button>
                </div>
        </div>
    </div>

</body>

<!-- Javascript file -->
<script src="js/sidenav.js"></script>

</html>