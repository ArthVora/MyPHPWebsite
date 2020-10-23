<?php
session_start();
if(!isset($_SESSION['name']))
{
   header("Location:Index.php");
   exit();
}
  include ('config/DBConnect.php');
function GetUpdatedInfo(){
  include ('config/DBConnect.php');
  $name = $_SESSION['name'];
  $FetchNotes = "select notes from users where name = '$name'";
  $result = mysqli_query($conn,$FetchNotes);
  if(mysqli_num_rows($result)>0)
  {
    while ($row = mysqli_fetch_assoc($result)) {
      $UpdatedNotes = $row['notes'];
    }
  }
  echo $UpdatedNotes;
}

if(isset($_POST['save']))
{
   $ID = $_SESSION['id'];
   $NotesToUpdate = $_POST['notes'];
  $UpdateNotes="update users set notes='$NotesToUpdate' where ID = $ID ";
  if(mysqli_query($conn,$UpdateNotes))
  {
     header("Location:Wall.php");
  }

}

function SetBgImg($imgnameloc){
  include ('config/DBConnect.php');
  $ID = $_SESSION['id'];
  $sql = "update users set BgImg='$imgnameloc' where ID = $ID" ;
  mysqli_query($conn,$sql);

}

//upload a pic

if(isset($_POST['upload']))
{
  $fileName = $_FILES['bgimg']['name'];
  $fileTmpLoc = $_FILES['bgimg']['tmp_name'];
  $file_extension = pathinfo($fileName, PATHINFO_EXTENSION);
  $file_extension = strtolower($file_extension);
  $allowed = array("jpg","jpeg");
  $imgEr = "";
  if(in_array($file_extension,$allowed)){
      $fileNewName = $_SESSION['id'].".jpg";
      $location = 'img/'.$fileNewName;
      if(move_uploaded_file($fileTmpLoc,$location)){
         SetBgImg($location);
         $_SESSION['backgroundImage'] = $location;
         header("Location:Wall.php");
      }

  }else {
     $imgEr="upload file of type jpg/jpeg pls";
  }

}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script  src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="  crossorigin="anonymous"></script>
    <link type="text/css" rel="stylesheet" href="assets/bootstrap-4.5.2-dist/css/bootstrap.css">
    <script src="assets/bootstrap-4.5.2-dist/js/bootstrap.js" > </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <style>

html, body
   {
    height: 100%;
    overflow-x: hidden;
    margin: 0;
    padding: 0;
    width: 100%;
    background: url("<?php echo $_SESSION['backgroundImage'] ?>") no-repeat;
    background-color: <?php echo $_SESSION['backgroundColor'] ?> ;
    background-size: cover;
   }
    #display{
      height: 100% ;
      background-color: rgba(255,255,255,0.4);
      margin : auto ;
      padding: 20px;
    }
    #note{
      resize: none ;
      outline : none ;
      height: auto;
      background: transparent ;
      width : 100% ;
      overflow: hidden;
    }
    .container-fluid , #row
    {
       height: 90%;
    }

  </style>

  <script>
  $(document).ready(function(){
    $("#note").css({"border":"none"})
    $("#save").hide()
    $("#note").focus(function() {
       $("#note").css({"border":"2px solid black"})
       $("#save").show()
    });
   $("#save").click(function(){
     $("#note").css({"border":"none"})
     $("#save").hide()

   });
});
  </script>

  <body>
   <nav class="navbar navbar-expand navbar-dark bg-dark">
   <span class="navbar-brand h1"> <?php echo $_SESSION['name']."'s wall" ?> </span>
     <ul class="navbar-nav ml-auto">
       <li class="nav-item px-1">
          <button type="button" class="btn btn-info nav-link text-light rounded-pill" data-toggle="modal" data-target="#uploadModal">ChangeBG</button>
       </li>
       <li class="nav-item px-1 ">
         <a class="btn  btn-danger text-light nav-link rounded-pill  " href="logout.php">logout</a>
       </li>
     </ul>
   </nav>
   <div class="container-fluid">
     <div class="row" id="row">
     <div name = 'Display' class = "col-md-10 col-xs-8 rounded mt-5 overflow-auto " id="display" >
       <form name = "write" method="post" action="Wall.php" class="form-group row">
         <button type="submit" name="save" id="save" class="close btn btn-danger" aria-label="Close">
       <span aria-hidden="true">&times;</span>
       </button>
         <textarea  id="note" name = "notes" placeholder="write here"  ><?php GetUpdatedInfo(); ?></textarea>
       </form>
   </div>
 </div>
 </div>


 <!-- Modal -->
<div id="uploadModal" class="modal fade" role="dialog">
<div class="modal-dialog">

  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Upload a Background Image </h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
      <!-- Form -->
      <form method='post' action='Wall.php' enctype="multipart/form-data">
        Select file : <input type='file' name='bgimg' id='file' class='form-control' ><br>
        <input type='submit' class='btn btn-info' value='Upload' name='upload' id='btn_upload'>
      </form>
    </div>
  </div>
</div>
</div>


</body>
</html>
