<?php include_once("../../../lib/conn.php") ?>
<?php 
  ob_start();
  include_once("../../../components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "ตั้งค่า";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>

<body>

    <div id="wrapper">
        
         <!-- /.navbar-header -->
        <?php include_once('nav-student.php') ?>
             
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ตั้งค่า</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <?php include_once('js.inc.php') ?>               

</html>
