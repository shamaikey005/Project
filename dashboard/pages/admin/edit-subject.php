<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php
  $sjid = $_GET["id"];
  $type = $_GET["t"];
  $sql = "SELECT * FROM subjects WHERE subjects_id = :sjid"; 
  $stmt = $conn->prepare($sql);
  $stmt->execute(array(":sjid"=>$sjid));
  $rows = $stmt->fetch(PDO::FETCH_ASSOC);
  $type_stmt = $conn->prepare("SELECT * FROM subjects_type");
  $type_stmt->execute();
?>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["send"])) {
      try {
        $stmt = $conn->prepare("UPDATE `subjects` SET
                                `subjects_id` = '".$_POST["sjid"]."',
                                `subjects_name` = '".$_POST["sjname"]."',
                                `subjects_type` = ".$_POST["sjtype"].",
                                `subjects_credit` = ".$_POST["sjcredit"].",
                                `subjects_time` = ".$_POST["sjtime"]."
                                 WHERE `subjects_id` = '". $sjid."'");
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
              <h1 class="page-header">แก้ไขวิชา</h1>
              <ul class="breadcrumb">
                <li><a href="manage-gen.php">จัดการข้อมูลพื้นฐาน</a></li>
                <li class="active">แก้ไขวิชา</li>
              </ul>
              <form class="form-horizontal" method="post" id="changeSubjectForm">
              <?php echo '
                <div class="form-group">
                    <label for="c01" class="col-xs-3 control-label">รหัสวิชา</label>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" name="sjid" id="c01" value="'. $rows["subjects_id"] .'" placeholder="Subject ID" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="c02" class="col-xs-3 control-label">ชื่อวิชา</label>
                    <div class="col-xs-9">
                        <input type="text" class="form-control" name="sjname" id="c02" value="'. $rows["subjects_name"] .'" placeholder="Subject Name" />
                    </div>
                </div>
                <div class="form-group">
                  <label for="c03" class="col-xs-3 control-label">ประเภท</label>
                  <div class="col-xs-9">
                      <select class="form-control" name="sjtype" id="c03">';
                        while ($type_rows = $type_stmt->fetch(PDO::FETCH_ASSOC)) {
                          echo '<option value="'.$type_rows["subjects_type"].'" '. (($type == $type_rows["subjects_type"]) ? '"selected"' : "") .'>'.$type_rows["subjects_type_name"].'</option>';
                        }
                      echo '</select>
                  </div>
                </div>
                <div class="form-group">
                    <label for="c04" class="col-xs-3 control-label">หน่วยกิต</label>
                    <div class="col-xs-9">
                        <input class="form-control" name="sjcredit" id="c04" type="number" min="1" max="5" value="'.$rows["subjects_credit"].'" placeholder="Subjects credit" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="c05" class="col-xs-3 control-label">จำนวนชั่วโมง</label>
                    <div class="col-xs-9">
                        <input class="form-control" name="sjtime" id="c05" type="number" min="0" max="" value="'.$rows["subjects_time"].'" placeholder="จำนวนชั่วโมง" />
                    </div>
                </div>
               '; ?>
          <button class="btn btn-primary btn-block center-block" for="changeSubjectForm" type="submit" name="send" value="true">ยืนยัน</button>
        </form>
      </div>
      <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
  </div>  
  <!-- /#wrapper -->

  <?php include_once("js.inc.php"); ?>
  <script>

  </script>
  <?php $conn = null ?>
</body>