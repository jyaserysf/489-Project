
    <div id="mySidenav" class="sidenav">
        <div id="sidenav-head"  > 
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        
        <div class="logo"><img src="./img/logo.png" alt="University">
            <h4>University</h4>
        </div>
        </div>
          

        
        <?php 
        if($_SESSION['activeUser']['role'] == "HOD"){
            echo"
            <div class='sideElement' >
            <img id='icon' src='icons/house.svg' alt=''>
            <a href='HOD-homep.php'>Home</a>
            </div>
            <div class='sideElement'>
            <img id='icon' src='icons/calendar-plus.svg' alt=''>
            <a href='courseGrading.php'>Grading</a>
            </div>
            
            <div class='sideElement'>
                <img id='icon' src='icons/exam.svg' alt=''>
                <a href='instr-attendance.php'>Attendance</a>
            </div>

            <div class='sideElement'>
                <img id='icon' src='icons/calculator.svg' alt=''>
                <a href='courseList.php'>Course List</a>
            </div>

            <div class='sideElement'>
                <img id='icon' src='icons/tray.svg' alt=''>
                <a href='HOD-manageCourses.php'>Manage Courses</a>
            </div>
            ";
        }elseif($_SESSION['activeUser']['role'] == "Instructor"){
            echo "
            <div class='sideElement' >
            <img id='icon' src='icons/house.svg' alt=''>
            <a href='instructor-homep.php'>Home</a>
            </div>
            <div class='sideElement'>
            <img id='icon' src='icons/calendar-plus.svg' alt='>
            <a href='courseGrading.php'>Grading</a>
            </div>
            
            <div class='sideElement'>
                <img id='icon' src='icons/exam.svg' alt=''>
                <a href='instr-attendance.php'>Attendance</a>
            </div>
        
            
            <div class='sideElement'>
                <img id='icon' src='icons/calendar-blank.svg'>
                <a href='advisingList.php'>Advising List</a>
            </div>
            
            ";

        }
        ?>
        <div id="spacing">

        </div>

        <div id="sidenav-footer">
        <div> <a href="#">Profile</a> 
            <?php if (isset($_SESSION['activeUser'])) {
                echo " 
                <a href='#' onclick='logout()'> <i class='fa fa-sign-out'> </i> Logout </a>
                ";
              }?>
                </div>
            <div> <a href="#">Contact Us</a></div>
        </div>
    </div>
      
    <!-- Use any element to open the sidenav -->
    <button onclick="openNav()" id="openbtn">  <img id="icon" src="icons/house.svg" alt=""> </button>
    <script>
                function logout() {
                    // send AJAX request to the server to destroy the session
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'logout.php');
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {
                        // redirect the user to homepage
                        window.location.href = 'login.php';
                    };
                    xhr.send();
                }
                </script>
    

 
