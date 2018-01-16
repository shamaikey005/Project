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
  $stmt = $conn->prepare("SELECT * FROM `schedule` AS `sc` INNER JOIN `teacher` AS `t` ON `t`.`teacher_id` = `sc`.`teacher_id` WHERE `t`.`teacher_id` = :tid");
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
                      while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<a href="ev6-print.php?sc='.$rows["schedule_id"].'">ev6</a><br>';
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
