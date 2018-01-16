<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php
  $uid = $_GET["uid"];
  $level = $_GET["level"];
  $sql = ($level == 1) 
    ? "SELECT * FROM student AS st INNER JOIN user AS u ON u.user_id = st.user_id WHERE u.user_id = :uid" 
    : "SELECT * FROM teacher AS t INNER JOIN user AS u ON u.user_id = t.user_id WHERE u.user_id = :uid";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array(":uid"=>$uid));
  $rows = $stmt->fetch(PDO::FETCH_ASSOC);

  $class_stmt = $conn->prepare("SELECT * FROM class");
  $class_stmt->execute();
?>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["send"])) {
      try {
        $conn->beginTransaction();
        if ( $level == 1 ) {
          $conn->exec("UPDATE `student` SET 
                      `student_id` = '".$_POST["sid"]."',
                      `student_firstname` = '".$_POST["firstname"]."',
                      `student_lastname` = '".$_POST["lastname"]."',
                      `student_num` = ".$_POST["num"].",
                      `student_birthday` = CAST('".$_POST["birth"]."' AS DATE),
                      `student_sex` = ".$_POST["sex"].",
                      `student_address` = '".$_POST["address"]."',
                      `student_idcard` = '".$_POST["pid"]."',
                      `class_id` = '".$_POST["class"]."',
                      `user_id` = '".$_POST["uid"]."' 
                      WHERE user_id = '".$uid."'");
          $conn->exec("UPDATE `user` SET 
                      `user_id` = '".$_POST["uid"]."',
                      `user_password` = '".$_POST["password"]."' 
                      WHERE user_id = '$uid'");
        } else if ( $level == 2 ) {
          $conn->exec("UPDATE `teacher` SET
                      `teacher_id` = '".$_POST["tid"]."',
                      `teacher_title` = '".$_POST["title"]."',
                      `teacher_firstname` = '".$_POST["firstname"]."',
                      `teacher_lastname` = '".$_POST["lastname"]."',
                      `teacher_birthday` = CAST('".$_POST["birth"]."' AS DATE),
                      `teacher_address` = '".$_POST["address"]."',
                      `teacher_tel` = '".$_POST["tel"]."'
                      WHERE `user_id` = '$uid'
          ");
          $conn->exec("UPDATE `user` SET 
                      `user_id` = '".$_POST["uid"]."',
                      `user_password` = '".$_POST["password"]."' 
                      WHERE `user_id` = '$uid'");
        }
        $conn->commit();
        unset($_POST["send"]);
        $user->redirect("manage-user.php");
      } catch(PDOException $e) {

        $conn->rollback();
        echo "Error : Can't update!" . $e->getMessage();

      }
    }
  }
?>

<?php 
  ob_start();
  include_once(dirname(__DIR__, 3)."/components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "แก้ไขผู้ใช้";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>

<body>

  <div id="wrapper">

    <!-- Navigation -->
    <?php include_once('nav.php') ?>

    <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header">แก้ไขผู้ใช้</h1>
              <ul class="breadcrumb">
                <li><a href="manage-user.php">จัดการผู้ใช้</a></li>
                <li><?php echo ($level == 1) ? "<a href='manage-user.php#student'>นักเรียน</a>" : "<a href='manage-user.php#teacher'>ครู</a>"; ?></li>
                <li class="active">แก้ไข</li>
              </ul>
              <form class="form-horizontal" method="post" id="changeStatusForm">
              <?php 
                if ($level == 1) {
                  echo '
                    <div class="form-group">
                        <label for="c01" class="col-xs-3 control-label">UID</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="uid" id="c01" value="'.$rows["user_id"].'" placeholder="User ID" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c02" class="col-xs-3 control-label">SID</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="sid" id="c02" value="'.$rows["student_id"].'" placeholder="Student ID" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c03" class="col-xs-3 control-label">Password</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="password" id="c02" value="'.$rows["user_password"].'" placeholder="Password" />
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label for="c04-1" class="col-xs-3 control-label">ชื่อ-นามสกุล</label>
                        <div class="col-xs-9">
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="firstname" id="c04-1" value="'.$rows["student_firstname"].'" placeholder="ชื่อ" />
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="lastname" id="c04-2" value="'.$rows["student_lastname"].'" placeholder="นามสกุล" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c05" class="col-xs-3 control-label">ชั้นเรียน</label>
                        <div class="col-xs-9">
                            <select class="form-control" id="c05" name="class" id="class" required>';
                              while ( $class_rows = $class_stmt->fetch(PDO::FETCH_ASSOC) ) {
                                  echo '<option value="'.$class_rows["class_id"].'" '.(($class_rows["class_id"] == $rows["class_id"]) ? "selected" : "") .'>ป.'.$class_rows["class_grade"].'/'.$class_rows["class_room"].'</option>';
                              }
                            echo '</select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c06" class="col-xs-3 control-label">เลขที่ในชั้น</label>
                        <div class="col-xs-9">
                            <input type="number" min="0" max="" class="form-control" name="num" id="c06" value="'.$rows["student_num"].'" placeholder="เลขที่ในชั้น" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c07" class="col-xs-3 control-label">วันเกิด</label>
                        <div class="col-xs-9">
                            <input type="date" class="form-control" name="birth" id="c07" value="'.$rows["student_birthday"].'" placeholder="วันเกิด" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c08" class="col-xs-3 control-label">เพศ</label>
                        <div class="col-xs-9">
                            <label class="radio-inline"><input type="radio" name="sex" id="sex_male" value="1" '.(($rows["student_sex"] == 1) ? 'checked' : "").'>ชาย</label>
                            <label class="radio-inline"><input type="radio" name="sex" id="sex_female" value="2" '.(($rows["student_sex"] == 2) ? 'checked' : "").'>หญิง</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c09" class="col-xs-3 control-label">ที่อยู่</label>
                        <div class="col-xs-9">
                            <textarea class="form-control" rows="4" name="address" id="c09" value="" placeholder="ที่อยู่...">'.$rows["student_address"].'</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pid" class="col-xs-3 control-label">เลขบัตรประชาชน</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="pid" id="pid" value="'.$rows["student_idcard"].'" placeholder="เลขบัตรประชาชน" />
                        </div>
                    </div>
                  ';
                } else if($level == 2) {
                  echo '
                  
                    <div class="form-group">
                        <label for="c11" class="col-xs-3 control-label">UID</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="uid" id="c11" value="'.$rows["user_id"].'" placeholder="User ID" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c12" class="col-xs-3 control-label">TID</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="tid" id="c12" value="'.$rows["teacher_id"].'" placeholder="Student ID" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c13" class="col-xs-3 control-label">Password</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="password" id="c13" value="'.$rows["user_password"].'" placeholder="Password" />
                        </div>
                    </div>
                    <hr />
                    <div class="form-group">
                        <label for="c14-0" class="col-xs-3 control-label">คำนำหน้า</label>
                        <div class="col-xs-9">
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="title" id="c14-0" value="'.$rows["teacher_title"].'" placeholder="Title" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c14-1" class="col-xs-3 control-label">ชื่อ-นามสกุล</label>
                        <div class="col-xs-9">
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="firstname" id="c14-1" value="'.$rows["teacher_firstname"].'" placeholder="ชื่อ" />
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" class="form-control" name="lastname" id="c14-2" value="'.$rows["teacher_lastname"].'" placeholder="นามสกุล" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c15" class="col-xs-3 control-label">วันเกิด</label>
                        <div class="col-xs-9">
                            <input type="date" class="form-control" name="birth" id="c15" value="'.$rows["teacher_birthday"].'" placeholder="วันเกิด" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="c16" class="col-xs-3 control-label">ที่อยู่</label>
                        <div class="col-xs-9">
                            <textarea class="form-control" rows="4" name="address" id="c16" value="" placeholder="ที่อยู่...">'.$rows["teacher_address"].'</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tel" class="col-xs-3 control-label">เบอร์โทร</label>
                        <div class="col-xs-9">
                            <input class="form-control" type="text" name="tel" id="tel" value="'.$rows["teacher_tel"].'" placeholder="เบอร์โทรฯ">
                        </div>
                    </div>
                  ';
                }
              ?>    
                
          <button class="btn btn-primary btn-block center-block" for="changeStatusForm" type="submit" name="send" value="true">ยืนยัน</button>
        </form>
      </div>
      <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
  </div>  
  <!-- /#wrapper -->

  <?php include_once("js.inc.php"); ?>
  <script>
    $(document).ready(function() {
      $('#pid').inputmask({ 'mask': '9-9999-99999-99-9' });
      $('#tel').inputmask({ 'mask': '999-999-9999' });
    });
  </script>
  <?php $conn = null ?>
</body>