<?php 
    include_once(__DIR__."/lib/conn.php");
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if($user->login($_POST["id"], $_POST["pass"])) {
            if($user->isLoggedin()) {
              if($user->isAdmin()) {
                $user->redirect("./dashboard/pages/admin/");
              }
              else if($user->isTeacher()) {
                $user->redirect("./dashboard/pages/teacher/");
              }
              else if($user->isStudent()) {
                $user->redirect("./dashboard/pages/student/");
              }
            }
          }else{
            $user->redirect("index.php");
          }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./favicon.ico">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="./css/bootstrap.min.css" />
    <link rel="stylesheet" href="./css/font-awesome.min.css" />
    <script src="./js/jquery-3.2.1.slim.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <title>Login</title>
</head>

<body>

    <div class="container" style="margin-top: 30vh;">
        <!-- login -->
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 col-sm-6 col-sm-offset-3 col-md-4	col-md-offset-4">
                <form class="form-signin" name="login" method="post">
                    <h2 class="form-signin-heading">Please Login</h2>
                    <label for="inputID" class="sr-only">ID</label>
                    <input type="text" name="id" id="inputID" class="form-control" placeholder="ID" required autofocus>
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" name="pass" id="inputPassword" class="form-control" placeholder="Password" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>