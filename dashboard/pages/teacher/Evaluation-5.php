<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php include_once(dirname(__DIR__, 3)."/lib/Func.php"); ?>
<?php 
  ob_start();
  include_once(dirname(__DIR__, 3)."/components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "ปพ.5";
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
                    <h1 class="page-header">ปพ.5</h1>
                    <?php
                        $func = new Func();
                        $stmt = $conn->prepare(
                                                "SELECT * FROM schedule AS sc
                                                 INNER JOIN subjects AS s ON s.subjects_id = sc.subjects_id
                                                 INNER JOIN class AS c ON c.class_id = sc.class_id
                                                 WHERE sc.teacher_id = :teacher_id
                                                "
                                            );
                        $stmt->execute(array(':teacher_id'=>$_SESSION['id']));
                        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $weekday = $conn->prepare("SELECT * FROM schedule_detail WHERE schedule_id = :id");
                            $weekday->execute(array(':id'=>$rows['schedule_id']));
                            $part = $conn->prepare("SELECT * FROM score AS s
                                                    INNER JOIN score_detail AS sd ON sd.score_id = s.score_id 
                                                    WHERE s.schedule_id = :scid
                                                    ");
                            $part->execute(array(':scid'=>$rows['schedule_id']));
                            
                            echo '
                                <div class="">
                                    
                                        <div class="panel panel-info">
                                            <div class="panel-heading">'. $rows['subjects_name'] . ' <br>ชั้น ป.' . $rows["class_grade"] . ' ห้อง ' . $rows["class_room"] . '<br>'; 
                                            while ($weekday_rows = $weekday->fetch(PDO::FETCH_ASSOC)) {
                                                echo ' ' . $func->weekday($weekday_rows['schedule_weekday']) . ' ' . $weekday_rows['schedule_begin_time'] . ' - ' . $weekday_rows['schedule_end_time'] . '<br>';
                                            }
                                            '</div>
                                            <div class="list-group">'; 
                                   
                                            while ($part_rows = $part->fetch(PDO::FETCH_ASSOC)) {
                                                // if ($part_rows["scored_part"] < 8) {
                                                //     echo '<a href="ev5.php?sc=' . $part_rows["schedule_id"] .'&p='.$part_rows["scored_part"].'" class="list-group-item">คะแนนช่องที่ '.$part_rows["scored_part"].' ( '.$part_rows["scored_max"].' คะแนน )<i class="pull-right fa fa-chevron-right"></i></a>';
                                                // } else {
                                                //     echo '<a href="ev5.php?sc=' . $part_rows["schedule_id"] .'&p='.$part_rows["scored_part"].'" class="list-group-item">คะแนนปลายภาค ( '.$part_rows["scored_max"].' คะแนน )<i class="pull-right fa fa-chevron-right"></i></a>';
                                                // }

                                                // shorthand
                                                echo '<a href="ev5.php?sc=' . $part_rows["schedule_id"] .'&p='.$part_rows["scored_part"].'" class="list-group-item">'.($part_rows["scored_part"] < 8 ? 'คะแนนช่องที่ '.$part_rows["scored_part"] : 'คะแนนปลายภาค').' ( '.$part_rows["scored_max"].' คะแนน )<i class="pull-right fa fa-chevron-right"></i></a>';
                                            } 
                                            echo '
                                            </div>
                                        </div>
                                   
                                </div>
                            ';
                        }
                    ?>
                    
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
