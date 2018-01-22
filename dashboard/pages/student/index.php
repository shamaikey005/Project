<?php include_once("../../../lib/conn.php") ?>
<?php include_once("../../../lib/Func.php") ?>
<?php 
  ob_start();
  include_once("../../../components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "หน้าหลัก";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>
<?php 
  $func = new Func();

  $student_stmt = $conn->prepare("SELECT * FROM `student` AS `st` INNER JOIN `class` AS `c` ON `c`.`class_id` = `st`.`class_id` WHERE `student_id` = :stid");
  $student_stmt->bindParam(":stid", $_SESSION["id"]);
  $student_stmt->execute();
  $rows = $student_stmt->fetch(PDO::FETCH_ASSOC);
?>

<body>

    <div id="wrapper">
        
         <!-- /.navbar-header -->
        <?php include_once('nav-student.php') ?>
             
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                  <h1 class="page-header">หน้าหลัก</h1>
                  <form class="form-horizontal">
                    <div class="form-group">
                      <label for="c11" class="col-xs-3 control-label">UID</label>
                      <div class="col-xs-9">
                          <input type="text" class="form-control" value="<?php echo $rows["user_id"]; ?>" readonly />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="c12" class="col-xs-3 control-label">SID</label>
                      <div class="col-xs-9">
                        <input type="text" class="form-control" value="<?php echo $rows["student_id"]; ?>" readonly />
                      </div>
                    </div>
                    <hr />
                      
                      <div class="form-group">
                        <label for="c14-1" class="col-xs-3 control-label">ชื่อ-นามสกุล</label>
                        <div class="col-xs-9">
                          <div class="row">
                            <div class="col-xs-6">
                              <input type="text" class="form-control" value="<?php echo $rows["student_firstname"]; ?>" readonly />
                            </div>
                            <div class="col-xs-6">
                              <input type="text" class="form-control" value="<?php echo $rows["student_lastname"]; ?>" readonly />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="c12" class="col-xs-3 control-label">เพศ</label>
                        <div class="col-xs-9">
                          <input type="text" class="form-control" value="<?php echo $func->checkSex($rows["student_sex"]); ?>" readonly />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="c15" class="col-xs-3 control-label">วันเกิด</label>
                        <div class="col-xs-9">
                          <input type="date" class="form-control" value="<?php echo $rows["student_birthday"]; ?>" readonly />
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="c16" class="col-xs-3 control-label">ที่อยู่</label>
                        <div class="col-xs-9">
                          <textarea class="form-control" rows="4" readonly><?php echo $rows["student_address"]; ?></textarea>
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

</html>
