<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php 
  ob_start();
  include_once(dirname(__DIR__, 3)."/components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "หน้าหลัก";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>

<?php
  $teacher_stmt = $conn->prepare("SELECT * FROM `teacher` WHERE `teacher_id` = :tid");
  $teacher_stmt->bindParam(":tid", $_SESSION["id"]);
  $teacher_stmt->execute();
  $rows = $teacher_stmt->fetch(PDO::FETCH_ASSOC);
?>

<body>

  <div id="wrapper">

    <!-- Navigation -->
    <?php include_once('nav-teacher.php') ?>

    <div id="page-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header"> หน้าหลัก</h1>
          <form class="form-horizontal">
            <div class="form-group">
              <label for="c11" class="col-xs-3 control-label">UID</label>
              <div class="col-xs-9">
                  <input type="text" class="form-control" value="<?php echo $rows["user_id"]; ?>" readonly />
              </div>
            </div>
            <div class="form-group">
                <label for="c12" class="col-xs-3 control-label">TID</label>
                <div class="col-xs-9">
                <input type="text" class="form-control" value="<?php echo $rows["teacher_id"]; ?>" readonly />
                </div>
            </div>
            <hr />
            <div class="form-group">
                <label for="c14-0" class="col-xs-3 control-label">คำนำหน้า</label>
                <div class="col-xs-9">
                    <div class="row">
                        <div class="col-xs-6">
                          <input type="text" class="form-control" value="<?php echo $rows["teacher_title"]; ?>" readonly />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="c14-1" class="col-xs-3 control-label">ชื่อ-นามสกุล</label>
                <div class="col-xs-9">
                    <div class="row">
                        <div class="col-xs-6">
                          <input type="text" class="form-control" value="<?php echo $rows["teacher_firstname"]; ?>" readonly />
                        </div>
                        <div class="col-xs-6">
                          <input type="text" class="form-control" value="<?php echo $rows["teacher_lastname"]; ?>" readonly />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="c15" class="col-xs-3 control-label">วันเกิด</label>
                <div class="col-xs-9">
                  <input type="date" class="form-control" value="<?php echo $rows["teacher_birthday"]; ?>" readonly />
                </div>
            </div>
            <div class="form-group">
                <label for="c16" class="col-xs-3 control-label">ที่อยู่</label>
                <div class="col-xs-9">
                    <textarea class="form-control" rows="4" readonly><?php echo $rows["teacher_address"]; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="tel" class="col-xs-3 control-label">เบอร์โทร</label>
                <div class="col-xs-9">
                  <input type="text" class="form-control" value="<?php echo $rows["teacher_tel"]; ?>" readonly />
                </div>
            </div>
          </form>
          
        </div>
        <!-- /.col-lg-12 -->
      </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

  </div>
  <!-- /#wrapper -->

  <?php include_once('js.inc.php') ?>

</body>

</html>
