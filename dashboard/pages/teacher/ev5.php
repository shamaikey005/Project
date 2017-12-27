<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["send"])) {
      try {
        $conn->beginTransaction();
        foreach($_POST["sid"] as $sid) {
          $count = 0;
          for ($i = 1; $i <= 8; $i++) {
            $s_name = "s" . $i;
            $s_part = $i;
            $score = $_POST[$s_name][$count];
            $conn->exec(
              "UPDATE score_detail 
              SET scored_point = $score 
              WHERE score_id = $sid AND scored_part = $s_part"
            );
          }
          $count++;
        }

        $conn->commit();

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
                    <?php 
                      $stmt = $conn->prepare(
                        "SELECT * FROM score AS s
                         INNER JOIN student AS st ON s.student_id = st.student_id
                         WHERE s.schedule_id = :sc
                      ");
                      $stmt->execute(array(":sc"=>$id));
                      $row_count = $stmt->rowCount();
                      echo '<table class="table table-hover">
                              <thead><tr>
                                <th>เลขที่</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th>ช่องที่ 1 (10)</th>
                                <th>ช่องที่ 2 (10)</th>
                                <th>ช่องที่ 3 (10)</th>
                                <th>ช่องที่ 4 (10)</th>
                                <th>ช่องที่ 5 (10)</th>
                                <th>ช่องที่ 6 (10)</th>
                                <th>ช่องที่ 7 (10)</th>
                                <th>ปลายภาค (30)</th>
                              </tr>
                              </thead><tbody>
                            ';
                      while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $stmt2 = $conn->prepare("SELECT * FROM score_detail WHERE score_id = :score_id");
                        $stmt2->execute(array("score_id"=>$rows["score_id"]));
                        $i = 1;
                        echo '
                        <tr>
                          <td><p class="form-control-static">'.$rows["student_id"].'</p><input type="hidden" name="sid[]" value="'.$rows["score_id"].'"></td>
                          <td><p class="form-control-static">'.$rows["student_firstname"]. ' '. $rows["student_lastname"] .'</p></td>';
                          while ($rows2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                            echo '<td><input class="form-control" type="number" max="'.$rows2["scored_max"].'" min="0" name="s'.$i.'[]" value="'.$rows2["scored_point"].'"></td>';
                            $i++;
                          }
                        echo '</tr>';
                      }
                      echo '</tbody></table>';
                    ?>
                    <button class="btn btn-primary btn-block center-block" type="submit" name="send" value="true">ยืนยัน</button>
                    </form>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->


  </div>  
  <!-- /#wrapper -->

  <?php include_once("js.inc.php"); ?>
  <?php $conn = null ?>
</body>