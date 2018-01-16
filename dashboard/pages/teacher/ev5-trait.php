<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php 
  $tr = (int)$_GET['tr'];
  $cl = $_GET["c"];
  $row_count;

  $class = $conn->prepare("SELECT * FROM class AS c INNER JOIN trait AS tr ON tr.class_id = c.class_id WHERE c.class_id = :cl");
  $class->execute(array(':cl'=>$cl));
  $class_res = $class->fetch(PDO::FETCH_ASSOC);

?>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["send"])) {
      try {
        $res = array();
        $conn->beginTransaction();
        foreach( $_POST["stid"] as $stid => $key ) {
          $res[$key] = array(
            'tr1' => $_POST["tr1"][$stid],
            'tr2' => $_POST["tr2"][$stid],
            'tr3' => $_POST["tr3"][$stid],
            'tr4' => $_POST["tr4"][$stid],
            'tr5' => $_POST["tr5"][$stid],
            'tr6' => $_POST["tr6"][$stid],
            'tr7' => $_POST["tr7"][$stid],
            'tr8' => $_POST["tr8"][$stid],
            'tr_rw' => $_POST["tr_rw"][$stid]
          );

          $conn->exec("UPDATE `trait_detail` SET 
                      `trait_1` = ".$res[$key]["tr1"].",
                      `trait_2` = ".$res[$key]["tr2"].",
                      `trait_3` = ".$res[$key]["tr3"].",
                      `trait_4` = ".$res[$key]["tr4"].",
                      `trait_5` = ".$res[$key]["tr5"].",
                      `trait_6` = ".$res[$key]["tr6"].",
                      `trait_7` = ".$res[$key]["tr7"].",
                      `trait_8` = ".$res[$key]["tr8"].",
                      `trait_readwrite` = ".$res[$key]["tr_rw"]."
                      WHERE `trait_id` = '".$tr."' AND `student_id` = '".$key."'");
        }

        $conn->commit();
        $user->redirect("Evaluation-5.php");

      } catch(PDOException $e) {

        $conn->rollback();
        echo 'ERROR : ' . $e->getMessage();

      }
    }
  }
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
                  <th>ข้อ 1</th>
                  <th>ข้อ 2</th>
                  <th>ข้อ 3</th>
                  <th>ข้อ 4</th>
                  <th>ข้อ 5</th>
                  <th>ข้อ 6</th>
                  <th>ข้อ 7</th>
                  <th>ข้อ 8</th>
                  <th>อ่าน-เขียน</th>
                </tr>      
              </thead>
              <tbody>
              <?php 
                $stmt = $conn->prepare(
                  "SELECT * FROM `trait_detail` AS trd
                  INNER JOIN `student` AS st ON st.student_id = trd.student_id
                  INNER JOIN `trait` AS tr ON tr.trait_id = trd.trait_id
                  WHERE trd.trait_id = :trid");
                $stmt->execute(array(':trid'=>$tr));
                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                  echo '<tr>
                          <td><input type="hidden" name="stid[]" value="'.$rows["student_id"].'"><p class="form-control-static">'.$rows["student_num"].'</p></td>
                          <td><p class="form-control-static"> '.$rows["student_firstname"].' '.$rows["student_lastname"].'</p></td>
                          <td><input class="form-control" type="number" name="tr1[]" min="0" max="5" value="'.$rows["trait_1"].'"></td>
                          <td><input class="form-control" type="number" name="tr2[]" min="0" max="5" value="'.$rows["trait_2"].'"></td>
                          <td><input class="form-control" type="number" name="tr3[]" min="0" max="5" value="'.$rows["trait_3"].'"></td>
                          <td><input class="form-control" type="number" name="tr4[]" min="0" max="5" value="'.$rows["trait_4"].'"></td>
                          <td><input class="form-control" type="number" name="tr5[]" min="0" max="5" value="'.$rows["trait_5"].'"></td>
                          <td><input class="form-control" type="number" name="tr6[]" min="0" max="5" value="'.$rows["trait_6"].'"></td>
                          <td><input class="form-control" type="number" name="tr7[]" min="0" max="5" value="'.$rows["trait_7"].'"></td>
                          <td><input class="form-control" type="number" name="tr8[]" min="0" max="5" value="'.$rows["trait_8"].'"></td>
                          <td><input class="form-control" type="number" name="tr_rw[]" min="0" max="5" value="'.$rows["trait_readwrite"].'"></td>
                        </tr>';
                }
              ?>
              </tbody>
            </table>     
            <button class="btn btn-primary btn-block center-block" type="submit" name="send" value="true">ยืนยัน</button>
          </form>

        </div>
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