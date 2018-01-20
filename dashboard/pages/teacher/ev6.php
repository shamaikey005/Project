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
  $func = new Func();

  $cid = $_GET["c"];
  $year = $_GET["y"];

  $class_stmt = $conn->prepare("SELECT * FROM `class` WHERE `class_id` = :cid");
  $class_stmt->bindParam(":cid", $cid);
  $class_stmt->execute();
  $class_row = $class_stmt->fetch(PDO::FETCH_ASSOC);

  $student_stmt = $conn->prepare("SELECT * FROM `student` WHERE `class_id` = :cid ORDER BY `student_num` ASC");
  $student_stmt->bindParam(":cid", $cid);
  $student_stmt->execute();
  
?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include_once('nav-teacher.php') ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ปพ.6</h1>
                    <ul class="breadcrumb">
                      <li><a href="Evaluation-6.php">ปพ.6</a></li>
                      <li class="active">ชั้น ป.<?php echo $class_row["class_grade"].' ห้อง '.($class_row["class_room"]); echo ' - ปีการศึกษา ' . ($year+543); ?></li>
                    </ul>
                    <div class="col-xs-12">
                        <table id="data_table" class="table table-hover table-condensed table-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                  <th>เลขที่</th>
                                  <th>ชื่อ - นามสกุล</th>
                                  <th><i class="fas fa-cog fa-fw"></i> ตั้งค่า</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                  <th>เลขที่</th>
                                  <th>ชื่อ - นามสกุล</th>
                                  <th><i class="fas fa-cog fa-fw"></i> ตั้งค่า</th>
                                </tr>
                            </tfoot>
                            <tbody>
                              <?php
                                while ($student_rows = $student_stmt->fetch(PDO::FETCH_ASSOC)) {
                                  echo '
                                        <tr>
                                          <th>'.$student_rows["student_num"].'</th>
                                          <td>'.$func->checkSex2($student_rows["student_sex"]).$student_rows["student_firstname"].' '.$student_rows["student_lastname"].'</td>
                                          <td><a href="ev6-print.php?st='.$student_rows["student_id"].'&y='.$year.'"><button class="btn btn-primary btn-sm" type="button" > ดู </button></a></td>
                                        </tr>
                                  ';
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

    <?php include_once('js.inc.php') ?>

    <script>
    $(document).ready(function () {
      $('#data_table').DataTable();
    });
      
    </script>

</body>

</html>
