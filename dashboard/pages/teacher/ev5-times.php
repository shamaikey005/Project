<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["send"])) {
      try {

        $scid = $_POST["scid"];
        $conn->beginTransaction();
        foreach (array_combine($_POST["sid"], $_POST["st"]) as $sid => $st) {
          $conn->exec("UPDATE `period` SET period_count = $st WHERE student_id = '$sid' AND schedule_id = $scid");
        }
        $conn->commit();
        $user->redirect("Evaluation-5.php");

      } catch(PDOException $e) {

        $conn->rollback();
        echo "Error : Can't update score!" . $e->getMessage();

      }
    }
  }
?>
<?php 
  $id = (int)$_GET['sc'];
  $row_count;

  $class = $conn->prepare("SELECT * FROM class AS c INNER JOIN schedule AS sc ON sc.class_id = c.class_id WHERE sc.schedule_id = :sc");
  $class->execute(array(':sc'=>$id));
  $class_res = $class->fetch(PDO::FETCH_ASSOC);

?>
<?php 
  ob_start();
  include_once(dirname(__DIR__, 3)."/components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "ปพ.5 - แก้ไข";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>

<body>

  <div id="wrapper">

    <!-- Navigation -->
    <?php include_once('nav-teacher.php') ?>

    <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ปพ.5 - จัดการ</h1>
                    <ul class="breadcrumb">
                      <li><a href="Evaluation-5.php">ปพ.5</a></li>
                      <li class="active">ปพ.5 - จัดการ</li>
                    </ul>
                    <p><?php echo 'ชั้น ป.' . $class_res["class_grade"] . ' ห้อง ' . $class_res["class_room"]; ?></p>
                    <form method="post">      
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>เลขที่</th>
                            <th>ชื่อ - นามสกุล</th>
                            <th>จำนวนชั่วโมง</th>
                          </tr>      
                        </thead>
                        <tbody>
                      <?php 
                        $stmt = $conn->prepare(
                          "SELECT * FROM `period` AS p
                          INNER JOIN student AS st ON st.student_id = p.student_id
                          INNER JOIN schedule AS sc ON sc.schedule_id = p.schedule_id
                          WHERE p.schedule_id = :scid");
                        $stmt->execute(array(':scid'=>$id));
                        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          echo '<tr>
                                  <td><input type="hidden" name="sid[]" value="'.$rows["student_id"].'">'.$rows["student_id"].'</td>
                                  <td>'.$rows["student_firstname"].' '.$rows["student_lastname"].'</td>
                                  <td><input class="form-control" type="number" name="st[]" min="0" max="'.$rows["period_max"].'" value="'.$rows["period_count"].'"></td>
                                  <input type="hidden" name="scid" value="'.$id.'">
                                </tr>';   
                        }
                      ?>  
                      </tbody>
                      </table>     
                    <button class="btn btn-primary btn-block center-block" type="submit" name="send" value="true">ยืนยัน</button>
                    </form>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row" style="padding-top: 20px;padding-bottom: 20px;"></div>
        </div>
        <!-- /#page-wrapper -->

  </div>  
  <!-- /#wrapper -->

  <?php include_once("js.inc.php"); ?>
  <?php $conn = null ?>
</body>