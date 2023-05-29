<?php 
session_start();

if(!isset($_SESSION['activeUser'])){
    header('Location: login.php');
    exit();
}
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
            <?php include 'sidenav/instr-sidenav.php'; ?>
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
            <div class="instr-sched">
                <div class="semester-no">
                <?php
                    try {
                        require('Database/connection.php');
                        $db->beginTransaction();
                        //$currentTime=date('Y-m-d');
                        $semesterInfo="SELECT* from semester where now() BETWEEN semester.beginDate and semester.endDate";
                        $semester =$db->query($semesterInfo);
                        $semm=$semester->fetch();

                        $currentSections=$db->prepare('SELECT * from course_sections JOIN courses on course_sections.courseID=courses.ID WHERE semesterID=? and instructorID=?');
                        $currentSections->execute(array($semm['ID'], $_SESSION['activeUser']['ID']));                       
                        
                        echo "<h4 style='color: rgba(0, 0, 0, 0.45); font-weight: 600;'> Your Semester ".$semm['number'].", ".$semm['year']." Schedule: </h4>";
                    } catch (PDOException $e) {
                        $db->rollBack();
                        die("Error: " . $e->getMessage());
                    }
                    ?>
                </div>
                <div class="sched">
                    <?php 
                    $currentSched=$currentSections->fetchAll();

                    require('schedule.php');
                    yourInstrSched($currentSched);?>
                </div>
            </div>
            
            
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>