<?php
    session_start();

    if(!isset($_SESSION['activeUser'])){
        header('Location: login.php');
        exit();
    }

    if(isset($_POST['changePassword'])) {
        $ID = $_SESSION['activeUser']['ID'];

        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        $pattern_password = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_#@%\*\-.!$^?])[A-Za-z0-9_#@%.!$^\*\-?]{8,24}$/';
        if(!preg_match($pattern_password, $newPassword))
            die("Please enter a valid password");

        try {
            require('Database/connection.php');
            if($_SESSION['activeUser']['role'] == "admin")
                $sql = $db->prepare("SELECT * FROM admins WHERE ID=?");
            elseif($_SESSION['activeUser']['role'] == "student")
                $sql = $db->prepare("SELECT * FROM students WHERE ID=?");
            else
                $sql = $db->prepare("SELECT * FROM instructors WHERE ID=?");
            $sql->execute(array($ID));
            $db=null;
        }
        catch(PDOException $e) {
            die($e->getMessage());
        }

        if($row = $sql->fetch()) {
            if(password_verify($oldPassword,$row['password'])) {
                if($newPassword != $confirmPassword)
                    die("New Password and Confirm Password do not match!");
                $hps = password_hash($newPassword, PASSWORD_DEFAULT);
                try {
                    require('Database/connection.php');
                    if($_SESSION['activeUser']['role'] == "admin")
                        $sql = $db->prepare("UPDATE admins SET password=? WHERE ID=?");
                    elseif($_SESSION['activeUser']['role'] == "student")
                        $sql = $db->prepare("UPDATE students SET password=? WHERE ID=?");
                    else
                        $sql = $db->prepare("UPDATE instructors SET password=? WHERE ID=?");
                    $sql->execute(array($hps, $ID));
                    $db=null;
                    header('location: profile.php');
                }
                catch(PDOException $e) {
                    die($e->getMessage());
                } 
            }
            else
                die("Incorrect Old Password");
        }
    }

    // try{
    //     require('Database/connection.php');
    //     $ID = $_SESSION['activeUser']['ID'];
    //     if($_SESSION['activeUser']['role'] == "admin")
    //         $sql = $db->prepare("SELECT * FROM admins WHERE ID=?");
    //     elseif($_SESSION['activeUser']['role'] == "student")
    //         $sql = $db->prepare("SELECT * FROM students WHERE ID=?");
    //     else
    //         $sql = $db->prepare("SELECT * FROM instructors WHERE ID=?");
    //     $sql->execute(array($_SESSION['activeUser']['ID']));
    //     $db=null;
    // }
    // catch(PDOException $e){
    //     die($e->getMessage());
    //     }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    
    <link rel="stylesheet" href="generalstyling.css">
    
</head>
<body>
    <div class="wrapper">
        <div class="sidebar-wrapper">
            <?php 
            if($_SESSION['activeUser']['role'] == "instructor")
                $sidenav = "instr";
            else   
                $sidenav = "student";
            include 'sidenav/' . $sidenav . '-sidenav.php'; 
            ?>
        </div>
        <div class="pagecontent-wrapper" id="main">
            <div class="title" >
                <h1>Change Password Page</h1> 
            </div>
            <div class="container">
                <form method='post'>
                    <div class="row">
                        <td><h3>Enter Password Information</h3></td>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Course Name">Old Password</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="password"
                                maxlength="30"
                                name="oldPassword"
                                autocomplete="off"
                                required
                            >
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="Course Name">New Password</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="password"
                                maxlength="30"
                                name="newPassword"
                                autocomplete="off"
                                required
                            >
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-25">
                            <label for="Course Name">Confirm Old Password</label>
                        </div>
                        <div class="col-75">
                            <input 
                                class="input-field"
                                type="password"
                                maxlength="30"
                                name="confirmPassword"
                                autocomplete="off"
                                required
                            >
                        </div>
                    </div>

                    <div class="row" id="submitDiv">
                        <input class="submitBtn" type="submit" value="Change Pass" name="changePassword" />
                    </div>
                </form>
            
                <form action="profile.php" method="post">
                <div class="row" id="submitDiv">
                    <input class="submitBtn" type="submit" value="Cancel" name="cancelSubmit" />
                </div>
                </form>
                
            </div>
        </div>
    </div>
       <!-- Javascript file -->
       <script src="js/sidenav.js"></script>
</body>
</html>