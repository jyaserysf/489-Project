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
    <title>Create a course</title>
    
    <link rel="stylesheet" href="generalstyling.css">

    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Create a new course</h1> 
            </div>

            <div class="container">
                
                <form method='post'>

                    <div class="row">
                        <td><h3>Enter Course Information</h3></td>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Course Code">Course Code</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="text"
                                name="courseCode"
                                maxlength="8"
                                autocomplete="off"
                                required
                                placeholder="ITCS489"
                            >
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-25">
                            <label for="Course Name">Course Name</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="text"
                                maxlength="50"
                                name="courseName"
                                autocomplete="off"
                                required
                                
                                placeholder="Software Engineering"
                            >
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-25">
                            <label for="Credit Hours">Credit Hours</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="number"
                                min="2"
                                max="4"
                                name="creditHours"
                                autocomplete="off"
                                required
                                placeholder="3"
                            >
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-25">
                            <label for="PreRequisites">PreRequisites</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="text"
                                name="preRequisites"
                                maxlength="100"
                                autocomplete="off"
                                required
                                placeholder="ITCS285, ITCS389"
                            >
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-25">
                            <label for="Course Department">Course Department</label>
                        </div>
                        <div class="col-75">
                            
                            <?php
                            // sql statement
                            $sql = "SELECT ID, name FROM departments ORDER BY college";
                            $rs = $db->query($sql);
                            
                            // <select>
                            echo "<select name='departmentName' class='input-field'>";
                            echo "<option disabled selected>Select Department</option>";
                           
                            // loop through and display DepartmentName(s)
                            foreach($rs as $option) {
                            // Get the ID of the selected department
                            $departmentID = $option['ID'];
                            echo "<option value='$departmentID'>" . $option['name'] . " Department </option>";
                            }
                            
                            echo "</select>";
                            ?>

                        </div>
                    </div>
                    
                    <div class="row" id="submitDiv">
                        <input class="submitBtn" type="submit" value="Create Course" name="createCourseSubmit" />
                    </div>

                </form>
            </div>

            <?php
            if (isset($_POST['createCourseSubmit'])) {

            $courseCode = $_POST['courseCode'];
            $courseName = $_POST['courseName'];
            $creditHours = $_POST['creditHours'];
            $preRequisites = $_POST['preRequisites']; 
            $departmentName = $_POST['departmentName'];
            
            // Regular Expressions to validate
            $courseCodePattern = "/^[A-Z]{3,5}[0-9]{1,3}$/";
            $courseNamePattern = "/^[A-Z]{1}[a-zA-Z0-9]{1,49}$/";
            $creditHoursPattern = "/^[2-4]{1}$/";
            $preRequisitesPattern = "/^[A-Z]{3,5}[0-9]{1,3},?$/";

            if(!preg_match($courseCodePattern, $courseCode))
                die ("Invalid Course ID");
            if(!preg_match($courseNamePattern, $courseName))
                die ("Invalid Course Name");
            if(!preg_match($creditHoursPattern, $creditHours))
                die ("Invalid Credit Hours");
            if(!preg_match($preRequisitesPattern, $preRequisites))
                die ("Invalid PreRequisites");

            try {
                // Begin transaction
                $db->beginTransaction();

                // Insert into courses
                $stmt = $db->prepare("INSERT INTO courses (courseCode, courseName, creditHours, preRequisites, courseDepartment) 
                VALUES (:courseCode, :courseName, :creditHours, :preRequisites, :courseDepartment)");
                $stmt->bindParam(':courseCode', $courseCode);
                $stmt->bindParam(':courseName', $courseName);
                $stmt->bindParam(':creditHours', $creditHours);
                $stmt->bindParam(':preRequisites', $preRequisites);
                $stmt->bindParam(':courseDepartment', $departmentName);
                $stmt->execute();

                // commit transaction
                $db->commit();

                // close the connection
                $db = null;

                echo "<h2>New Course added successfully!</h2>";
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