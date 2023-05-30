<?php
    session_start();

    if(!isset($_SESSION['activeUser'])){
        header('Location: login.php');
        exit();
    }

    if(isset($_SESSION['activeUser'])) {
        if($_SESSION['activeUser'] == "instructor")
            header('location: instructor-homep.php');
        elseif($_SESSION['activeUser'] == "admin")
            //header('location:');
            echo "admin";
    }
    else {
        header('location: login.php');
    }
    try{
        require('Database/connection.php');
    }
    catch(PDOException $e){
        die($e->getMessage());
        }
//print_r($_SESSION['activeUser']); 
//echo $_SESSION['activeUser']['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    
    <link rel="stylesheet" href="generalstyling.css">

</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php include 'sidenav/student-sidenav.php'; ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <?php
                try {
                    require('Database/connection.php');
                    $ID = $_SESSION['activeUser']['ID'];
                    if($_SESSION['activeUser']['role'] == "admin")
                        $sql = $db->prepare("SELECT * FROM admins WHERE ID=?");
                    elseif($_SESSION['activeUser']['role'] == "student")
                        $sql = $db->prepare("SELECT * FROM students WHERE ID=?");
                    else
                        $sql = $db->prepare("SELECT * FROM instructors WHERE ID=?");
                    $sql->execute(array($_SESSION['activeUser']['ID']));
                    $db=null;


                }
                catch(PDOException $e) {
                    die($e->getMessage());
                } ?>

                <?php if($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>
                <h1>Welcome <?php echo $row['fullName'];?></h1> 
                <?php } ?>
            </div>
            <div class="student-sched">
                <div class="semester-no">
                   
                    <?php 
                    try{
                        require('Database/connection.php');
                        $db->beginTransaction();
                        //$currentTime=date('Y-m-d');
                        $semesterInfo="SELECT* from semester where now() BETWEEN semester.beginDate and semester.endDate";
                        $semester =$db->query($semesterInfo);
                        $semm=$semester->fetch();

                        
                        echo "<h4 style='color: rgba(0, 0, 0, 0.45); font-weight: 600;'> Your Semester ".$semm['number'].", ".$semm['year']." Schedule: </h4>";
                         
                       echo " 
                        </div>
                        <div class='sched'>";
                        $takingSectionsthisSem=$db->prepare("SELECT enrollments.* , course_sections.*, semester.* from enrollments join course_sections on enrollments.sectionID=course_sections.ID join semester on course_sections.semesterID=semester.ID where semester.ID=? and enrollments.studentID=?");
                        $stID=$_SESSION['activeUser']['ID'];
                        

                        $takingSectionsthisSem->execute(array($semm['ID'],$stID));
                        $enrollsectSemALL=$takingSectionsthisSem->fetchAll();
                        $db->commit();
                        $db=null;
                    }catch(PDOException $e){
                        $db->rollBack();
                        die("Error: " . $e->getMessage());
                      }
                    require('schedule.php');
                    yourSched($enrollsectSemALL);?>
                </div>
            </div>
            
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>