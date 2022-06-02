<?php
require("functions.php");
session_start();
function quote($var){
  return trim($var);
}
  if(isset($_SESSION["id"]))
  {
    header("Location: ./");
  } 
  if(isset($_POST['register']))
  {
    if (isset($_POST['passwd']) && isset($_POST['username']) && isset($_POST['re-passwd']))
    {
      $passwd = md5(quote($_POST['passwd']));
      if($passwd != md5(quote($_POST['re-passwd']))) header("Location: ./register.php");
      $username = $_POST['username'];
      $db = new mysqli("localhost", "root", "", "chat");
      $req = $db->prepare("select * from `user` where username='$username' and password='$passwd'");
      $req->execute();
      $res = $req->get_result();
      if($row = $res->fetch_assoc())
      {
        header("Location: ./");
      }
      else
      {
          $req = $db->prepare("insert into `user` (username,password,img) values (?,?,?)");
          $filename=SaveFile();
          $req->bind_param("sss",$username,$passwd,$filename);
          $req->execute();
          header("Location: ./auth.php");
      }
    }
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta2/css/bootstrap.min.css'><link rel="stylesheet" href="./style_auth.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h2 class="text-center text-dark mt-5">Sign Up</h2>
        <div class="card my-5">

          <form class="card-body cardbody-color p-lg-5" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <input type="text" class="form-control" id="Username" aria-describedby="emailHelp"
                placeholder="User Name" name="username">
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" id="password" placeholder="password" name="passwd">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password1" placeholder="re-password" name="re-passwd">
            </div>
            <div class="mb-3">
                <input type="file" name="uploadedFile" />
            </div>
            <div class="text-center"><button type="submit" class="btn btn-color px-5 mb-5 w-100" name="register">Sign Up</button></div>
            <div id="emailHelp" class="form-text text-center mb-5 text-dark">A you ready
              Registered? <a href="./auth.php" class="text-dark fw-bold"> Sign in</a>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
<!-- partial -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta2/js/bootstrap.min.js'></script>
</body>
</html>
