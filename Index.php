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
  include ('config/DBConnect.php');
  session_start();
  if(isset($_SESSION['name']))
  {
     header("Location:Wall.php");
  }
   if(isset($_POST["login"]))
   {
     $name = $_POST["uname"];
     $pword = $_POST["pword"];
     if($name != "" && $pword != "")
     {
         $ENpword = sha1($pword);
       $Userchk = "Select * from users where name = '$name' && Password = '$ENpword' ";
       $result = mysqli_query($conn,$Userchk);
       if(mysqli_num_rows($result) > 0){
         while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['id'] = $row['ID'];
            $_SESSION['name'] = $row['Name'];
            $_SESSION['password'] = $row['Password'];
            $_SESSION['backgroundColor'] = $row['BgCol'];
            $_SESSION['backgroundImage'] = $row['BgImg'];
            header("location:Wall.php");
         }
       }
       else{
        $error = "Username or Password wrong , recheck credentials";
       }

     }
     else {
       $error = "please fill out username and password" ;
     }
   }

  ?>
  <body>
    <nav class="navbar navbar-expand navbar-dark bg-dark">
    <span class="navbar-brand h1 px-auto mx-auto"> MyWall </span>
    </nav>

   <div class="container pt-5">
      <form name="Login" method="post" action="Index.php">
         <h3>Login</h3>
         <div class ="form-group">
             <label for="uname">Name :</label> <input type="text" name="uname" id="uname" class="form-control col-md-5" placeholder="Username" required>
      </div>
      <div class ="form-group">
        <label for="pword">Password :</label> <input type="password" name="pword" class="form-control col-md-5 " placeholder="password" required>
        </div>
        <a href="Register.php"> Register </a>
        <br>
      <input type="submit" name="login" value="Login" class="btn btn-primary">
     </form>
    </div>
    <?php
     if(isset($_POST["login"])){
           echo $error;
        }

         ?>
  </body>
</html>
