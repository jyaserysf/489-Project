<?php
if(isset($_GET['courseID']))
    $courseID = $_GET['courseID'];
else
    die("No Course Selected");
try {
    require('Database/connection.php');
    // course options sql statement
    $sql = "SELECT * FROM course_sections WHERE courseID='$courseID'";
    $rs = $db->query($sql);

    $db = null;
} catch (PDOException $e) {
    die($e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="generalstyling.css">

    <style>
        .row-flex {
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
            margin: 0 20px;
        }

        .manageBtn {
            width: 10rem;
            height: 4rem;
            background-color:rgba(0, 0, 0, 0.8);
            color: #fff;
            border: none;
            padding: 12px 20px;
            /*finger*/
            cursor: pointer;
            float: right;
            border-radius: 5px;
            font-size: 1rem;
            transition: 0.3s;
            margin: 0 10px 0 10px;
        }

        .manageBtn:hover {
        background-color: #A0BCC2;
        }

        .hidden {
        display: none;
        }

        .content {
            border-radius: 5px;
            background-color: #f4f1de /* rgba(236, 232, 221, 0.7)*/;
            padding: 20px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('button');
        const divs = document.querySelectorAll('.content');

        buttons.forEach((button) => {
            button.addEventListener('click', function () {
            const targetDivId = this.id.replace('btn', 'div');
            const targetDiv = document.getElementById(targetDivId);

            divs.forEach((div) => {
                div.classList.toggle('hidden', div !== targetDiv);
            });
            });
        });
        });
    </script>   

</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/hod-sidenav.html'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Manage Sections</h1> 
            </div>
            
            <div class="container">
                <form method='get' action='HOD-e5.php'>
                    <div class="row">
                        <h3>Select A Section To Manage</h3>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Course ID">Section</label>
                        </div>
                        <div class="col-75">
                        <?php        
                            // <select>
                            echo "<select class='input-field' name='sectionID' >";
                            echo "<option disabled selected>Select Section</option>";
                            // loop through and display SemesterYear(s) and SemesterNumbers
                            foreach($rs as $option) {
                                // Get the ID of the selected semester
                            $sectionID = $option['ID'];
                            echo "<option value='$sectionID'";
                            
                            if(isset($_GET['sectionID']) && $sectionID == $_GET['sectionID']) {
                                echo "selected";
                            }
                            echo "> ". $option['sectionNumber'] . ":  " . $option['startTime'] . "-" . $option['endTime'] . "</option>";
                            }

                            echo "</select>";
                        ?>
                        </div>
                    </div>

                    <div class="row" id="submitDiv">
                        <input class="submitBtn" type="submit" value="Manage Section" />
                    </div>

                </div> 
                </form>
                
                <div class="row">
                    <div class="row-flex">
                        <button id="btn1" class="manageBtn">Add New Section</button>
                        <!-- <button id="btn2" class="manageBtn">Update Section</button>
                        <button id="btn3" class="manageBtn">Delete Section</button> -->
                    </div>
                </div> 
            </div>
            <h1></h1>
            
            <div id="div1" class="content hidden">
                <?php
                if(isset($courseID))
                    require('HOD-addSection.php');
                else
                    // POP-UP Error Message: PLease Select A Course To Add A Section To 
                ?>
            <!-- </div>

                <?php 
                // if(isset($courseID) && isset($sectionID))
                //     require('HOD-updateSection.php');
                // else
                    // POP-UP Error Message: PLease Select A Section To Update 
                ?>
            </div>

            <div id="div3" class="content hidden">
                <?php
                // if(isset($courseID) && isset($sectionID))
                //     require('HOD-deleteSection.php');
                // else
                    // POP-UP Error Message: PLease Select A Section To Delete 
                ?>
            </div>  -->

        </div>
    </div>

    
    <!-- Javascript file -->
    <script src="js/sidenav.js"></>
</body>
</html>