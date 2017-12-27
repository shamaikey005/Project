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
                        
                        while ($rows2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '
                                <div class="panel panel-'.$func->scheduleStatusPanel($rows2["status"]).'">
                                    <div class="panel-heading"> 
                                        เทอม '.$rows2["term"].' - ปีการศึกษา '.($rows2["year"]+543).'  
                                    </div>
                                    <div class="panel-body">
                                        <p>'.$rows2['subjects_name'] . ' <br>ชั้น ป.' . $rows2["class_grade"] . ' ห้อง ' . $rows2["class_room"] . '</p>
                                        <a href="ev5.php?sc='.$rows2["schedule_id"].'"><button class="btn btn-success">บันทึกคะแนน</button></a>
                                        <a href="ev5-times.php?sc='.$rows2["schedule_id"].'"><button class="btn btn-info">ลงวันมาเรียน</button></a>
                                    </div>
                                </div>';
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
