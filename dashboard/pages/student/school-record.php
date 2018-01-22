<?php include_once("../../../lib/conn.php") ?>
<?php include_once("../../../lib/Func.php") ?>
<?php 
  ob_start();
  include_once("../../../components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "ผลการเรียน";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>

<?php

  $func = new Func();

  $year_stmt = $conn->prepare("SELECT DISTINCT `sch`.`year`, `sch`.`term` FROM `schedule` AS `sch`
                               INNER JOIN `student` AS `st` ON `st`.`class_id` = `sch`.`class_id`
                               WHERE `st`.`student_id` = :stid
                               ORDER BY `sch`.`year` ASC, `sch`.`term` ASC
                              ");
  $year_stmt->bindParam(":stid", $_SESSION["id"]);
  $year_stmt->execute();
  
?>

<body>

  <div id="wrapper">

    <!-- Navigation -->
    <?php include_once('nav-student.php') ?>

    <div id="page-wrapper">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">ผลการเรียน</h1>
          <div class="col-xs-12">
            <?php 
              $cgpa = 0;
              $count = 0;
              while ($year_rows = $year_stmt->fetch(PDO::FETCH_ASSOC)) {
                $grade = 0;
                $credit = 0;
                $gpa = 0;
                echo '<div class="well">
                        <h4>ปีการศึกษา '.($year_rows["year"] + 543).' - เทอม '.$year_rows["term"].'</h4>
                        <table class="table table-hover table-condensed table-responsive" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>รหัสวิชา</th>
                              <th>ชื่อวิชา</th>
                              <th>น้ำหนัก</th>
                              <th>เกรด</th>
                            </tr>
                          </thead>
                          <tbody>
                        ';
                $grade_stmt = $conn->prepare("SELECT * FROM `score` AS `sc`
                                              INNER JOIN `subjects` AS `sj` ON `sj`.`subjects_id` = `sc`.`subjects_id`
                                              INNER JOIN `student` AS `st` ON `st`.`student_id` = `sc`.`student_id`
                                              INNER JOIN `schedule` AS `sch` ON `sch`.`schedule_id` = `sc`.`schedule_id`
                                              WHERE `sc`.`student_id` = :stid AND `sch`.`year` = :year AND `sch`.`term` = :term
                                              ORDER BY `sch`.`year` ASC, `sch`.`term` ASC, `sj`.`subjects_type` ASC");
                $grade_stmt->bindParam(":stid", $_SESSION["id"]);
                $grade_stmt->bindParam(":year", $year_rows["year"]);
                $grade_stmt->bindParam(":term", $year_rows["term"]);
                $grade_stmt->execute();
                while ($grade_rows = $grade_stmt->fetch(PDO::FETCH_ASSOC)) {
                  $grade += (($grade_rows["status"] == 2 || $grade_rows["status"] == 3) ? (isset($grade_rows["score_score"]) ? ((($grade_rows["subjects_type"] == 1 || $grade_rows["subjects_type"] == 2) ? $func->grade($grade_rows["score_score"]) : 0) * $grade_rows["subjects_credit"]) : 0) : 0);
                  $credit += (($grade_rows["status"] == 2 || $grade_rows["status"] == 3) ? (($grade_rows["subjects_type"] == 1 || $grade_rows["subjects_type"] == 2) ? $grade_rows["subjects_credit"] : 0) : 0);
                  echo '<tr>
                          <td>'.$grade_rows["subjects_id"].'</td>
                          <td>'.$grade_rows["subjects_name"].'</td>
                          <td>'.$grade_rows["subjects_credit"].'</td>
                          <td>'.(($grade_rows["status"] == 2 || $grade_rows["status"] == 3) ? (($grade_rows["subjects_type"] == 1 || $grade_rows["subjects_type"] == 2) ? $func->grade($grade_rows["score_score"]) : $func->grade2($grade_rows["score_score"])) : "-" ).'</td>
                        </tr>';
                }
                        
                echo '</tbody></table>';
                try { $gpa = (($grade != 0 || $credit != 0) ? ($grade / $credit) : ""); } catch (PDOException $e) {}
                echo '
                        <p class="text-right">เกรดเฉลี่ย : '.round($gpa, 2).'</p>
                    ';
                echo '</div>';
                $cgpa += $gpa;
                $count++;
              }
            ?>
          </div>
          <div class="col-xs-12">
            <div class="well well-sm">
              <h4 class="text-right">
                เกรดเฉลี่ยรวม : <?php echo ($cgpa / $count); ?>
              </h4>
            </div>
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
