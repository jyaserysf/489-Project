<?php
try {
    require('Database/connection.php');
    // course options sql statement
    $sql = "SELECT courses.courseCode, courses.courseName
            FROM courses
            JOIN course_sections
            ON courses.ID = course_sections.courseID 
            WHERE course_sections.courseID IS NOT NULL 
            GROUP BY courses.courseCode
            ORDER BY courses.ID";
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
                <h1>Manage Courses</h1> 
            </div>
            
            <div class="container">
                <form method='get'>
                    <div class="row">
                        <h3>Select course to manage</h3>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Course ID">Course</label>
                        </div>
                        <div class="col-75">
                        <?php        
                            // <select>
                            echo "<select class='input-field' name='courseID' >";
                            echo "<option disabled selected>Select Course</option>";
                            
                            // loop through and display SemesterYear(s) and SemesterNumbers
                            foreach($rs as $option) {
                                // Get the ID of the selected semester
                            $courseID = $option['ID'];
                            echo "<option value='$courseID'> ". $option['courseCode'] . " | " . $option['courseName'] . "</option>";
                            }

                            echo "</select>";
                        ?>
                        </div>
                    </div>
                </form>
                
                <div class="row">
                    <div class="row-flex">
                        <button id="btn1" class="manageBtn">Show div 1</button>
                        <button id="btn2" class="manageBtn">Show div 2</button>
                        <button id="btn3" class="manageBtn">Show div 3</button>
                    </div>
                </div> 
            </div>
            <h1></h1>
            
            <div id="div1" class="content hidden">Div 1 content</div>
            <div id="div2" class="content hidden">Div 2 content</div>
            <div id="div3" class="content hidden">Div 3 content</div>

        </div>
    </div>

    
    <!-- Javascript file -->
    <script src="js/sidenav.js"></>
</body>
</html>