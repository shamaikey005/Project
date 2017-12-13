<?php 
  class User {
    private $db;

    function __construct($db_con) {
      $this->db = $db_con;
    }

    public function login($id, $pass) {
      try{
        $stmt = $this->db->prepare("SELECT * FROM user WHERE user_id=:id AND user_password=:pass");
        $stmt->execute(array(':id'=>$id, ':pass'=>$pass));
        $loginRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0) {
          if($loginRow['user_status'] == 1) {
            $_SESSION['id'] = $loginRow['user_id'];
            if($loginRow['user_level'] == 127) {
              $_SESSION['permission'] = "admin";
              $_SESSION['firstname'] = "Admin";
              return true;
            }
            else if($loginRow['user_level'] == 2) {
              $_SESSION['permission'] = "teacher";
              $stmtT = $this->db->prepare("SELECT * FROM teacher WHERE user_id=:id");
              $stmtT->execute(array(':id'=>$id));
              $st = $stmtT->fetch(PDO::FETCH_ASSOC);
              $_SESSION['firstname'] = $st["teacher_firstname"];
              $_SESSION['lastname'] = $st["teacher_lastname"];
              return true;
            }
            else if($loginRow['user_level'] == 1) {
              $_SESSION['permission'] = "student";
              $stmtT = $this->db->prepare("SELECT * FROM student WHERE user_id=:id");
              $stmtT->execute(array(':id'=>$id));
              $st = $stmtT->fetch(PDO::FETCH_ASSOC);
              $_SESSION['firstname'] = $st["student_firstname"];
              $_SESSION['lastname'] = $st["student_lastname"];
              return true;
            }
            else{
              echo "Something error on sign in";
              return false;
            }
          }
        }else{
          return false;
        }
      } catch(PDOException $e) {
        echo 'Error : ' . $e.getMessage();
      }
    }

    public function isLoggedin() {
      if(isset($_SESSION["id"])) {
        return true;
      }
    }

    public function isAdmin() {
      if(isset($_SESSION["id"]) && $_SESSION["permission"] == "admin") {
        return true;
      }
    }

    public function isTeacher() {
      if(isset($_SESSION["id"]) && $_SESSION["permission"] == "teacher") {
        return true;
      }
    }

    public function isStudent() {
      if(isset($_SESSION["id"]) && $_SESSION["permission"] == "student") {
        return true;
      }
    }

    public function redirect($url) {
      header("Location: $url");
    }

    public function logout() {
      session_destroy();
      unset($_SESSION["id"]);
      unset($_SESSION["firstname"]);
      unset($_SESSION["lastname"]);
      unset($_SESSION["permission"]);
      return true;
    }

  }
?>