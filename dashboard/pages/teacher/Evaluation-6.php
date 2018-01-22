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
  $stmt = $conn->prepare("SELECT * FROM `teacher` AS `t` INNER JOIN `class` AS `c` ON `c`.`teacher_id` = `t`.`teacher_id` WHERE `t`.`teacher_id` = :tid");
  $stmt->bindParam(":tid", $_SESSION["id"]);
  $stmt->execute();
  $rows = $stmt->fetch(PDO::FETCH_ASSOC);

  $check_year_term_stmt = $conn->prepare("SELECT DISTINCT `year` FROM `schedule` WHERE `class_id` = :cid");
  $check_year_term_stmt->bindParam(":cid", $rows["class_id"]);
  $check_year_term_stmt->execute();
  
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
                      while ($year_term_rows = $check_year_term_stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="panel panel-primary">
                                <div class="panel-heading"> 
                                    ชั้น ป.'.$rows["class_grade"].'/'.$rows["class_room"]. ' - ปีการศึกษา '.($year_term_rows["year"]+543).'  
                                </div>
                                <div class="panel-body">
                                    <a href="ev6.php?c='.$rows["class_id"].'&y='.$year_term_rows["year"].'"><button class="btn btn-success">ดู</button></a> 
                                </div>
                              </div>';
                      }
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
