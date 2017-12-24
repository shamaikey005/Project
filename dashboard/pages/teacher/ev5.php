<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_POST["send"] == 1) {
      echo "hello";
    }
  }
?>
<?php 
  $id = (int)$_GET['sc'];
  $part = (int)$_GET['p']; 

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
                    <p><?php echo 'ชั้น ป.' . $class_res["class_grade"] . ' ห้อง ' . $class_res["class_room"] . ($part < 8 ? '<br> ช่องที่ ' . $part : '<br> ปลายภาค'); ?></p>
                    <form method="post">
                      <table class="table table-hover">
                        <tr>
                          <th>เลขที่</th>
                          <th>ชื่อ - นามสกุล</th>
                          <th>คะแนน</th>
                        </tr>
                        <?php 
                          $stmt = $conn->prepare('SELECT * FROM `score_detail` AS sd
                                                  INNER JOIN `score` AS sc ON sc.score_id = sd.score_id
                                                  INNER JOIN `student` AS st ON st.student_id = sc.student_id
                                                  WHERE sc.schedule_id = :sc  AND sd.scored_part = :p
                                                ');
                          $stmt->execute(array(':sc'=>$id, ':p'=>$part));
                          while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>
                                    <td><span class="form-control-static">'.$rows["student_id"].'</span></td>
                                    <td><span class="form-control-static">'.$rows["student_firstname"]. ' ' . $rows["student_lastname"] .'</span></td>
                                    <td><input class="form-control" type="number" min="0" max="'.$rows["scored_max"].'" value="'.$rows["scored_point"].'"></input></td>
                                  </tr>';
                          }
                        ?>
                      </table>
                      <button class="btn btn-primary pull-right" type="submit" name="confirm" value="1">ยืนยัน</button>
                    </form>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->


  </div>  
  <!-- /#wrapper -->

  <?php include_once("js.inc.php"); ?>
</body>