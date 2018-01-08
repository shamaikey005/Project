<?php include_once("../../../lib/conn.php") ?>
<?php 
  ob_start();
  include_once("../../../components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "จัดการข้อมูลพื้นฐาน";
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
                    <h1 class="page-header">จัดการข้อมูลพื้นฐาน</h1>
                    <ul class="nav nav-pills nav-justified" role="tablist" style="padding-bottom:1em;">
                        <li role="presentation" class="active"><a href="#subjects" aria-controls="subjects" role="tab" data-toggle="tab">จัดการวิชา</a></li>
                        <li role="presentation" class=""><a href="#teacher" aria-controls="teacher" role="tab" data-toggle="tab">จัดการผู้สอน</a></li>
                        <li role="presentation" class=""><a href="#schedule" aria-controls="schedule" role="tab" data-toggle="tab">จัดการตารางเรียน</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="subjects">subjects</div>
                        <div role="tabpanel" class="tab-pane" id="teacher">teacher</div>
                        <div role="tabpanel" class="tab-pane" id="schedule">schedule</div>
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
