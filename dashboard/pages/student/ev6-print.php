<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php 
  ob_start();
  include_once(dirname(__DIR__, 3)."/components/head-print.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "ปพ.6";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>
<?php
  $func = new Func();

  $st = $_GET["st"];
  $year = $_GET["y"];

  $student_stmt = $conn->prepare("SELECT * FROM `student` AS `st` 
                                  INNER JOIN `class` AS `c` ON `c`.`class_id` = `st`.`class_id`
                                  WHERE `st`.`student_id` = :stid");
  $student_stmt->bindParam(":stid", $st);
  $student_stmt->execute();
  $student_rows = $student_stmt->fetch(PDO::FETCH_ASSOC);

  $teacher_stmt = $conn->prepare("SELECT * FROM `teacher` AS `t`
                                  INNER JOIN `class` AS `c` ON `c`.`teacher_id` = `t`.`teacher_id`
                                  INNER JOIN `student` AS `st` ON `st`.`class_id` = `c`.`class_id`
                                  WHERE `st`.`student_id` = :stid");
  $teacher_stmt->bindParam(":stid", $st);
  $teacher_stmt->execute();
  $teacher_rows = $teacher_stmt->fetch(PDO::FETCH_ASSOC);

  try { 
    $roll_1_stmt = $conn->prepare("SELECT * FROM `roll` AS `r`
                                  INNER JOIN `roll_detail` AS `rd` ON `rd`.`roll_id` = `r`.`roll_id`
                                  INNER JOIN `student` AS `st` ON `st`.`student_id` = `rd`.`student_id`
                                  WHERE `st`.`student_id` = :stid AND `r`.`year` = :year AND `r`.`term` = 1");
    $roll_1_stmt->bindParam(":stid", $st);
    $roll_1_stmt->bindParam(":year", $year);
    $roll_1_stmt->execute();
    $roll_1_rows = $roll_1_stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {

  }

  try {
    $roll_2_stmt = $conn->prepare("SELECT * FROM `roll` AS `r`
                                  INNER JOIN `roll_detail` AS `rd` ON `rd`.`roll_id` = `r`.`roll_id`
                                  INNER JOIN `student` AS `st` ON `st`.`student_id` = `rd`.`student_id`
                                  WHERE `st`.`student_id` = :stid AND `r`.`year` = :year AND `r`.`term` = 2");
    $roll_2_stmt->bindParam(":stid", $st);
    $roll_2_stmt->bindParam(":year", $year);
    $roll_2_stmt->execute();
    $roll_2_rows = $roll_2_stmt->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {

  }

?>

<body class="A4">

  <nav class="navbar navbar-inverse navbar-top navbar-fixed-bottom" style="border-radius: 0;">
    <div class="container-fluid">
      <h3 class="navbar-text">ปพ.6 ปีการศึกษา <?php echo $year+543; ?>  : <?php echo $student_rows["student_firstname"] . " " . $student_rows["student_lastname"] ?></h3>
      <button class="btn btn-primary navbar-btn pull-right" id="printBtn" style="font-size: 18px;"><i class="fas fa-print fa-fw"></i> Print</button>
    </div>
  </nav>

  <section class="sheet padding-10mm">
    <article class="row">

      <div class="col-xs-12">
        <img class="" src="../../../assets/img/logo.png" width="100" height="100" alt="logo" style="position: absolute;">
        <div class="col-xs-12" style="padding-left: 3mm;font-size: 20px;font-weight: bold;">
          <div class="col-xs-12 text-center">
            <span class="">รายงานการพัฒนาคุณภาพผู้เรียนเป็นรายบุคคล</span>
          </div>
          <div style="position: absolute;right: 5mm;">
            <span>ปพ.6</span>
          </div>
        </div>

        <div class="col-xs-12">
          <div class="col-xs-12 text-center" style="font-size: 18px;font-weight: bold;">
            <span class="">โรงเรียนประชาภิบาล</span>
          </div>
        </div>

        <div class="col-xs-12">
          <div class="col-xs-2 col-xs-offset-2 text-right">
            <span class="" style="font-size: 16px;font-weight: bold;">ชื่อ - สกุล</span>
          </div>
          <div class="col-xs-4 text-center" style="font-size: 16px;">
            <span><?php echo (($student_rows["student_sex"] == 1) ? "เด็กชาย" : "เด็กหญิง"); echo $student_rows["student_firstname"]." ".$student_rows["student_lastname"] ?></span>
          </div>
          <div class="col-xs-2 text-right">
            <span class="" style="font-size: 16px;font-weight: bold;">เลขประจำตัว</span>
          </div>
          <div class="col-xs-2 text-center" style="font-size: 16px;">
            <span><?php echo $student_rows["student_id"]; ?></span>
          </div>
        </div>

        <div class="col-xs-12">
          <div class="col-xs-2 col-xs-offset-2 text-right">
            <span class="" style="font-size: 16px;font-weight: bold;">ชั้นประถมศึกษาปีที่</span>
          </div>
          <div class="col-xs-1" style="font-size: 16px;">
            <span><?php echo $student_rows["class_grade"]."/".$student_rows["class_room"]; ?></span>
          </div>
          <div class="col-xs-1 text-right">
            <span class="" style="font-size: 16px;font-weight: bold;">เลขที่</span>
          </div>
          <div class="col-xs-1 text-center">
            <span class="" style="font-size: 16px;"><?php echo $student_rows["student_num"] ?></span></span>
          </div>
          <div class="col-xs-2 col-xs-offset-1 text-right">
            <span class="" style="font-size: 16px;font-weight: bold;">ปีการศึกษา</span>
          </div>
          <div class="col-xs-2 text-center" style="font-size: 16px;">
            <span><?php echo $year+543; ?></span>
          </div>
        </div>

        <div class="col-xs-12">
          <table width="100%">
            <thead>
              <tr>
                <th>เวลาเรียน</th>
                <th>ป่วย (วัน)</th>
                <th>ลา (วัน)</th>
                <th>ขาด (วัน)</th>
                <th>มาเรียน (วัน)</th>
                <th>รวมมาเรียนตลอดปี</th>
                <th>คิดเป็นร้อยละ</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>ภาคเรียนที่ 1</td>
                <td><?php echo $roll_1_rows["roll_sick_leave"] ?></td>
                <td><?php echo $roll_1_rows["roll_personal_leave"] ?></td>
                <td><?php echo $roll_1_rows["roll_absent"] ?></td>
                <td><?php echo $roll_1_rows["roll_attend"] ?></td>
                <td rowspan="2"><?php echo ($roll_1_rows["roll_attend"] + $roll_2_rows["roll_attend"]); ?></td>
                <td rowspan="2"><?php echo (($roll_1_rows["roll_attend"] + $roll_2_rows["roll_attend"]) * 100 / 200); ?></td>
              </tr>
              <tr>
                <td>ภาคเรียนที่ 2</td>
                <td><?php echo $roll_2_rows["roll_sick_leave"] ?></td>
                <td><?php echo $roll_2_rows["roll_personal_leave"] ?></td>
                <td><?php echo $roll_2_rows["roll_absent"] ?></td>
                <td><?php echo $roll_2_rows["roll_attend"] ?></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12 text-center" style="font-size: 16px;font-weight: bold;">
          <span>ผลการประเมินสาระการเรียนรู้</span>
        </div>

        <div class="col-xs-12">
          <table width="100%">
            <thead>
              <tr>
                <th rowspan="2">ที่</th>
                <th rowspan="2" colspan="3">รายวิชา</th>
                <th rowspan="2">รหัสวิชา</th>
                <th rowspan="2">น้ำหนัก</th>
                <th>คะแนน</th>
                <th>คะแนน</th>
                <th>ระดับ</th>
                <th rowspan="2">หมายเหตุ</th>
              </tr>
              <tr>
                <th>ภาคเรียนที่ 1</th>
                <th>ภาคเรียนที่ 2</th>
                <th>ผลการเรียน</th>
              </tr>
            </thead>
            <tbody>
            <?php
              $subjects_stmt = $conn->prepare("SELECT DISTINCT `s`.*, `sch`.`year`, `sch`.`class_id`, `st`.* FROM `subjects` AS `s` 
                                                INNER JOIN `schedule` AS `sch` ON `sch`.`subjects_id` = `s`.`subjects_id`
                                                INNER JOIN `student` AS `st` ON `st`.`class_id` = `sch`.`class_id`
                                                WHERE `st`.`student_id` = :stid AND `sch`.`year` = :year AND (`s`.`subjects_type` = 1 OR `s`.`subjects_type` = 2) AND (`sch`.`status` = 2 OR `sch`.`status` = 3) 
                                                ORDER BY `s`.`subjects_type` ASC, `s`.`subjects_id` ASC");
              $subjects_stmt->bindParam(":stid", $st);
              $subjects_stmt->bindParam(":year", $year);
              $subjects_stmt->execute();
              $subjects_count = 0;
              $subjects_time = 0;
              $grade = 0;
              $credit = 0;
              $gpa = 0;
              $cgpa = 0;
              while ($subjects_rows = $subjects_stmt->fetch(PDO::FETCH_ASSOC)) {
                $subjects_time += $subjects_rows["subjects_time"];
                echo '<tr></tr><th>'.(($subjects_count)+1).'</th>
                      <td colspan="3">'.$subjects_rows["subjects_name"].'</td>
                      <td>'.$subjects_rows["subjects_id"].'</td>
                      <td>'.$subjects_rows["subjects_credit"].'</td>';

                $score_1_stmt = $conn->prepare("SELECT * FROM `score` AS `s` 
                                                INNER JOIN `schedule` AS `sc` ON `sc`.`schedule_id` = `s`.`schedule_id` 
                                                WHERE `s`.`student_id` = :stid AND `sc`.`subjects_id` = :sid AND `sc`.`year` = :year AND `sc`.`term` = 1 AND (`sc`.`status` = 2 OR `sc`.`status` = 3)");
                $score_1_stmt->bindParam(":stid", $st);
                $score_1_stmt->bindParam(":sid", $subjects_rows["subjects_id"]);
                $score_1_stmt->bindParam(":year", $subjects_rows["year"]);
                $score_1_stmt->execute();
                $score_1_rows = $score_1_stmt->fetch(PDO::FETCH_ASSOC);
                $score_2_stmt = $conn->prepare("SELECT * FROM `score` AS `s` 
                                                INNER JOIN `schedule` AS `sc` ON `sc`.`schedule_id` = `s`.`schedule_id` 
                                                WHERE `s`.`student_id` = :stid AND `sc`.`subjects_id` = :sid AND `sc`.`year` = :year AND `sc`.`term` = 2 AND (`sc`.`status` = 2 OR `sc`.`status` = 3)");
                $score_2_stmt->bindParam(":stid", $st);
                $score_2_stmt->bindParam(":sid", $subjects_rows["subjects_id"]);
                $score_2_stmt->bindParam(":year", $subjects_rows["year"]);
                $score_2_stmt->execute();
                $score_2_rows = $score_2_stmt->fetch(PDO::FETCH_ASSOC);
                $grade = $func->grade(isset($score_2_rows["score_score"]) ? (($score_1_rows["score_score"] + $score_2_rows["score_score"])/2) : $score_1_rows["score_score"]);
                $credit += $subjects_rows["subjects_credit"];
                $gpa += ($grade * $subjects_rows["subjects_credit"]);
                echo 
                  '<td>'.$score_1_rows["score_score"].'</td>
                   <td>'.$score_2_rows["score_score"].'</td>
                   <td>'.$grade.'</td>';
                echo '<td>'.$func->checkSubjectsType($subjects_rows["subjects_type"]).'</td></tr>';
                $subjects_count++;
              }
              try { $cgpa = (($gpa != 0 || $credit != 0) ? ($gpa / $credit) : ""); } catch (PDOException $e) {}
              
              while ($subjects_count < 18) {
                echo '<tr>
                        <th>&nbsp;</th>
                        <td colspan="3">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                      </tr>';
                $subjects_count++;
              }
            ?>
            </tbody>
          </table>
        </div>

        <?php

        ?>
        
        <div class="col-xs-12">
          <table width="100%" style="border-top-style: hidden;">
            <tbody>
              <tr>
                <th width="208mm">ตลอดปีการศึกษา</th>
                <td width="65mm"><?php echo $subjects_time; ?></td>
                <th width="112mm">ชั่วโมง</th>
                <th width="216mm">ผลการเรียนเฉลี่ย</th>
                <td><?php echo round($cgpa, 2); ?></td>
                <!-- <th>รวมคะแนน</th>
                <td>000</td>
                <th>อันดับที่</th>
                <td>0</td> -->
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12 text-center" style="font-size: 16px;font-weight: bold;">
          <span>ผลการประเมินคุณลักษณะอันพึงประสงค์</span>
        </div>

        <?php
          try{
            $trait_1_stmt = $conn->prepare("SELECT * FROM `trait` AS `t` 
                                          INNER JOIN `trait_detail` AS `td` ON `td`.`trait_id` = `t`.`trait_id`
                                          WHERE `t`.`year` = :year AND `t`.`term` = 1 AND `td`.`student_id` = :stid");
            $trait_1_stmt->bindParam(":year", $year);
            $trait_1_stmt->bindParam(":stid", $st);
            $trait_1_stmt->execute();
            $trait_1_rows = $trait_1_stmt->fetch(PDO::FETCH_ASSOC);
          } catch (PDOException $e) {

          }
          try {
            $trait_2_stmt = $conn->prepare("SELECT * FROM `trait` AS `t` 
                                          INNER JOIN `trait_detail` AS `td` ON `td`.`trait_id` = `t`.`trait_id`
                                          WHERE `t`.`year` = :year AND `t`.`term` = 2 AND `td`.`student_id` = :stid");
            $trait_2_stmt->bindParam(":year", $year);
            $trait_2_stmt->bindParam(":stid", $st);
            $trait_2_stmt->execute();
            $trait_2_rows = $trait_2_stmt->fetch(PDO::FETCH_ASSOC);
          } catch (PDOException $e) {

          }
        ?>

        <div class="col-xs-12">
          <table width="100%">
            <thead>
              <tr>
                <th>ที่</th>
                <th>คุณลักษณะอันพึงประสงค์</th>
                <th>ภาคเรียนที่ 1</th>
                <th>ภาคเรียนที่ 2</th>
                <th>สรุปผลการประเมิน</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>1</th>
                <td>รักชาติ ศาสน์ กษัตริย์</td>
                <td><?php echo $func->traitResult($trait_1_rows["trait_1"]); ?></td>
                <td><?php echo $func->traitResult($trait_2_rows["trait_1"]); ?></td>
                <td><?php echo $func->traitResult((isset($trait_2_rows["trait_1"])) ? (($trait_1_rows["trait_1"] + $trait_2_rows["trait_1"])/2) : $trait_1_rows["trait_1"] ); ?></td>
              </tr>
              <tr>
                <th>2</th>
                <td>ซื่อสัตย์สุจริต</td>
                <td><?php echo $func->traitResult($trait_1_rows["trait_2"]); ?></td>
                <td><?php echo $func->traitResult($trait_2_rows["trait_2"]); ?></td>
                <td><?php echo $func->traitResult((isset($trait_2_rows["trait_2"])) ? (($trait_1_rows["trait_2"] + $trait_2_rows["trait_2"])/2) : $trait_1_rows["trait_2"] ); ?></td>
              </tr>
              <tr>
                <th>3</th>
                <td>มีวินัย</td>
                <td><?php echo $func->traitResult($trait_1_rows["trait_3"]); ?></td>
                <td><?php echo $func->traitResult($trait_2_rows["trait_3"]); ?></td>
                <td><?php echo $func->traitResult((isset($trait_2_rows["trait_3"])) ? (($trait_1_rows["trait_3"] + $trait_2_rows["trait_3"])/2) : $trait_1_rows["trait_3"] ); ?></td>
              </tr>
              <tr>
                <th>4</th>
                <td>ไฝ่เรียนรู้</td>
                <td><?php echo $func->traitResult($trait_1_rows["trait_4"]); ?></td>
                <td><?php echo $func->traitResult($trait_2_rows["trait_4"]); ?></td>
                <td><?php echo $func->traitResult((isset($trait_2_rows["trait_4"])) ? (($trait_1_rows["trait_4"] + $trait_2_rows["trait_4"])/2) : $trait_1_rows["trait_4"] ); ?></td>
              </tr>
              <tr>
                <th>5</th>
                <td>อยู่อย่างพอเพียง</td>
                <td><?php echo $func->traitResult($trait_1_rows["trait_5"]); ?></td>
                <td><?php echo $func->traitResult($trait_2_rows["trait_5"]); ?></td>
                <td><?php echo $func->traitResult((isset($trait_2_rows["trait_5"])) ? (($trait_1_rows["trait_5"] + $trait_2_rows["trait_5"])/2) : $trait_1_rows["trait_5"] ); ?></td>
              </tr>
              <tr>
                <th>6</th>
                <td>มุ่งมั่นในการทำงาน</td>
                <td><?php echo $func->traitResult($trait_1_rows["trait_6"]); ?></td>
                <td><?php echo $func->traitResult($trait_2_rows["trait_6"]); ?></td>
                <td><?php echo $func->traitResult((isset($trait_2_rows["trait_6"])) ? (($trait_1_rows["trait_6"] + $trait_2_rows["trait_6"])/2) : $trait_1_rows["trait_6"] ); ?></td>
              </tr>
              <tr>
                <th>7</th>
                <td>รักความเป็นไทย</td>
                <td><?php echo $func->traitResult($trait_1_rows["trait_7"]); ?></td>
                <td><?php echo $func->traitResult($trait_2_rows["trait_7"]); ?></td>
                <td><?php echo $func->traitResult((isset($trait_2_rows["trait_7"])) ? (($trait_1_rows["trait_7"] + $trait_2_rows["trait_7"])/2) : $trait_1_rows["trait_7"] ); ?></td>
              </tr>
              <tr>
                <th>8</th>
                <td>มีจิตสาธารณะ</td>
                <td><?php echo $func->traitResult($trait_1_rows["trait_8"]); ?></td>
                <td><?php echo $func->traitResult($trait_2_rows["trait_8"]); ?></td>
                <td><?php echo $func->traitResult((isset($trait_2_rows["trait_8"])) ? (($trait_1_rows["trait_8"] + $trait_2_rows["trait_8"])/2) : $trait_1_rows["trait_8"] ); ?></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12" style="padding-top: 1mm;">
          <table width="100%">
            <tbody>
              <tr>
                <th style="font-size: 16px;font-weight: bold;">ผลการประเมินการอ่าน คิดวิเคราะห์ และการเขียนสื่อความ</th>
                <td width="181mm"><?php echo $func->traitResult((isset($trait_2_rows["trait_readwrite"])) ? (($trait_1_rows["trait_readwrite"] + $trait_2_rows["trait_readwrite"])/2) : $trait_1_rows["trait_readwrite"] ); ?></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12 text-center" style="font-size: 16px;font-weight: bold;">
          <span>การประเมินกิจกรรมพัฒนาผู้เรียน</span>
        </div>

        <?php
          $subjects_3_stmt = $conn->prepare("SELECT DISTINCT `s`.*, `sch`.`year`, `sch`.`class_id`, `st`.* FROM `subjects` AS `s` 
                                                INNER JOIN `schedule` AS `sch` ON `sch`.`subjects_id` = `s`.`subjects_id`
                                                INNER JOIN `student` AS `st` ON `st`.`class_id` = `sch`.`class_id`
                                                WHERE `st`.`student_id` = :stid AND `sch`.`year` = :year AND `s`.`subjects_type` = 3 AND `sch`.`term` = 1
                                                ORDER BY `s`.`subjects_type` ASC, `s`.`subjects_id` ASC");
          $subjects_3_stmt->bindParam(":stid", $st);
          $subjects_3_stmt->bindParam(":year", $year);
          $subjects_3_stmt->execute();
          $subjects_4_stmt = $conn->prepare("SELECT DISTINCT `s`.*, `sch`.`year`, `sch`.`class_id`, `st`.* FROM `subjects` AS `s` 
                                                INNER JOIN `schedule` AS `sch` ON `sch`.`subjects_id` = `s`.`subjects_id`
                                                INNER JOIN `student` AS `st` ON `st`.`class_id` = `sch`.`class_id`
                                                WHERE `st`.`student_id` = :stid AND `sch`.`year` = :year AND `s`.`subjects_type` = 3 AND `sch`.`term` = 2
                                                ORDER BY `s`.`subjects_type` ASC, `s`.`subjects_id` ASC");
          $subjects_4_stmt->bindParam(":stid", $st);
          $subjects_4_stmt->bindParam(":year", $year);
          $subjects_4_stmt->execute();
        ?>

        <div class="col-xs-12">
          <table width="100%">
            <thead>
              <tr>
                <th>กิจกรรม</th>
                <th>ผลการประเมิน</th>
                <th>กิจกรรม</th>
                <th>ผลการประเมิน</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $subjects_3_count = 0;
                $subjects_3_rows = $subjects_3_stmt->fetchAll();
                $subjects_4_rows = $subjects_4_stmt->fetchAll();
                while ($subjects_3_count < 3) {
                  $score_3_stmt = $conn->prepare("SELECT * FROM `score` AS `s` 
                                                  INNER JOIN `schedule` AS `sc` ON `sc`.`schedule_id` = `s`.`schedule_id` 
                                                  INNER JOIN `subjects` AS `sj` ON `sj`.`subjects_id` = `sc`.`subjects_id`
                                                  INNER JOIN `score_detail_2` AS `sd2` ON `sd2`.`score_id` = `s`.`score_id`
                                                  WHERE `s`.`student_id` = :stid AND `sc`.`subjects_id` = :sid AND `sc`.`year` = :year AND `sc`.`term` = 1");
                  $score_3_stmt->bindParam(":stid", $st);
                  $score_3_stmt->bindParam(":sid", $subjects_3_rows[$subjects_3_count]["subjects_id"]);
                  $score_3_stmt->bindParam(":year", $subjects_3_rows[$subjects_3_count]["year"]);
                  $score_3_stmt->execute();
                  $score_3_rows = $score_3_stmt->fetch(PDO::FETCH_ASSOC);
                  $score_4_stmt = $conn->prepare("SELECT * FROM `score` AS `s` 
                                                  INNER JOIN `schedule` AS `sc` ON `sc`.`schedule_id` = `s`.`schedule_id` 
                                                  INNER JOIN `subjects` AS `sj` ON `sj`.`subjects_id` = `sc`.`subjects_id`
                                                  INNER JOIN `score_detail_2` AS `sd2` ON `sd2`.`score_id` = `s`.`score_id`
                                                  WHERE `s`.`student_id` = :stid AND `sc`.`subjects_id` = :sid AND `sc`.`year` = :year AND `sc`.`term` = 2");
                  $score_4_stmt->bindParam(":stid", $st);
                  $score_4_stmt->bindParam(":sid", $subjects_4_rows[$subjects_3_count]["subjects_id"]);
                  $score_4_stmt->bindParam(":year", $subjects_4_rows[$subjects_3_count]["year"]);
                  $score_4_stmt->execute();
                  $score_4_rows = $score_4_stmt->fetch(PDO::FETCH_ASSOC);
                  echo '<tr>
                    <th>'.$score_3_rows["subjects_name"].'</th>
                    <td>'.(($score_3_rows["scored_score"] == 1) ? "ผ่าน" : (($score_3_rows["score_score"] == 2) ? "ไม่ผ่าน" : "&nbsp;")).'</td>
                    <th>'.$score_4_rows["subjects_name"].'</th>
                    <td>'.(($score_4_rows["scored_score"] == 1) ? "ผ่าน" : (($score_4_rows["score_score"] == 2) ? "ไม่ผ่าน" : "&nbsp;")).'</td>
                  </tr>';
                  $subjects_3_count++;
                }
                while ($subjects_3_count < 3) {
                  echo '<tr>
                          <th>&nbsp;</th>
                          <td>&nbsp;</td>
                          <th>&nbsp;</th>
                          <td>&nbsp;</td>
                        </tr>';
                  $subjects_3_count++;
                }
              ?>
            </tbody>
          </table>
        </div>

      </div>
    </article>
  </section>

  <section class="sheet padding-10mm">
    <article class="row">

      <div class="col-xs-12">
        <table width="100%">
          <thead>
            <tr>
              <th>หัวข้อ</th>
              <th>ความคิดเห็นของครูประจำชั้น</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td rowspan="2">1. หน้าที่รับผิดชอบที่โรงเรียน</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2">2. ความเอาใจใส่ในการเรียน</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2">3. ความสัมพันธ์กับครูและเพื่อน</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2">4. อุปนิสัย - บุคลิกภาพ</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2">5. สุขภาพ</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2">6. ควรส่งเสริมในด้าน</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td rowspan="2">7. อื่น ๆ</td>
              <td>&nbsp;</td>
            </tr>
            <tr style="border-top-width: 1px;border-top-style: dotted;">
              <td>&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col-xs-12" style="padding-top: 20mm;font-size:18px;font-weight: bold;">
        <div class="text-center">
          <span>ผลการตัดสินการเลื่อนระดับชั้น</span>
        </div>
        <div class="text-center">
          <i class="far fa-square fa-fw"></i> ได้เลื่อนขั้น
          <span style="padding-left:5mm;padding-right:5mm;"></span>
          <i class="far fa-square fa-fw"></i> ไม่ได้เลื่อนขั้น
        </div>
      </div>

      <div class="col-xs-12" style="padding-top: 15mm;">
        <div class="text-center">
          <p style="margin-bottom: 0;">............................................................................................</p>
          <p style="margin-bottom: 0;">(<?php echo $teacher_rows["teacher_title"] . $teacher_rows["teacher_firstname"] . " " . $teacher_rows["teacher_lastname"]; ?>)</p>
          <p style="margin-bottom: 0;">ครูประจำชั้น</p>
        </div>
      </div>

      <div class="col-xs-12" style="padding-top: 15mm;">
        <div class="text-center">
          <p style="margin-bottom: 0;">............................................................................................</p>
          <p style="margin-bottom: 0;">(นางสาวอาณิสา บุญคำ)</p>
          <p style="margin-bottom: 0;">รองผู้อำนวยการฝ่ายวิชาการ</p>
        </div>
      </div>

      <div class="col-xs-12" style="padding-top: 15mm;">
        <div class="text-center">
          <p style="margin-bottom: 0;">............................................................................................</p>
          <p style="margin-bottom: 0;">(นายสุรวุฒิ ชมภูผล)</p>
          <p style="margin-bottom: 0;">ผู้อำนวยการโรงรียนประชาภิบาล</p>
        </div>
      </div>

    </article>
  </section>

  <?php require_once("./js.inc.php"); ?>
  <script>
    $('#printBtn').click(function() {
      window.print();
    });
  </script>
  
  <?php $conn = null ?>
</body>