<?php include_once("../../../lib/conn.php") ?>
<?php 
  ob_start();
  include_once("../../../components/head.php");
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
                        $stmt = $conn->prepare(
                                                ""
                                            );
                    ?>
                    <div class="">
                        <a href="#">
                            <div class="panel panel-default">
                                <div class="panel-heading">ภาษาไทย ป.1</div>
                                <div class="panel-body">
                                    เวลาเรียน พ. 8.00 - 9.00 น.
                                </div>
                            </div>
                        </a>
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
