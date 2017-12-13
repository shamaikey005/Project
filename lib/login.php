<?php 
  session_start();
  include_once(__DIR__."/conn.php");

  if($user->login($_POST["id"], $_POST["pass"])) {
    if($user->isLoggedin()) {
      if($user->isAdmin()) {
        $user->redirect("/dashboard/pages/admin/");
      }
      else if($user->isTeacher()) {
        $user->redirect("/dashboard/pages/teacher/");
      }
      else if($user->isStudent()) {
        $user->redirect("/dashboard/pages/student/");
      }
    }
  }else{
    $user->redirect("index.php");
  }
?>