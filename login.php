<?php
session_start();

if (isset($_SESSION['activeUser'])) {
    $role = $_SESSION['activeUser']['role'];
    header("location: $role-homep.php");
    die(); 
}

elseif (isset($_COOKIE['remember_me'])){
    $data = json_decode($_COOKIE['remember_me'], true);
    try {
        require('Database/connection.php');
        $role = $data['role'];
        if($role == "instructor" || $role == "HOD") {
            $stmt = $db->prepare("SELECT * FROM instructors WHERE username=?");
            $stmt->execute(array($data['username']));
        }
        elseif($role == "admin") {
            $stmt = $db->prepare("SELECT * FROM admins WHERE username=?");
            $stmt->execute(array($data['username']));
        }
        else {
            $stmt = $db->prepare("SELECT * FROM students WHERE studentID=?");
            $stmt->execute(array($data['username']));
        }

        if ($row = $stmt->fetch()) {
            if ($data['password'] == $row['password']) {
                $session_arr = ["username"=>$data['username'], "role"=>$data['role'],"ID"=>$data['ID']];
                $_SESSION['activeUser'] = $session_arr;                   
                header("location: $role-homep.php");
                $db=null;
                die();
            }
            else {
                header('location: login.php');
                $db=null;
                die();
            }
        }
    }
    catch(PDOException $e){
        die($e->getMessage());
    }
}

elseif (isset($_POST['submit'])){
    if(!isset($_POST['username']) || !isset($_POST['password'])) {
        echo "Please enter the required information";
        die();
    }
    $uname = $_POST['username'];
    $pass = $_POST['password'];
    try {
        require('Database/connection.php');

        $stmt = $db->prepare("SELECT * FROM students WHERE studentID=?");
        $stmt->execute(array($uname));
        if ($row = $stmt->fetch()){
            if (password_verify($pass, $row['password'])) {
                $session_arr = ["username"=>$row['studentID'], "role"=>"student", "ID"=>$row['ID']];
                $_SESSION['activeUser'] = $session_arr;
                if (isset($_POST['remember_me'])) {
                    $cookie = ["username"=>$row['studentID'], "password"=>$row['password'], "role"=>"student", "ID"=>$row['ID']]; 
                    setcookie('remember_me', json_encode($cookie), time()+(5*60));
                }                     
                header('location:student-homep.php');
                $db=null;
                die();
            }
            else {
                echo "Invalid Password";
                $db=null;
                die();
            }
        }
        else {
            $stmt = $db->prepare("SELECT * FROM instructors WHERE username=?");
            $stmt->execute(array($uname));
            if ($row = $stmt->fetch()){
                if (password_verify($pass, $row['password'])) {


                    $stmt1 = $db->prepare("SELECT * FROM departments WHERE departmentHead=?");
                    $stmt1->execute(array($row['ID']));
                    if($row1 = $stmt1->fetch()) 
                        $role = "HOD";
                    else 
                        $role = "Instructor";
                    $session_arr = ["username"=>$row['username'], "role"=>$role,"ID"=>$row["ID"]];
                    $_SESSION['activeUser'] = $session_arr;
                    if (isset($_POST['remember_me'])) {
                        $cookie = ["username"=>$row['username'], "password"=>$row['password'], "role"=>$role,"ID"=>$row["ID"]]; 

                        setcookie('remember_me', json_encode($cookie), time()+(5*60));
                    }                     
                    header('location:' . $role . '-homep.php');
                    $db=null;
                    die();
                }
                else {
                    echo "Invalid Password";
                    $db=null;
                    die();
                }
            }
            else {
                $stmt = $db->prepare("SELECT * FROM admins WHERE username=?");
                $stmt->execute(array($uname));
                if ($row = $stmt->fetch()){
                    if (password_verify($pass, $row['password'])) {
                        $session_arr = ["username"=>$row['username'], "role"=>"admin", "ID"=>$row['ID']];
                        $_SESSION['activeUser'] = $session_arr;
                        if (isset($_POST['remember_me'])) {
                            $cookie = ["username"=>$row['username'], "password"=>$row['password'], "role"=>"admin", "ID"=>$row['ID']]; 
                            setcookie('remember_me', json_encode($cookie), time()+(5*60));
                        }                     
                        header('location:admin-homep.php');
                        $db=null;
                        die();
                    }
                    else {
                        echo "Invalid Password";
                        $db=null;
                        die();
                    }
                }
                else {
                    echo "Invalid Username";
                    $db=null;
                    die();
                }
            }
        }
    }

    catch(PDOException $e) {
        die($e->getMessage());
    }
}

elseif(isset($_POST['resetbtn'])) {
    if(isset($_POST['email'])) {
        $message = "Please visit the following link to reset your password";
        if(mail($_POST['email'], "Password Reset", $message, "mt@mt.edu"))
            echo "Password reset link sent";
        else   
            echo "Password reset link could not be sent";
    }
    else {
        echo "Please enter your email";
    }
}
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/Login_style.css">
 </head>
 <body>
   
    <main> 
        <!-- Outer Box -->
        <div class="box">
            <!-- Inner Box -->
            <div class="inner-box">
                <!-- Form Area -->
                <div class="forms-area">
                    <!-- The Login Form -->
                    <form action="login.php" method="post" autocomplete="off" class="login-form">
                        
                        <div class="logo"><img src="./img/logo.png" alt="University"><h4>University</h4></div>
    
                        <div class="heading"><h2>Login</h2></div>
    
                        <div class="actual-form">

                            <div class="input-area">
                                <input
                                    type="text"
                                    name="username"
                                    minlength="4"
                                    class="input-field"
                                    autocomplete="off"
                                    required
                                >
                                <label>User Name</label>
                            </div>
    
                            <div class="input-area">
                                <input
                                    type="password"
                                    name="password"
                                    minlength="4"
                                    class="input-field"
                                    autocomplete="off"
                                    required
                                >
                                <label>Password</label>
                            </div>
    
                            <div class="input-area">
                                <input
                                    type="checkbox"
                                    name="remember_me"
                                    minlength="4"
                                    class="input-field-checkbox"
                                    autocomplete="off"
                                >
                                <label class="label_rememberme">Remember me</label>
                            </div>
    
                            <input type="submit" name="submit" value="Login" class="login-btn">
    
                            <p class="text">
                                Forgotten your password?
                                <a href="#" class="toggle">Get help</a>
                            </p>

                        </div>
                    </form>

                    <!-- Forgot Password Form -->
                    <form action="login.php" method="post" autocomplete="off" class="forgotPassword-form">
                        
                        <div class="logo"><img src="./img/logo.png" alt="University"><h4>University</h4></div>
    
                        <div class="heading"><h2>Forgot Your Password?</h2></div>
    
                        <div class="actual-form">

                            <div class="input-area">
                                <input
                                    type="email"
                                    name="email"
                                    minlength="4"
                                    class="input-field"
                                    autocomplete="off"
                                    required
                                >
                                <label>Email Address</label>
                            </div>
    
                            <input type="submit" name="forgetbtn" value="Reset Password" class="resetPassword-btn">

                            <a href="#" class="toggle">
                                <input type="submit" value="Back to Login" class="backToLogin-btn">
                            </a>

                        </div>
                    </form>
                    
                </div>

                <!-- Image Area -->
                <div class="image-area">
                    <img src="./img/login.svg" alt="University" id="img1">
                    <img src="./img/forgot_password.svg" alt="University" id="img2">
                </div>
                

            </div>
        </div>
    </main>
    
    <!-- Javascript file -->
    <script src="js/Login_app.js"></script>
 </body>
 </html>