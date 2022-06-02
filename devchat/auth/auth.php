<?php
function quote($var){
  return trim($var);
}
  if(isset($_POST['login']))
  {
    if (isset($_POST['passwd']) && isset($_POST['username']))
    {
      $passwd = md5(quote($_POST['passwd']));
      $username = $_POST['username'];
      $db = new mysqli("localhost", "root", "", "chat");
      $req = $db->prepare("select * from `user` where username='$username' and password='$passwd'");
      $req->execute();
      $res = $req->get_result();
      if($row = $res->fetch_assoc())
      {
        $_SESSION['id'] = $row['id'];
      }
    }
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>CodePen - Login Form (Using Bootstrap)</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-beta2/css/bootstrap.min.css'><link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <h2 class="text-center text-dark mt-5">Login Form</h2>
        <div class="text-center mb-5 text-dark">Made with bootstrap</div>
        <div class="card my-5">

          <form class="card-body cardbody-color p-lg-5" method="POST">
            <div class="mb-3">
              <input type="text" class="form-control" id="Username" aria-describedby="emailHelp"
                placeholder="User Name" name="username">
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" id="password" placeholder="password" name="passwd">
            </div>
            <div class="text-center"><button type="submit" class="btn btn-color px-5 mb-5 w-100" name="login">Login</button></div>
            <div id="emailHelp" class="form-text text-center mb-5 text-dark">Not
              Registered? <a href="#" class="text-dark fw-bold"> Create an
                Account</a>
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
