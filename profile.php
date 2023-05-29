<?php
    session_start();

    if(!isset($_SESSION['activeUser'])){
        header('Location: login.php');
        exit();
    }

    if(isset($_POST['updateProfileSubmit'])) {
        $ID = $_SESSION['activeUser']['ID'];

        $phoneNumber = $_POST['phoneNumber'];
        $pattern_phone = '/^(3|6)[0-9]{7}$/';
        if(!preg_match($pattern_phone, $phoneNumber)) 
            die("Please enter a valid phoneNumber address");

        try {
            require('Database/connection.php');
            if($_SESSION['activeUser']['role'] == "student")
                $sql = $db->prepare("UPDATE students SET phoneNumber=? WHERE ID=?");
            else
                $sql = $db->prepare("UPDATE instructors SET phoneNumber=? WHERE ID=?");
            $sql->execute(array($phoneNumber, $ID));
            $db=null;
        }
        catch(PDOException $e) {
            die($e->getMessage());
        } 
    }

    try{
        require('Database/connection.php');
        $ID = $_SESSION['activeUser']['ID'];
        if($_SESSION['activeUser']['role'] == "student")
            $sql = $db->prepare("SELECT * FROM students WHERE ID=?");
        else
            $sql = $db->prepare("SELECT * FROM instructors WHERE ID=?");
        $sql->execute(array($_SESSION['activeUser']['ID']));
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
    <title>Profile</title>
    
    <link rel="stylesheet" href="generalstyling.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php 
            if($_SESSION['activeUser']['role'] == "Instructor" || $_SESSION['activeUser']['role'] == "HOD")
                $sidenav = "instr";
            else   
                $sidenav = "student";

            include('sidenav/' . $sidenav . '-sidenav.php');
            ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Profile Page</h1> 
            </div>
            <div class="container">
                <form method='post'>

                    <div class="row">
                        <td><h3>Enter Profile Information</h3></td>
                    </div>
                    <?php if($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>

                    <?php if($_SESSION['activeUser']['role'] == "student") { ?>

                    <div class="row">
                        <div class="col-25">
                            <label for="Name">Student ID</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="text"
                                value="<?php echo $row['studentID'];?>"
                                disabled
                            >
                        </div>
                    </div>

                    <?php 
                        }
                        else {
                    ?>

                    <div class="row">
                        <div class="col-25">
                            <label for="Name">Username</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="text"
                                value="<?php echo $row['username'];?>"
                                disabled
                            >
                        </div>
                    </div>

                    <?php } ?>

                    <div class="row">
                        <div class="col-25">
                            <label for="Name">Email Address</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="text"
                                value="<?php echo $row['emailAddress'];?>"
                                disabled
                            >
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Name">Full Name</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="text"
                                value="<?php echo $row['fullName'];?>"
                                disabled
                            >
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-25">
                            <label for="Course Name">Phone Number</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="text"
                                maxlength="20"
                                name="phoneNumber"
                                value="<?php echo $row['phoneNumber'];?>"
                                autocomplete="off"
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="row" id="submitDiv">
                        <input class="submitBtn" type="submit" value="Update Profile" name="updateProfileSubmit" />
                    </div>
                </form>
                <?php } ?>
                <form action="changepassword.php" method="post">
                <div class="row" id="submitDiv">
                    <input class="submitBtn" type="submit" value="Change Pass" name="changePasswordSubmit" />
                </div>
                </form>
                
            </div>
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>
</html>