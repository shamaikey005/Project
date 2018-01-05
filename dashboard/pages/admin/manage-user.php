<?php include_once("../../../lib/conn.php") ?>
<?php 
  ob_start();
  include_once("../../../components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "จัดการผู้ใช้งาน";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>
<?php 
    if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
        if ( isset($_POST["delBtn"] )) {
            $sid = $_POST["sid"];
            $uid = $_POST["uid"];
            try {
                $conn->beginTransaction();
                $conn->exec("DELETE FROM `score` WHERE student_id LIKE $sid");
                $conn->exec("DELETE FROM `score_detail` WHERE student_id LIKE $sid");
                $conn->exec("DELETE FROM `period` WHERE student_id LIKE $sid");
                $conn->exec("DELETE FROM `student` WHERE student_id LIKE $sid AND user_id LIKE $uid");
                $conn->exec("DELETE FROM `user` WHERE user_id LIKE $uid");
                $conn->commit();
            } catch ( PDOException $e ) {
                $conn->rollback();
                echo 'Error : ' . $e->getMessage();
            }
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
                    <h1 class="page-header">จัดการข้อมูลนักเรียน <button class="btn btn-success" type="button" data-toggle="modal" data-target="#insModal"><i class="fas fa-plus-circle fa-fw1"> เพิ่ม</i></button></h1>
                    <div class="col-xs-12">
                        <table id="data_table" class="table table-hover table-condensed table-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>UID</th>
                                    <th>SID</th>
                                    <th>ชื่อ</th>
                                    <th>นามสกุล</th>
                                    <th>ชั้น/ห้อง</th>
                                    <th>สถานะ</th>
                                    <th><i class="fas fa-cog fa-fw"></i> ตั้งค่า</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>UID</th>
                                    <th>SID</th>
                                    <th>ชื่อ</th>
                                    <th>นามสกุล</th>
                                    <th>ชั้น/ห้อง</th>
                                    <th>สถานะ</th>
                                    <th><i class="fas fa-cog fa-fw"></i> ตั้งค่า</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $stmt = $conn->prepare(
                                    "SELECT * FROM user AS u
                                     INNER JOIN student AS st ON st.user_id = u.user_id
                                     INNER JOIN class AS c ON c.class_id = st.class_id
                                     WHERE u.user_level = 1
                                    ");
                                $stmt->execute();
                                while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo '
                                        <tr>
                                            <td>'.$rows["user_id"].'</td>
                                            <td>'.$rows["student_id"].'</td>
                                            <td>'.$rows["student_firstname"].'</td>
                                            <td>'.$rows["student_lastname"].'</td>
                                            <td>ป.'.$rows["class_grade"]. '/'.$rows["class_room"].'</td>
                                            <td>'.$user->isAvailable($rows["user_status"]).'</td>
                                            <td>
                                                <button class="btn btn-info"><i class="fas fa-edit fa-fw"></i> แก้ไข</button>
                                                <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#delModal" data-sid="'.$rows["student_id"].'" data-uid="'.$rows["user_id"].'"><i class="fas fa-times fa-fw"></i> ลบ</button>
                                            </td>
                                        </tr>';
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

    <!-- Modal - Insert -->
    <div class="modal fade" id="insModal" tabindex="-1" role="dialog" aria-labelledby="insModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                    </button>
                    <h4 class="modal-title" id="insModalTitle"><i class="fas fa-plus-circle fa-fw"></i> เพิ่มนักเรียน</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="insForm">
                        <div class="form-group">
                            <label for="ins01" class="control-label">Label 1</label>
                            <input type="text" class="form-control" id="ins01" />
                        </div>
                        <div class="form-group">
                            <label for="ins02" class="control-label">Label 2</label>
                            <input type="text" class="form-control" id="ins02" />
                        </div>
                        <div class="form-group">
                            <label for="ins03" class="control-label">Label 3</label>
                            <input type="text" class="form-control" id="ins03" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancel</button>
                    <button class="btn btn-success" type="submit" form="insForm" name="insBtn" value="true"><i class="fas fa-plus-circle fa-fw"></i> Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Insert -->

    <!-- Modal - Delete -->
    <div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="insModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    <h4 class="modal-title">ลบข้อมูลนักเรียน</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="delForm">
                        <p>
                            คุณแน่ใจที่จะลบข้อมูล <strong></strong> หรือไม่
                            <input type="hidden" value="" name="sid" />
                            <input type="hidden" value="" name="uid" />
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancel</button>
                    <button class="btn btn-danger" type="submit" form="delForm" name="delBtn" value="true"><i class="fas fa-times fa-fw"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- include js -->
    <?php include_once('js.inc.php') ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#data_table').DataTable();
        });
        $('#delModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var sid = button.data('sid');
            var uid = button.data('uid');

            var modal = $(this);
            modal.find('.modal-body p strong').text(uid);
            modal.find('.modal-body input[name=sid]').val(sid);
            modal.find('.modal-body input[name=uid]').val(uid);
        })
    </script>

</body>

</html>
