<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Section</title>
    
    <link rel="stylesheet" href="generalstyling.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Add Section</h1> 
            </div>
            <?php
            if(isset($_POST['numberOfSections']) && isset($_POST['semesterID']) && 
            isset($_POST['courseID']) && isset($_POST['finalDate'])) {

            if ($_POST['numberOfSections'] < 1)
                die("Please enter a valid number greater than or equal to 1.");

            $numOfSections = $_POST['numberOfSections'];
            $semesterID = $_POST['semesterID'];
            $courseID = $_POST['courseID'];
            $finalDate = $_POST['finalDate'];
            ?>

            <form method='post' action='HOD-e2.php'>
                
                <div class='row'>
                    <h1></h1>
                </div>

                <div class='row'>
                    <td><h3>Enter Sections Details</h3></td>
                </div>

                <?php
                for ($i = 1; $i <= $numOfSections; $i++) {
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
                                    // <select>
                                    echo "<select name='instructorID[]' class='input-field'>";
                                    echo "<option disabled selected>Select instructor</option>";

                                    try {
                                        require('Database/connection.php');
                                        $sql = "SELECT ID, fullName FROM instructors ORDER BY departmentID";
                                        $rs2 = $db->query($sql);
                                        $db=null;
                                    }
                                    catch(PDOException $e) {
                                        die($e->getMessage());
                                    }
                                    
                                    // loop through and display Instructors FullName
                                    foreach($rs2 as $option2) {
                                    // Get the ID of the selected Instructor
                                    $instructorID = $option2['ID'];
                                    echo "<option value='$instructorID'> ". $option2['fullName'] . "</option>";
                                    }
                                    echo "</select>";
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
                <input type="hidden" name="finalDate" value="<?php echo $finalDate ?>">
                <input type="hidden" name="semesterID" value="<?php echo $semesterID ?>"> 
                <input type="hidden" name="courseID" value="<?php echo $courseID ?>">  
                    
                <div class="row" id="submitDiv">
                    <input 
                        class="submitBtn"
                        name="addSectionsSubmit"
                        type="submit"
                        value="Add Sections"
                    />
                </div>
                </form>
        </div>
    <?php
    }
    else {
        header('location: HOD-addSection.php');
    }
    ?>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>
</html>


