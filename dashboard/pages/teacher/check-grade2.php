<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php 
  ob_start();
  include_once(dirname(__DIR__, 3)."/components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "เกรดรวม";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>
<?php

  $func = new Func();

  $cid = $_GET["c"];
  $year = $_GET["y"];
  $term = $_GET["t"];

  $class_stmt = $conn->prepare("SELECT * FROM `class` WHERE `class_id` = :cid");
  $class_stmt->bindParam(":cid", $cid);
  $class_stmt->execute();
  $class_row = $class_stmt->fetch(PDO::FETCH_ASSOC);

  $student_stmt = $conn->prepare("SELECT * FROM `student` WHERE `class_id` = :cid ORDER BY `student_num` ASC");
  $student_stmt->bindParam(":cid", $cid);
  $student_stmt->execute();

  $subjects_stmt = $conn->prepare("SELECT DISTINCT `s`.*, `sch`.*, `c`.* FROM `subjects` AS `s` 
                                    INNER JOIN `schedule` AS `sch` ON `sch`.`subjects_id` = `s`.`subjects_id`
                                    INNER JOIN `class` AS `c` ON `c`.`class_id` = `sch`.`class_id`
                                    WHERE `c`.`class_id` = :cid AND `sch`.`year` = :year AND `sch`.`term` = :term 
                                    ORDER BY `s`.`subjects_type` ASC, `s`.`subjects_id` ASC");
  $subjects_stmt->bindParam(":cid", $cid);
  $subjects_stmt->bindParam(":year", $year);
  $subjects_stmt->bindParam(":term", $term);
  $subjects_stmt->execute();

?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include_once('nav-teacher.php') ?>

        <div id="page-wrapper">
          <div class="row">
            <div class="col-lg-12">
              <h1 class="page-header">เกรดรวม</h1>
              <ul class="breadcrumb">
                <li><a href="check-grade.php">เกรดรวม</a></li>
                <li class="active">ชั้น ป.<?php echo $class_row["class_grade"].' ห้อง '.($class_row["class_room"]); echo ' - เทอม '.$term.' - ปีการศึกษา ' . ($year+543); ?></li>
              </ul>
              <div class="col-xs-12">
                <table id="data_table" class="table table-hover table-condensed table-responsive" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>เลขที่</th>
                      <th>ชื่อ - นามสกุล</th>
                      <?php 
                        while ($subjects_rows = $subjects_stmt->fetch(PDO::FETCH_ASSOC)) {
                          echo '
                            <th>'.$subjects_rows["subjects_name"].'</th>
                          ';
                        }
                      ?>
                      <th>GPA</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      
                      while ($student_rows = $student_stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '
                          <tr>
                            <th>'.$student_rows["student_num"].'</th>
                            <td>'.$student_rows["student_firstname"].' '.$student_rows["student_lastname"].'</td>
                          
                        ';
                        $grade = 0;
                        $credit = 0;
                        $gpa = 0;
                        $grade_stmt = $conn->prepare("SELECT * FROM `score` AS `sc`
                                                      INNER JOIN `subjects` AS `s` ON `s`.`subjects_id` = `sc`.`subjects_id`                                                
                                                      INNER JOIN `schedule` AS `sch` ON `sch`.`schedule_id` = `sc`.`schedule_id`
                                                      WHERE `sc`.`student_id` = :stid AND `sch`.`year` = :year AND `sch`.`term` = :term
                                                      ORDER BY `s`.`subjects_type` ASC, `s`.`subjects_id` ASC");
                        $grade_stmt->bindParam(":stid", $student_rows["student_id"]);
                        $grade_stmt->bindParam(":year", $year);
                        $grade_stmt->bindParam(":term", $term);
                        $grade_stmt->execute();
                        while ($grade_rows = $grade_stmt->fetch(PDO::FETCH_ASSOC)) {
                          $grade += (($grade_rows["status"] == 2 || $grade_rows["status"] == 3) ? (isset($grade_rows["score_score"]) ? ((($grade_rows["subjects_type"] == 1 || $grade_rows["subjects_type"] == 2) ? $func->grade($grade_rows["score_score"]) : 0) * $grade_rows["subjects_credit"]) : 0) : 0);
                          $credit += (($grade_rows["status"] == 2 || $grade_rows["status"] == 3) ? (($grade_rows["subjects_type"] == 1 || $grade_rows["subjects_type"] == 2) ? $grade_rows["subjects_credit"] : 0) : 0);
                          echo '<td>'.(($grade_rows["status"] == 2 || $grade_rows["status"] == 3) ? (($grade_rows["subjects_type"] == 1 || $grade_rows["subjects_type"] == 2) ? $func->grade($grade_rows["score_score"]) : $func->grade2($grade_rows["score_score"])) : "-" ).'</td>';
                        }
                        try { $gpa = (($grade != 0 || $credit != 0) ? ($grade / $credit) : ""); } catch (PDOException $e) {}
                        echo '<td>'.round($gpa, 2).'</td></tr>';
                      }
                    ?>
                  </tbody>
                </table>
            </div>
            </div>
            <!-- /.col-lg-12 -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- include js -->
    <?php include_once('js.inc.php') ?>

</body>

</html>
