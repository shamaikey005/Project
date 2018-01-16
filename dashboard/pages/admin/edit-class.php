<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php
  $cid = $_GET["id"];
  $teacher = $_GET["t"];
  $sql = "SELECT * FROM class WHERE class_id = :cid"; 
  $stmt = $conn->prepare($sql);
  $stmt->execute(array(":cid"=>$cid));
  $rows = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["send"])) {
      try {
        $stmt = $conn->prepare("UPDATE `class` SET
                                `class_grade` = '".$_POST["cgrade"]."',
                                `class_room` = ".$_POST["croom"].",
                                `teacher_id` = ".$_POST["cteacher"].",
                                 WHERE `class_id` = '". $cid."'");
        $stmt->execute();
        unset($_POST["send"]);
        $user->redirect("manage-gen.php");
      } catch(PDOException $e) {

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

  $title = "แก้ไขชั้นเรียน";
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
              <h1 class="page-header">แก้ไขชั้นเรียน</h1>
              <ul class="breadcrumb">
                <li><a href="manage-gen.php">จัดการข้อมูลพื้นฐาน</a></li>
                <li class="active">แก้ไขชั้นเรียน</li>
              </ul>
              <form class="form-horizontal" method="post" id="changeClassForm">
              <?php echo '
                <div class="form-group">
                    <label for="c01" class="col-xs-3 control-label">รหัสชั้นเรียน</label>
                    <div class="col-xs-9">
                        <p class="form-control-static">'. $rows["class_id"] .'</p>
                        <input type="hidden" name="cid" value="'.$rows["class_id"].'" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="c02" class="col-xs-3 control-label">ระดับชั้น</label>
                    <div class="col-xs-9">
                        <input type="number" min="1" max="6" class="form-control" name="cgrade" id="c02" value="'. $rows["class_grade"] .'" placeholder="Class Grade" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="c03" class="col-xs-3 control-label">ห้อง</label>
                    <div class="col-xs-9">
                        <input type="number" min="1" class="form-control" name="croom" id="c03" value="'. $rows["class_room"] .'" placeholder="Class Room" />
                    </div>
                </div>
                <div class="form-group">
                  <label for="c04" class="col-xs-3 control-label">ครูที่ปรึกษา</label>
                  <div class="col-xs-9">
                      <select class="form-control" name="cteacher" id="c04">';
                        $teacher_stmt = $conn->prepare("SELECT * FROM `teacher`");
                        $teacher_stmt->execute();
                        while ($teacher_rows = $teacher_stmt->fetch(PDO::FETCH_ASSOC)) {
                          echo '<option value="'.$teacher_rows["teacher_id"].'" '. (($teacher == $teacher_rows["teacher_id"]) ? '"selected"' : "") .'>'.$teacher_rows["teacher_title"].''.$teacher_rows["teacher_firstname"].' '.$teacher_rows["teacher_lastname"].'</option>';
                        }
                      echo '</select>
                  </div>
                </div>
               '; ?>
          <button class="btn btn-primary btn-block center-block" for="changeClassForm" type="submit" name="send" value="true">ยืนยัน</button>
        </form>
      </div>
      <!-- /.row -->
      <div class="row" style="padding-top: 20px;padding-bottom: 20px;"></div>
    </div>
    <!-- /#page-wrapper -->
  </div>  
  <!-- /#wrapper -->

  <?php include_once("js.inc.php"); ?>
  <script>

  </script>
  <?php $conn = null ?>
</body>