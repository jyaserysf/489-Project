<?php 
    try{
        require('Database/connection.php');
        // course options sql statement
        $sql = "SELECT ID, courseCode, courseName FROM courses ORDER BY ID";
        $rs = $db->query($sql);

        // semester options sql statement
        $sql = "SELECT ID, year, number FROM semester ORDER BY ID";
        $rs1 = $db->query($sql);

        $db=null;
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
    <title>Add Sections</title>
    <link rel="stylesheet" href="generalstyling.css">
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/hod-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Add Sections</h1> 
            </div>

            <div class="container">

                <form method='post' action='HOD-e1.php'>
                    <div class="row">
                        <h3>Enter Sections Information</h3>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Course ID">Course Code</label>
                        </div>
                        <div class="col-75">
                        <?php        
                            // <select>
                            echo "<select class='input-field' name='courseID' >";
                            echo "<option disabled selected>Select Course</option>";
                            
                            // loop through and display courses Code and name
                            foreach($rs as $option) {
                                // Get the ID of the selected course
                            $courseID = $option['ID'];
                            echo "<option value='$courseID'> ". $option['courseCode'] . "  " . $option['courseName'] . "</option>";
                            }

                            echo "</select>";
                        ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class='col-25'>
                            <label for='Semester'>Semester</label>
                        </div>
                        <div class='col-75'>
                            <?php
                            // <select>
                            echo "<select class='input-field' name='semesterID' >";
                            echo "<option disabled selected>Select Semester</option>";
                            
                            // loop through and display SemesterYear(s) and SemesterNumbers
                            foreach($rs1 as $option1) {
                                // Get the ID of the selected semester
                            $semesterID = $option1['ID'];
                            echo "<option value='$semesterID'> ". $option1['year'] . " SEMESTER " . $option1['number'] . "</option>";
                            }

                            echo "</select>";
                            ?>
                        </div>
                    </div>

                    <div class='row'>
                        <div class='col-25'>
                            <label for='Final Date'>Final Date</label>
                        </div>
                        <div class='col-75'>
                            <input 
                                class='input-field'
                                name='finalDate'
                                type='date'
                                autocomplete='off'
                                required
                            />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Number of Sections">Number of Sections</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                name="numberOfSections"
                                type="number"
                                min="1"
                                max="10"
                                autocomplete="off"
                                required
                                placeholder=""
                            />
                        </div>
                    </div>

                    <div class="row" id="submitDiv">
                        <input 
                            class="submitBtn"
                            name="sectionInfoSubmit"
                            type="submit"
                            value="Go"
                        />
                    </div>
                </form>

            </div>
        </div>
    </div>
    
    <!-- Javascript file -->
    <script src="js/sidenav.js"></script>
</body>
</html>