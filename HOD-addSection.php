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
    
    <link rel="stylesheet" href="form.css">
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
                            <label for="Course ID">Course ID</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                name="courseID"
                                type="text"
                                maxlength="8"
                                autocomplete="off"
                                required
                                placeholder="ITCS489"
                            >
                        </div>
                    </div>

                    <div class="row">
                        <div class='col-25'>
                            <label for='Semester'>Semester</label>
                        </div>
                        <div class='col-75'>
                            <?php
                            // sql statement
                            $sql = "SELECT SemesterID, SemesterYear, SemesterNumber FROM semester ORDER BY SemesterID";
                            $rs = $db->query($sql);
                            
                            // <select>
                            echo "<select class='input-field' name='semester' >";
                            echo "<option disabled selected>Select Semester</option>";
                            
                            // loop through and display SemesterYear(s) and SemesterNumbers
                            foreach($rs as $option) {
                                // Get the ID of the selected semester
                            $semesterID = $option['SemesterID'];
                            echo "<option value='$semesterID'> ". $option['SemesterYear'] . " SEMESTER " . $option['SemesterNumber'] . "</option>";
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
                                    <select class='input-field' name='sectionDays[]' >
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
                                        name="sectionRoom[]"
                                        autocomplete="off"
                                        required
                                        placeholder="S40-049"
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
                                        $sql = "SELECT InstructorID, FullName FROM instructors ORDER BY InstructorID";
                                        $rs1 = $db->query($sql);
                                        
                                        // <select>
                                        echo "<select name='instructor[]' class='input-field'>";
                                        echo "<option disabled selected>Select instructor</option>";
                                    
                                        // loop through and display Instructors FullName
                                        foreach($rs1 as $option1) {
                                        // Get the ID of the selected Instructor
                                        $instructorID = $option1['InstructorID'];
                                        echo "<option value='$instructorID'> ". $option1['FullName'] . "</option>";
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
                $courseIDPattern = "/^[A-Z]{3,5}[0-9]{1,3}$/";
                $sectionTimePattern = "/^[0-2]\d:[0-5]\d:[0-5]\d$/";
                $sectionDaysPattern = "/^(UTH|UT|MW)$/";
                $sectionRoomPattern = "/^S[1-9]\d{1,2}-[0-4][0-9]{2,3}$/";

                try {
                    // Begin transaction
                    $db->beginTransaction();

                    // Insert into course_sections
                    $stmt = $db->prepare("INSERT INTO course_sections (SectionNumber, SectionStart, SectionEnd, SectionDays, SectionRoom, FinalDate, CourseID, SemesterID, SectionInstructor) 
                    VALUES (:sectionNumber, :sectionStart, :sectionEnd, :sectionDays, :sectionRoom, :finalDate, :courseID, :semesterID, :sectionInstructor)");
                    for ($i = 0; $i < count($_POST['sectionRoom']); $i++) {
                        $sectionNumber = $i+1;
                        $sectionStart = $_POST['startTime'][$i];
                        $sectionEnd = $_POST['endTime'][$i];
                        $sectionDays = $_POST['sectionDays'][$i];
                        $sectionRoom = $_POST['sectionRoom'][$i];
                        $finalDate = $_GET['finalDate'];
                        $courseID = $_GET['courseID'];
                        $semesterID = $_GET['semester'];
                        $sectionInstructor = $_POST['instructor'][$i];

                        // Check validation
                        if (!preg_match($courseIDPattern, $courseID)) 
                            die ("Invalid Course ID");
                        if (!preg_match($sectionTimePattern, $sectionStart)) 
                            die ("Invalid Start Time");
                        if (!preg_match($sectionTimePattern, $sectionEnd)) 
                            die ("Invalid End Time"); 
                        if (!preg_match($sectionDaysPattern, $sectionDays)) 
                            die ("Invalid Section Days");
                        if (!preg_match($sectionRoomPattern, $sectionRoom)) 
                            die ("Invalid Section Room");
                            
                        // Insert    
                        $stmt->bindParam(':sectionNumber', $sectionNumber);
                        $stmt->bindParam(':sectionStart', $sectionStart);
                        $stmt->bindParam(':sectionEnd', $sectionEnd);
                        $stmt->bindParam(':sectionDays', $sectionDays);
                        $stmt->bindParam(':sectionRoom', $sectionRoom);
                        $stmt->bindParam(':finalDate', $finalDate);
                        $stmt->bindParam(':courseID', $courseID);
                        $stmt->bindParam(':semesterID', $semesterID);
                        $stmt->bindParam(':sectionInstructor', $sectionInstructor);
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