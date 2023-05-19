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
    <title>Add Sections</title>
    
    <link rel="stylesheet" href="generalstyling.css">

    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Add Sections</h1> 
            </div>

            <div class="container">

                <form method='get'>
                    <div class="row">
                        <h3>Enter Sections Information</h3>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Course ID">Course Code</label>
                        </div>
                        <div class="col-75">
                        <?php
                            // sql statement
                            $sql = "SELECT ID, courseCode, courseName FROM courses ORDER BY ID";
                            $rs = $db->query($sql);
                            
                            // <select>
                            echo "<select class='input-field' name='courseID' >";
                            echo "<option disabled selected>Select Course</option>";
                            
                            // loop through and display SemesterYear(s) and SemesterNumbers
                            foreach($rs as $option) {
                                // Get the ID of the selected semester
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
                            // sql statement
                            $sql = "SELECT ID, year, number FROM semester ORDER BY ID";
                            $rs1 = $db->query($sql);
                            
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
                                placeholder="2"
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

            <?php
            if (isset($_GET['sectionInfoSubmit']) && $_GET['numberOfSections'] > 0) {
            ?>

                <form method='post'>
                    <!-- space -->
                    <div class='row'>
                        <h1></h1>
                    </div>

                    <div class='row'>
                        <td><h3>Enter Sections Details</h3></td>
                    </div>

                    <?php
                    for ($i = 1; $i <= $_GET['numberOfSections']; $i++) {
                    ?>
                        <div class='container'>

                            <div class='row'>
                                <?php
                                echo "<h4>Section ". $i ."</h4>";
                                ?>
                            </div>
                        

                            <div class='row'>
                                <div class='col-25'>
                                    <label for='Start Time'>Start Time</label>
                                </div>
                                <div class='col-75'>
                                    <input 
                                        class='input-field'
                                        name='startTime[]'
                                        type='time'
                                        autocomplete='off'
                                        required
                                        placeholder=''
                                    />
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-25'>
                                    <label for='End Time'>End Time</label>
                                </div>
                                <div class='col-75'>
                                    <input 
                                        class='input-field'
                                        name='endTime[]'
                                        type='time'
                                        autocomplete='off'
                                        required
                                        placeholder=''
                                    />
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-25'>
                                    <label for='Section Days'>Section Days</label>
                                </div>
                                <div class='col-75'>
                                    <select class='input-field' name='days[]' >
                                        <option disabled selected>Select Section Days</option>
                                        <option value='UTH'>UTH</option>
                                        <option value='UT'>UT</option>
                                        <option value='MW'>MW</option>
                                    </select>
                                </div>
                            </div> 

                            <div class='row'>
                                <div class='col-25'>
                                    <label for='Room'>Room</label>
                                </div>
                                <div class='col-75'>
                                    <input 
                                        class="input-field"
                                        type="text"
                                        maxlength="10"
                                        name="room[]"
                                        autocomplete="off"
                                        required
                                        placeholder="S40-049"
                                    >
                                </div>
                            </div>

                            <div class='row'>
                                <div class='col-25'>
                                    <label for='Room'>Number of Seats</label>
                                </div>
                                <div class='col-75'>
                                    <input 
                                        class="input-field"
                                        type="number"
                                        min="1"
                                        max="35"
                                        name="seats[]"
                                        autocomplete="off"
                                        required
                                        placeholder=""
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <div class='col-25'>
                                    <label for='fname'>Instructor</label>
                                </div>
                                <div class='col-75'>
                                    <?php
                                    try {
                                        // sql statement
                                        $sql = "SELECT ID, fullName FROM instructors ORDER BY departmentID";
                                        $rs2 = $db->query($sql);
                                        
                                        // <select>
                                        echo "<select name='instructorID[]' class='input-field'>";
                                        echo "<option disabled selected>Select instructor</option>";
                                    
                                        // loop through and display Instructors FullName
                                        foreach($rs2 as $option2) {
                                        // Get the ID of the selected Instructor
                                        $instructorID = $option2['ID'];
                                        echo "<option value='$instructorID'> ". $option2['fullName'] . "</option>";
                                        }
                                        
                                        echo "</select>";
                                    } catch (PDOException $e) {
                                        die("Error: " . $e->getMessage());
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- spaces between section containers -->
                            <div class='row'>
                                <h1></h1>
                            </div>
                            <div class='row'>
                                <h1></h1>
                            </div>
                        <?php
                        } // end for
                        ?>
                    </div>
                        
                    <div class="row" id="submitDiv">
                        <input 
                            class="submitBtn"
                            name="addSectionsSubmit"
                            type="submit"
                            value="Add Sections"
                        />
                    </div>
                </form
            <?php
            } // end if
            ?>

            <?php
            if (isset($_GET['sectionInfoSubmit']) && isset($_POST['addSectionsSubmit'])) {
                
                // Regular Expressions to validate

                try {
                    // Begin transaction
                    $db->beginTransaction();

                    // Insert into course_sections
                    $stmt = $db->prepare("INSERT INTO course_sections (ID, semesterID, courseID, sectionNumber, startTime, endTime, days, room, availableSeats, finalDate, instructorID) 
                    VALUES (:ID, :semesterID, :courseID, :sectionNumber, :startTime, :endTime, :days, :room, :availableSeats, :finalDate, :instructorID)");
                    for ($i = 0; $i < count($_POST['room']); $i++) {
                        $ID = null;
                        $semesterID = $_GET['semesterID'];
                        $courseID = $_GET['courseID'];
                        $sectionNumber = $i+1;
                        $startTime = $_POST['startTime'][$i];
                        $endTime = $_POST['endTime'][$i];
                        $days = $_POST['days'][$i];
                        $room = $_POST['room'][$i];
                        $availableSeats = $_POST['seats'][$i];
                        $finalDate = $_GET['finalDate'];
                        $instructorID = $_POST['instructorID'][$i];
                        
                            
                        // Insert    
                        $stmt->bindParam('ID:', $ID);
                        $stmt->bindParam(':semesterID', $semesterID);
                        $stmt->bindParam(':courseID', $courseID);
                        $stmt->bindParam(':sectionNumber', $sectionNumber);
                        $stmt->bindParam(':startTime', $startTime);
                        $stmt->bindParam(':endTime', $endTime);
                        $stmt->bindParam(':days', $days);
                        $stmt->bindParam(':room', $room);
                        $stmt->bindParam(':availableSeats', $availableSeats);
                        $stmt->bindParam(':finalDate', $finalDate);
                        $stmt->bindParam(':instructorID', $instructorID);
                        $stmt->execute();
                    }

                    // commit transaction
                    $db->commit();

                    // close the connection
                    $db = null;

                    echo "<h2>Section(s) has been added successfully!</h2>";

                } catch (PDOException $e) {
                    die("Error: " . $e->getMessage());
                }
            }
            ?>
        </div>
    </div>
    
    <!-- Javascript file -->
    <script src="js/sidenav.js"></script>
</body>