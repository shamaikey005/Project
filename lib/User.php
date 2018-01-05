<?php 
  class User {
    private $db;
    public $user_error;

    function __construct($db_con) {
      $this->db = $db_con;
    }

    public function login($id, $pass) {
      try{
        $stmt = $this->db->prepare("SELECT * FROM user WHERE user_id=:id AND user_password=:pass");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pass", $pass);
        $stmt->execute();
        $loginRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount() > 0) {
          if($loginRow['user_status'] == 1) {
            $_SESSION['id'] = $loginRow['user_id'];
            if($loginRow['user_level'] == 127) {
              $_SESSION['id'] = "admin";
              $_SESSION['permission'] = "admin";
              $_SESSION['firstname'] = "Admin";
              return true;
            }
            else if($loginRow['user_level'] == 2) {
              $_SESSION['permission'] = "teacher";
              $stmtT = $this->db->prepare("SELECT * FROM teacher WHERE user_id=:id");
              $stmtT->bindParam(":id", $id);
              $stmtT->execute();
              $st = $stmtT->fetch(PDO::FETCH_ASSOC);
              $_SESSION['id'] = $st["teacher_id"];
              $_SESSION['user'] = $st["user_id"];
              $_SESSION['firstname'] = $st["teacher_firstname"];
              $_SESSION['lastname'] = $st["teacher_lastname"];
              return true;
            }
            else if($loginRow['user_level'] == 1) {
              $_SESSION['permission'] = "student";
              $stmtT = $this->db->prepare("SELECT * FROM student WHERE user_id=:id");
              $stmtT->bindParam(":id", $id);
              $stmtT->execute();
              $st = $stmtT->fetch(PDO::FETCH_ASSOC);
              $_SESSION['id'] = $st["student_id"];
              $_SESSION['user'] = $st["user_id"];
              $_SESSION['firstname'] = $st["student_firstname"];
              $_SESSION['lastname'] = $st["student_lastname"];
              $_SESSION['class'] = $st["class_id"];
              return true;
            }
            else{
              // echo "Something error on sign in";
              $this->user_error = "ขออภัย!!! เกิดข้อผิดพลาดบางอย่างในระบบ";
              return false;
            }
          }else{
            $this->user_error = "บัญชีของคุณยังไม่ถูกเปิดใช้งาน";
            return false;
          }
        }else{
          $this->user_error = "ไอดีหรือรหัสผ่านไม่ถูกต้อง";
          return false;
        }
      } catch(PDOException $e) {
        echo '<script>console.log("' . $e->getMessage() . '")</script>';
      }
    }

    public function isLogin() {
      if(isset($_SESSION["id"])) {
        return true;
      }else{
        $this->user_error = "คุณยังไม่ได้ทำการล็อกอิน";
        return false;
      }
    }

    public function isAdmin() {
      if(isset($_SESSION["id"]) && $_SESSION["permission"] == "admin") {
        return true;
      }else{
        $this->user_error = "คุณไม่มีสิทธิ์เข้าถึงส่วนนี้";
        return false;
      }
    }

    public function isTeacher() {
      if(isset($_SESSION["id"]) && $_SESSION["permission"] == "teacher") {
        return true;
      }else{
        $this->user_error = "คุณไม่มีสิทธิ์เข้าถึงส่วนนี้";
        return false;
      }
    }

    public function isStudent() {
      if(isset($_SESSION["id"]) && $_SESSION["permission"] == "student") {
        return true;
      }else{
        $this->user_error = "คุณไม่มีสิทธิ์เข้าถึงส่วนนี้";
        return false;
      }
    }

    public function isError() {
      $error = $this->user_error;
      if(isset($error)) {
        return $error;
      }
    }

    public function isAvailable($status) {
      return ($status == 1) ? '<i class="fas fa-check-circle fa-sm" style="color:green;"></i> เปิด' : '<i class="fas fa-times-circle fa-sm" style="color:#d93e3e;"></i> ปิด' ;
    }

    public function redirect($url) {
      header("Location: $url");
    }

    public function logout() {
      session_destroy();
      unset($_SESSION["id"]);
      unset($_SESSION["user"]);
      unset($_SESSION["firstname"]);
      unset($_SESSION["lastname"]);
      unset($_SESSION["permission"]);
      return true;
    }

  }
?>