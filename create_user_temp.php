<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Sign-Up</title>
  </head>
  <body>
  <?php
  if (isset($_POST['sbtn'])){
    $uname = $_POST['un'];
    $pass = $_POST['ps'];

    //Validation will be kept for you as an exercise
    //check name, username, password, cpassword, and the proceed
    try {
        require('Database/connection.php');
        $hps = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "UPDATE students SET Password='$hps' WHERE StudentID='$uname'";
        $result = $db->exec($sql);
        if ($result === 1)
            echo "Successful Registeration - <a href='Login.php'>Click here to login</a>";
        die();
    }
    catch(PDOException $e){
      if ($db->errorCode()==23000)
        echo "Failed, Username is already taken, choose another one";
      else
        die($e->getMessage());
    }
    $db=null;

  }
  ?>
    <form method="post">
      
      <label for="un" />Username: </label>
      <input type="text" name="un" id="un" placeholder="Enter username"> <br />

      <label for="ps" />Password: </label>
      <input type="password" name="ps" id="ps" placeholder="Enter Password"> <br />

      <button type="submit" name="sbtn">Sign Up</button>
    </form>

  </body>
</html>