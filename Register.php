<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>MyWall</title>
    <script  src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="  crossorigin="anonymous"></script>
    <link type="text/css" rel="stylesheet" href="assets/bootstrap-4.5.2-dist/css/bootstrap.css">
    <script src="assets/bootstrap-4.5.2-dist/js/bootstrap.js" > </script>
  </head>

  <?php
  session_start();
  include ('config/DBConnect.php');

  if(isset($_SESSION['name']))
  {
     header("Location:Wall.php");
  }

  if(isset($_POST["register"]))
   {

    $Name = $_POST["uname"];
    $Pword = $_POST["pword"];
    if($Name != "" && $Pword != "")
    {
      $ENpword = sha1($Pword);
      $hex = '#';

     //Create a loop.
     foreach(array('r', 'g', 'b') as $color)
     {
        //Random number between 0 and 255.
         $val = mt_rand(0, 255);
        //Convert the random number into a Hex value.
        $dechex = dechex($val);
         //Pad with a 0 if length is less than 2.
       if(strlen($dechex) < 2){
        $dechex = "0" . $dechex;
       }
        //Concatenate
      $hex .= $dechex;
     }
     $Userchk = "Select * from users where Name = '$Name'";
     $result = mysqli_query($conn,$Userchk);
     $sql = "INSERT INTO users (Name,Password,BgCol) VALUES ('$Name', '$ENpword', '$hex')";
     if(mysqli_num_rows($result) > 0){
       $error = "This username seems to have been taken , try another one" ;
     }
     else {
       if (mysqli_query($conn, $sql)) {
         header ('Location:index.php');
         }
         else {
           $error = "registeration unsuccessful" ;
         }
     }


   }
   else {
     $error= " pls fill all details";
   }
 }
mysqli_close($conn);
 ?>

  <body>
    <nav class="navbar navbar-expand navbar-dark bg-dark">
    <span class="navbar-brand h1 px-auto mx-auto"> MyWall </span>
    </nav>
     <div class="container pt-5">
       <form name="Login" method="post" action="Register.php">
          <h3>Register</h3>
          <div class ="form-group">
              <label for="uname">Name :</label> <input type="text" name="uname" id="uname" class="form-control col-md-5" placeholder="Username" required>
       </div>
       <div class ="form-group">
         <label for="pword">Password :</label> <input type="password" name="pword" class="form-control col-md-5 " placeholder="password" required>
        </div>
         <a href="Index.php"> Registered already ? Login </a>
         <br>
       <input type="submit" name="register" value="Sign Up" class="btn btn-primary">
      </form>

    </div>
<?php
 if(isset($_POST["register"])){
       echo $error;
    }

     ?>
  </body>
</html>
