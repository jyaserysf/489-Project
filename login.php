<?php
session_start();
if (isset($_SESSION['activeUser']))
    session_unset(); 

//TODO: Modify sessions so that they store the unique key
if (isset($_COOKIE['remember_me'])){
    $data = json_decode($_COOKIE['remember_me'], true);
    try {
        require('Database/connection.php');

        $sql_student = "select * from students where studentID ='" . $data['username'] . "'";
        $student = $db->query($sql_student);

        $sql_instructor = "select * from instructors where username ='" . $data['username'] . "'";
        $instructor = $db->query($sql_instructor);

        $sql_admin = "select * from admins where username ='" . $data['username'] . "'";
        $admin = $db->query($sql_admin);

        if ($row = $student->fetch()) {
            if ( $data['password'] == $row['password']) {
                $_SESSION['activeUser'][$data['username']] = $data['role'];                   
                header('location:student-homep.php');
                die();
            }
            else {
                echo "Incorret Password";
            }
        }

        elseif($row = $instructor->fetch()) {
            if ( $data['password'] == $row['password']) {
                $_SESSION['activeUser'][$data['usernmae']] = $data['role'];                   
                header('location:instructor-homep.php');
                die();
            }
            else {
                echo "Incorrect Password";
            }
        }

        elseif($row = $admin->fetch()) {
            if ( $data['password'] == $row['password']) {
                $_SESSION['activeUser'][$data['username']] = $data['role'];              
                //header('location:#');
                echo "admin";
                die();
            }
            else {
                echo "Incorrect Password";
            }
        }
        $db=null;
    }
    catch(PDOException $e){
    die($e->getMessage());
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

    <?php
    if (isset($_POST['submit'])){
        $uname = $_POST['username'];
        $pass = $_POST['password'];
        try {
            require('Database/connection.php');

            $sql_student = "select * from students where studentID = '$uname'";
            $sql_instructor = "select * from instructors where username = '$uname'";
            $sql_admin = "select * from admins where username = '$uname'";

            $result_student = $db->query($sql_student);
            $result_instructor = $db->query($sql_instructor);
            $result_admin = $db->query($sql_admin);

            if ($row = $result_student->fetch()){
                if (password_verify($pass, $row['password'])) {
                    $_SESSION['activeUser'][$row['studentID']] = "student";
                    if (isset($_POST['remember_me'])) {
                        $cookie = ["username"=>$row['studentID'], "password"=>$row['password'], "role"=>"student"]; 
                        setcookie('remember_me', json_encode($cookie), time()+(5*60));
                    }                     
                    header('location:student-homep.php');
                    die();
                }
                else {
                    echo "Invalid Password";
                }
            }

            elseif ($row = $result_instructor->fetch()) {
                if (password_verify($pass, $row['password'])) {
                    $_SESSION['activeUser'][$row['ID']] = "instructor";
                    if (isset($_POST['remember_me'])) {
                        $cookie = ["username"=>$row['username'], "password"=>$row['password'], "role"=>"instructor"];
                        setcookie('remember_me', json_encode($cookie), time()+(5*60));
                    }                     
                    header('location:instructor-homep.php');
                    die();
                }
                else {
                    echo "Invalid Password";
                }
            }

            elseif ($row = $result_admin->fetch()) {
                if (password_verify($pass, $row['password'])) {
                    $_SESSION['activeUser'][$row['ID']] = "admin";
                    if (isset($_POST['remember_me'])) {
                        $cookie = ["username"=>$row['username'], "password"=>$row['password'], "role"=>"admin"];
                        setcookie('remember_me', json_encode($cookie), time()+(5*60));
                    }                     
                    //header('location:');
                    echo "admin";
                    die();
                }
                else {
                    echo "Invalid Password";
                }
            }

            else {
                echo "Invalid Username";
            }
            $db=null;
        }
        catch(PDOException $e) {
        die($e->getMessage());
        }
    }
    elseif(isset($_POST['resetbtn'])) {
        
    }
    ?>
   
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
                    <form action="Login.html" autocomplete="off" class="forgotPassword-form">
                        
                        <div class="logo"><img src="./img/logo.png" alt="University"><h4>University</h4></div>
    
                        <div class="heading"><h2>Forgot Your Password?</h2></div>
    
                        <div class="actual-form">

                            <div class="input-area">
                                <input
                                    type="email"
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