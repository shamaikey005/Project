<?php include_once("../../../lib/conn.php") ?>
<?php include_once("../../../lib/Func.php") ?>
<?php $func = new Func(); ?>
<?php 
  ob_start();
  include_once("../../../components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "ตรวจสอบสถานะการส่งเกรด";
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
            <h1 class="page-header">ตรวจสอบสถานะการส่งเกรด</h1>
            <ul class="nav nav-pills nav-justified" role="tablist" style="padding-bottom:1em;">
                <li role="presentation" class="active"><a href="#cop" aria-controls="cop" role="tab" data-toggle="tab">รายวิชาที่เปิดสอน</a></li>
                <li role="presentation" class=""><a href="#cde" aria-controls="cde" role="tab" data-toggle="tab">รายวิชาที่ส่งเกรดแล้ว</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="cop">
                    <div class="col-xs-12">
                        <table id="data_table" class="table table-hover table-condensed table-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>รหัส</th>
                                    <th>รหัสวิชา</th>
                                    <th>ชื่อวิชา</th>
                                    <th>ชั้น</th>
                                    <th>ครู</th>
                                    <th>ปี</th>
                                    <th>เทอม</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>รหัส</th>
                                    <th>รหัสวิชา</th>
                                    <th>ชื่อวิชา</th>
                                    <th>ชั้น</th>
                                    <th>ครู</th>
                                    <th>ปี</th>
                                    <th>เทอม</th>
                                    <th>สถานะ</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                    $stmt = $conn->prepare("SELECT * FROM `schedule` AS `sc` 
                                                            LEFT JOIN `class` AS `c` ON `c`.`class_id` = `sc`.`class_id`
                                                            LEFT JOIN `subjects` AS `s` ON `s`.`subjects_id` = `sc`.`subjects_id`
                                                            LEFT JOIN `teacher` AS `t` ON `t`.`teacher_id` = `sc`.`teacher_id`
                                                            WHERE `sc`.`status` = 1");

                                    $stmt->execute();
                                    
                                    while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '
                                            <tr>
                                                <td>'.$rows["schedule_id"].'</td>
                                                <td>'.$rows["subjects_id"].'</td>
                                                <td>'.$rows["subjects_name"].'</td>
                                                <td>ป.'.$rows["class_grade"].'/'.$rows["class_room"].'</td>
                                                <td>'.$rows["teacher_firstname"].' '.$rows["teacher_lastname"].'</td>
                                                <td>'.($rows["year"]+543).'</td>
                                                <td>'.$rows["term"].'</td>
                                                <td>'.$func->scheduleStatusText($rows["status"]).'</td>
                                            </tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="cde">
                    <div class="col-xs-12">
                        <table id="data_table2" class="table table-hover table-condensed table-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>รหัส</th>
                                    <th>รหัสวิชา</th>
                                    <th>ชื่อวิชา</th>
                                    <th>ชั้น</th>
                                    <th>ครู</th>
                                    <th>ปี</th>
                                    <th>เทอม</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>รหัส</th>
                                    <th>รหัสวิชา</th>
                                    <th>ชื่อวิชา</th>
                                    <th>ชั้น</th>
                                    <th>ครู</th>
                                    <th>ปี</th>
                                    <th>เทอม</th>
                                    <th>สถานะ</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                    $stmt = $conn->prepare("SELECT * FROM `schedule` AS `sc` 
                                                            LEFT JOIN `class` AS `c` ON `c`.`class_id` = `sc`.`class_id`
                                                            LEFT JOIN `subjects` AS `s` ON `s`.`subjects_id` = `sc`.`subjects_id`
                                                            LEFT JOIN `teacher` AS `t` ON `t`.`teacher_id` = `sc`.`teacher_id`
                                                            WHERE `sc`.`status` = 2");

                                    $stmt->execute();
                                    
                                    while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '
                                            <tr>
                                                <td>'.$rows["schedule_id"].'</td>
                                                <td>'.$rows["subjects_id"].'</td>
                                                <td>'.$rows["subjects_name"].'</td>
                                                <td>ป.'.$rows["class_grade"].'/'.$rows["class_room"].'</td>
                                                <td>'.$rows["teacher_firstname"].' '.$rows["teacher_lastname"].'</td>
                                                <td>'.($rows["year"]+543).'</td>
                                                <td>'.$rows["term"].'</td>
                                                <td>'.$func->scheduleStatusText($rows["status"]).'</td>
                                            </tr>';
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
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

<script>
    $(document).ready(function() {
    $('#data_table').DataTable();
    $('#data_table2').DataTable();
    });

</script>

</body>

</html>
