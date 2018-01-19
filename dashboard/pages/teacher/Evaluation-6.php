<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php 
  ob_start();
  include_once(dirname(__DIR__, 3)."/components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "ปพ.6";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>
<?php
  $check_year_term_stmt = $conn->prepare("SELECT * FROM `schedule`");
  $check_year_term_stmt->execute();

  $stmt = $conn->prepare("SELECT DISTINCT * FROM `class` AS `c`
                            INNER JOIN `teacher` AS `t` ON `t`.`teacher_id` = `c`.`teacher_id` 
                            WHERE `c`.`teacher_id` = :tid");
  $stmt->bindParam(":tid", $_SESSION["id"]);
  $stmt->execute();
  
?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include_once('nav-teacher.php') ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ปพ.6</h1>
                    <?php 
                    //   while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //     echo '<div class="panel panel-'.$func->scheduleStatusPanel($rows2["status"]).'">
                    //     <div class="panel-heading"> 
                    //         เทอม '.$rows2["term"].' - ปีการศึกษา '.($rows2["year"]+543).'  
                    //     </div>
                    //     <div class="panel-body">
                    //         <p>'.$rows2["subjects_id"].' <br> '.$rows2['subjects_name'] . ' <br>ชั้น ป.' . $rows2["class_grade"] . ' ห้อง ' . $rows2["class_room"] . '</p>
                    //         <a href="'.(($rows2["subjects_type"] != 3) ? "ev5" : "ev5-2") .'.php?sc='.$rows2["schedule_id"].'"><button class="btn btn-success">บันทึกคะแนน</button></a> 
                    //         <a href="ev5-times.php?sc='.$rows2["schedule_id"].'"><button class="btn btn-info">ลงชั่วโมงเรียน</button></a>
                    //     </div>
                    // </div>';
                    //   }
                    ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include_once('js.inc.php') ?>

</body>

</html>
