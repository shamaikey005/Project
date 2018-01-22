<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["send"])) {
      try {
        
        $count = 0;
        $res = array();
        $conn->beginTransaction();
        foreach( $_POST["stid"] as $stid => $key ) {
          $res[$key] = array(
            "sid" => $_POST["sid"][$stid],
            "score" => $_POST["score"][$stid]
          );

          $conn->exec("UPDATE `score_detail_2` SET 
                       `scored_score` = ".$res[$key]["score"]." 
                       WHERE `score_id` = '".$res[$key]["sid"]."' AND `student_id` = '".$key."'");
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
                    <?php 
                      $stmt = $conn->prepare(
                        "SELECT * FROM score AS s
                         INNER JOIN student AS st ON s.student_id = st.student_id
                         INNER JOIN score_detail_2 AS sd2 ON sd2.score_id = s.score_id
                         WHERE s.schedule_id = :sc
                      ");
                      $stmt->execute(array(":sc"=>$id));
                      $row_count = $stmt->rowCount();
                      echo '<table class="table table-hover">
                              <thead><tr>
                                <th>เลขที่</th>
                                <th>ชื่อ - นามสกุล</th>
                                <th>คะแนน</th>
                              </tr>
                              </thead><tbody>
                            ';
                      while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $stmt2 = $conn->prepare("SELECT * FROM score_detail_2 WHERE score_id = :score_id");
                        $stmt2->execute(array("score_id"=>$rows["score_id"]));
                        echo '
                          <tr>
                            <td><p class="form-control-static">'.$rows["student_num"].'</p><input type="hidden" name="sid[]" value="'.$rows["score_id"].'"><input type="hidden" name="stid[]" value="'.$rows["student_id"].'"></td>
                            <td><p class="form-control-static">'.$rows["student_firstname"]. ' '. $rows["student_lastname"] .'</p></td>
                            <td>
                              <select class="form-control" name="score[]" required>
                                <option value="1" '.(($rows["scored_score"] == 1) ? "selected" : "").'>ผ่าน</option>
                                <option value="2" '.(($rows["scored_score"] == 2) ? "selected" : "").'>ไม่ผ่าน</option>
                              </select>
                            </td>';
                        echo '</tr>';
                      }
                      echo '</tbody></table>';
                    ?>
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