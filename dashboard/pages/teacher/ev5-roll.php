<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php 
  $r = (int)$_GET['r'];
  $cl = $_GET["c"];
  $row_count;

  $class = $conn->prepare("SELECT * FROM class AS c INNER JOIN roll AS r ON r.class_id = c.class_id WHERE c.class_id = :cl");
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
            'rsl' => $_POST["rsl"][$stid],
            'rpl' => $_POST["rpl"][$stid],
            'rab' => $_POST["rab"][$stid],
            'rat' => $_POST["rat"][$stid]
          );

          $conn->exec("UPDATE `roll_detail` SET 
                      `roll_sick_leave` = ".$res[$key]["rsl"].",
                      `roll_personal_leave` = ".$res[$key]["rpl"].",
                      `roll_absent` = ".$res[$key]["rab"].",
                      `roll_attend` = ".$res[$key]["rat"]."
                      WHERE `roll_id` = '".$r."' AND `student_id` = '".$key."'");
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
                            <th>ลาป่วย</th>
                            <th>ลากิจ</th>
                            <th>ขาดเรียน</th>
                            <th>มาเรียน</th>
                          </tr>      
                        </thead>
                        <tbody>
                      <?php 
                        $stmt = $conn->prepare(
                          "SELECT * FROM `roll_detail` AS rd
                          INNER JOIN `student` AS st ON st.student_id = rd.student_id
                          INNER JOIN `roll` AS r ON r.roll_id = rd.roll_id
                          WHERE rd.roll_id = :rid");
                        $stmt->execute(array(':rid'=>$r));
                        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                          echo '<tr>
                                  <td><input type="hidden" name="stid[]" value="'.$rows["student_id"].'"><p class="form-control-static">'.$rows["student_num"].'</p></td>
                                  <td><p class="form-control-static"> '.$rows["student_firstname"].' '.$rows["student_lastname"].'</p></td>
                                  <td><input class="form-control" type="number" name="rsl[]" min="0" value="'.$rows["roll_sick_leave"].'"></td>
                                  <td><input class="form-control" type="number" name="rpl[]" min="0" value="'.$rows["roll_personal_leave"].'"></td>
                                  <td><input class="form-control" type="number" name="rab[]" min="0" value="'.$rows["roll_absent"].'"></td>
                                  <td><input class="form-control" type="number" name="rat[]" min="0" value="'.$rows["roll_attend"].'"></td>
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