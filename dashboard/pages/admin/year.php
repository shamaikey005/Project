<?php include_once("../../../lib/conn.php") ?>
<?php 
  ob_start();
  include_once("../../../components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "ปีการศึกษา";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>
<?php 
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["yearBtn"])) {
      // $check_stmt = $conn->prepare("SELECT * FROM `student`");
      // $check_stmt->bindParam();
      // $check_stmt->execute();
      // $year_stmt = $conn->prepare("UPDATE `st`
      //                             SET `c`.`class_grade` = :gradeUp
      //                             FROM `student` AS `st`
      //                             INNER JOIN `class` AS `c` ON `c`.`class_id` = `st`.`class_id0`
      //                             ");
      // $year_stmt->bindParam();
      // $year_stmt->bindParam();
      // $year_stmt->execute();
    }
  }
  
?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include_once('nav.php') ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ปีการศึกษา</h1>
                    <div class="container-fluid">
                      <div class="row">
                        <table class="table table-hover table-responsive table-condensed text-right" id="data_year_table">
                          <thead>
                            <tr>
                              <th class="text-right">ปีการศึกษา</th>
                              <th class="text-right"><i class="fa fa-cog"></i></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $year_stmt = $conn->prepare("SELECT DISTINCT `year` FROM `schedule` ORDER BY `year` DESC, `term` ASC");
                            $year_stmt->execute();
                            while ($year_rows = $year_stmt->fetch(PDO::FETCH_ASSOC)) {
                              echo '
                              <tr>
                                <td>'.($year_rows["year"]+543).'</td>
                                <td><button class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#yearModal" data-year="'.($year_rows["year"]+543).'">จบปีการศึกษา</button></td>
                              </tr>';
                            }
                            ?>
                          </tbody>
                        </table>
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

    <!-- Modal - Year Confirm -->
    <div class="modal fade" id="yearModal" tabindex="-1" role="dialog" aria-labelledby="yearModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    <h4 class="modal-title">จบปีการศึกษา</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="yearForm">
                        <p>
                            คุณแน่ใจที่จะจบปีการศึกษา <strong id="cyear"></strong> หรือไม่
                            <input type="hidden" value="" name="cyear" />
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit" form="yearForm" name="yearBtn" value="true"><i class="fas fa-times fa-fw"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Year Confirm -->

    <!-- include js -->
    <?php include_once('js.inc.php') ?>
    <script>
      $(document).ready( function() {
        $('#data_year_table').DataTable();
      });

      $('#yearModal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var year = button.data('year');

        var modal = $(this);
        modal.find('.modal-body p strong#cyear').text(year);
        modal.find('.modal-body input[name=cyear]').val(year);
      });
    </script>

</body>

</html>
