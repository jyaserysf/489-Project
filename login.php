<?php
session_start();
// if (isset($_SESSION['activeUser']))
//     session_unset(); 

if (isset($_COOKIE['remember_me'])){
    $arr = explode('#', $_COOKIE['remember_me']);
    try {
        require('Database/connection.php');
        $sql = "select * from students where StudentID ='" . $arr[0] . "'";
        $result = $db->query($sql);
        if ($row = $result->fetch()){
            if ( $arr[1] == $row['Password']) {
                $_SESSION['activeUser'] = $arr[0];                   
                header('location:Home.php');
                die();
            }
        $db=null;
        }
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
    <link rel="stylesheet" href="Login_style.css">
 </head>
 <body>

    <?php
    if (isset($_POST['submit'])){
        $uname = $_POST['username'];
        $pass = $_POST['password'];
        //Validation will be kept for you as an exercise
        try {
            require('Database/connection.php');
            $sql = "select * from students where StudentID = '$uname'";
            $result = $db->query($sql);
            if ($row = $result->fetch()){
                if (password_verify($pass, $row['Password'])) {
                    $_SESSION['activeUser'] = $uname;
                    if (isset($_POST['remember_me'])) {
                        setcookie('remember_me', "$uname#" . $row['Password'], time()+(60*5));
                    }                     
                    header('location: Home.php');
                    die();
                }
                else {
                    // TODO: Invalid Password
                    echo "Invalid Password";
                }
            }
            else {
                // TODO: Invalid Username
                echo "Invalid Username";
            }
            $db=null;
        }
        catch(PDOException $e){
        die($e->getMessage());
        }
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
                    <form action="Login.php" method="post" autocomplete="off" class="login-form">
                        
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
    
                            <input type="submit" value="Reset Password" class="resetPassword-btn">

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
    <script src="Login_app.js"></script>
 </body>
 </html>