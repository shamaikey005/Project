<?php require_once("../../../lib/conn.php"); ?>
<?php include_once("../../../lib/Func.php"); ?>
<?php 
  ob_start();
  include_once("../../../components/head.php");
  $buffer = ob_get_contents();
  ob_end_clean();

  $title = "จัดการข้อมูลพื้นฐาน";
  $buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i','$1' . $title . '$3', $buffer);

  echo $buffer;
?>
<?php 
    $func = new Func();

    try {

        $subjects_stmt = $conn->prepare("SELECT * FROM subjects AS sj");
        $subjects_stmt->execute();

        $teacher_stmt = $conn->prepare("SELECT * FROM teacher AS t");
        $teacher_stmt->execute();

        $class_stmt = $conn->prepare("SELECT * FROM class As c");
        $class_stmt->execute();

        $type_stmt = $conn->prepare("SELECT * FROM subjects_type");
        $type_stmt->execute();

    } catch (PDOException $e) {
        echo 'ERROR : ' . $e->getMessage();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["insSubjectsBtn"])) {
            
            try {

                $insSubjectStmt = $conn->prepare("INSERT INTO `subjects` VALUES ('".$_POST["sjid"]."','".$_POST["sjname"]."',".$_POST["sjtype"].",".$_POST["sjcredit"].",".$_POST["sjtime"].") ");
                $insSubjectStmt->execute();
                unset($_POST["insSubjectsBtn"]);
                $user->redirect("manage-gen.php");

            } catch (PDOException $e) {
                echo 'ERROR : ' . $e->getMessage();
            }

        }

        if (isset($_POST["insScheduleBtn"])) {

            try {

                $insScheduleStmt = $conn->prepare("INSERT INTO `schedule` VALUES ('', '".$_POST["sc_subject"]."', '".$_POST["sc_class"]."', '".$_POST["sc_teacher"]."', YEAR(CAST(STR_TO_DATE('".($_POST["year"] - 543)."', '%Y') AS DATE)), '".$_POST["term"]."',1)");
                $insScheduleStmt->execute();
                $user->redirect("manage-gen.php");

            } catch (PDOException $e) {
                echo 'ERROR : ' . $e->getMessage();
            }

        }

        if (isset($_POST["delSubjectsBtn"])) {
            
            try {
                $schedule_stmt = $conn->prepare("SELECT * FROM schedule WHERE subjects_id = :sjid");
                $schedule_stmt->bindParam(":sjid", $_POST["sjid"]);
                $schedule_stmt->execute();
                $count = $schedule_stmt->rowCount();
                if ($count > 0) {
                    $del_schedule_stmt = $conn->prepare("DELETE FROM `schedule` WHERE `subjects_id` = '" . $_POST["sjid"] . "'");
                    $del_schedule_stmt->execute();
                }
                $delSubjectStmt = $conn->prepare("DELETE FROM `subjects` WHERE `subjects_id` = '".$_POST["sjid"]."'");
                $delSubjectStmt->execute();
                unset($_POST["delSubjectsBtn"]);
            } catch (PDOException $e) {
                echo 'ERROR : ' . $e->getMessage();
            }
            
        }

        if (isset($_POST["delScheduleBtn"])) {

            try {
                $conn->beginTransaction();
                $conn->exec("DELETE FROM `schedule` WHERE `schedule_id` = '".$_POST["scid"]."'");
                $conn->exec("DELETE FROM `score` WHERE `schedule_id` = '".$_POST["scid"]."'");
                $conn->exec("DELETE FROM `period` WHERE `schedule_id` = '".$_POST["scid"]."'");
                $conn->commit();
                unset($_POST["delScheduleBtn"]);
            } catch (PDOException $e) {
                $conn->rollback();
                echo 'ERROR : '.$e->getMessage();
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
                    <h1 class="page-header">จัดการข้อมูลพื้นฐาน
                        <div class="dropdown" style="display: inline-block;">
                            <button class="btn btn-success dropdown-toggle" id="insDropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-plus-circle fa-fw1"> เพิ่ม</i>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-lebelledby="insDropdown">
                                <li><a class="btn btn-link" style="text-decoration: none;color:black;text-align:left;" type="button" data-toggle="modal" data-target="#insSubjectsModal">วิชา</a></li>
                                <li><a class="btn btn-link" style="text-decoration: none;color:black;text-align:left;" type="button" data-toggle="modal" data-target="#insScheduleModal">ตารางเรียน</a></li>
                            </ul>
                        </div>
                    </h1>
                    <ul class="nav nav-pills nav-justified" role="tablist" style="padding-bottom:1em;">
                        <li role="presentation" class="active"><a href="#subjects" aria-controls="subjects" role="tab" data-toggle="tab">จัดการวิชา</a></li>
                        <li role="presentation" class=""><a href="#teacher" aria-controls="teacher" role="tab" data-toggle="tab">จัดการผู้สอน</a></li>
                        <li role="presentation" class=""><a href="#schedule" aria-controls="schedule" role="tab" data-toggle="tab">จัดการตารางเรียน</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="subjects">
                            <div class="col-xs-12">
                                <table id="data_table" class="table table-hover table-condensed table-responsive" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>รหัสวิชา</th>
                                            <th>ชื่อวิชา</th>
                                            <th>ประเภท</th>
                                            <th>หน่วยกิต</th>
                                            <th>จำนวนชั่วโมง</th>
                                            <th><i class="fas fa-cog fa-fw"></i> ตั้งค่า</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>รหัสวิชา</th>
                                            <th>ชื่อวิชา</th>
                                            <th>ประเภท</th>
                                            <th>หน่วยกิต</th>
                                            <th>จำนวนชั่วโมง</th>
                                            <th><i class="fas fa-cog fa-fw"></i> ตั้งค่า</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $stmt = $conn->prepare("SELECT * FROM subjects AS sj");
                                        $stmt->execute();
                                        
                                        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo '
                                                <tr>
                                                    <td>'.$rows["subjects_id"].'</td>
                                                    <td>'.$rows["subjects_name"].'</td>
                                                    <td>'.$func->checkSubjectsType($rows["subjects_type"]).'</td>
                                                    <td>'.$rows["subjects_credit"].'</td>
                                                    <td>'.$rows["subjects_time"].'</td>
                                                    <td>
                                                        <a href="edit-subject.php?id='.$rows["subjects_id"].'&t='.$rows["subjects_type"].'"><button class="btn btn-info btn-sm"><i class="fas fa-edit fa-fw"></i> แก้ไข</button></a>
                                                        <button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#delSubjectsModal" data-sjid="'.$rows["subjects_id"].'" data-type="'.$rows["subjects_type"].'"><i class="fas fa-times fa-fw"></i> ลบ</button>
                                                    </td>
                                                </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="teacher">
                        
                        </div>
                        <div role="tabpanel" class="tab-pane" id="schedule">
                            <div class="col-xs-12">
                                <table id="data_table2" class="table table-hover table-condensed table-responsive" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>รหัส</th>
                                            <th>รหัสวิชา</th>
                                            <th>ชั้น</th>
                                            <th>ครู</th>
                                            <th>ปี</th>
                                            <th>เทอม</th>
                                            <th>สถานะ</th>
                                            <th><i class="fas fa-cog fa-fw"></i> ตั้งค่า</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>รหัส</th>
                                            <th>รหัสวิชา</th>
                                            <th>ชั้น</th>
                                            <th>ครู</th>
                                            <th>ปี</th>
                                            <th>เทอม</th>
                                            <th>สถานะ</th>
                                            <th><i class="fas fa-cog fa-fw"></i> ตั้งค่า</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $stmt = $conn->prepare("SELECT * FROM schedule AS sc 
                                                                LEFT JOIN class AS c ON c.class_id = sc.class_id
                                                                LEFT JOIN teacher AS t ON t.teacher_id = sc.teacher_id");

                                        $stmt->execute();
                                        
                                        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                            echo '
                                                <tr>
                                                    <td>'.$rows["schedule_id"].'</td>
                                                    <td>'.$rows["subjects_id"].'</td>
                                                    <td>ป.'.$rows["class_grade"].'/'.$rows["class_room"].'</td>
                                                    <td>'.$rows["teacher_firstname"].' '.$rows["teacher_lastname"].'</td>
                                                    <td>'.($rows["year"]+543).'</td>
                                                    <td>'.$rows["term"].'</td>
                                                    <td>'.$func->scheduleStatusText($rows["status"]).'</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#delScheduleModal" data-scid="'.$rows["schedule_id"].'"><i class="fas fa-times fa-fw"></i> ลบ</button>
                                                    </td>
                                                </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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

    <!-- Modal - Insert Subjects -->
    <div class="modal fade" id="insSubjectsModal" tabindex="-1" role="dialog" aria-labelledby="insSubjectsModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                    </button>
                    <h4 class="modal-title" id="insSubjectsModalTitle"><i class="fas fa-plus-circle fa-fw"></i> เพิ่มวิชา</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="insSubjectsForm">
                        <div class="form-group">
                            <label for="ins11" class="col-xs-3 control-label">รหัสวิชา</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="sjid" id="ins11" placeholder="Subjects ID" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins12" class="col-xs-3 control-label">ชื่อวิชา</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="sjname" id="ins12" placeholder="Subjects name" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins13" class="col-xs-3 control-label">ประเภท</label>
                            <div class="col-xs-9">
                                <select class="form-control" name="sjtype" id="sjtype" required>
                                    <?php 
                                    while ($type_rows = $type_stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="'.$type_rows["subjects_type"].'">'.$type_rows["subjects_type_name"].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins16" class="col-xs-3 control-label">หน่วยกิต</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="number" name="sjcredit" min="0" max="5" value="" placeholder="Subjects credit" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tel" class="col-xs-3 control-label">จำนวนชั่วโมง</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="number" name="sjtime" min="0" max="" value="" placeholder="จำนวนชั่วโมง" required />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit" form="insSubjectsForm" name="insSubjectsBtn" value="true"><i class="fas fa-plus-circle fa-fw"></i> Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Insert Subjects -->

    <!-- Modal - Insert Schedule -->
    <div class="modal fade" id="insScheduleModal" tabindex="-1" role="dialog" aria-labelledby="insSubjectsModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                    </button>
                    <h4 class="modal-title" id="insScheduleModalTitle"><i class="fas fa-plus-circle fa-fw"></i> เพิ่มตารางเรียน</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="insScheduleForm">
                        <div class="form-group">
                            <label for="sc_subject" class="col-xs-3 control-label">วิชา</label>
                            <div class="col-xs-9">
                            <select class="form-control" name="sc_subject" id="sc_subject" required>
                                    <?php 
                                    while ($subjects_rows = $subjects_stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="'.$subjects_rows["subjects_id"].'">'.$subjects_rows["subjects_id"].' - '.$subjects_rows["subjects_name"].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sc_teacher" class="col-xs-3 control-label">ครู</label>
                            <div class="col-xs-9">
                            <select class="form-control" name="sc_teacher" id="sc_teacher" required>
                                    <?php 
                                    while ($teacher_rows = $teacher_stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="'.$teacher_rows["teacher_id"].'">'.$teacher_rows["teacher_firstname"].' '.$teacher_rows["teacher_lastname"].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sc_class" class="col-xs-3 control-label">ชั้น</label>
                            <div class="col-xs-9">
                                <select class="form-control" name="sc_class" id="sc_class" required>
                                    <?php 
                                    while ($class_rows = $class_stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="'.$class_rows["class_id"].'">ป.'.$class_rows["class_grade"].'/'.$class_rows["class_room"].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="year" class="col-xs-3 control-label">ปีการศึกษา</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="number" name="year" id="year" min="<?php echo (date("Y") + 542); ?>" max="<?php echo (date("Y") + 544); ?>" value="" placeholder="Year" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="term" class="col-xs-3 control-label">เทอม</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="number" name="term" id="term" min="1" max=2 value="" placeholder="Term" required />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit" form="insScheduleForm" name="insScheduleBtn" value="true"><i class="fas fa-plus-circle fa-fw"></i> Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Insert Schedule -->

    <!-- Modal - Delete Subjects -->
    <div class="modal fade" id="delSubjectsModal" tabindex="-1" role="dialog" aria-labelledby="delSubjectsModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    <h4 class="modal-title">ลบข้อมูลนักเรียน</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="delSubjectsForm">
                        <p>
                            คุณแน่ใจที่จะลบข้อมูล <strong></strong> หรือไม่
                            <input type="hidden" value="" name="sjid" />
                            <input type="hidden" value="" name="type" />
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit" form="delSubjectsForm" name="delSubjectsBtn" value="true"><i class="fas fa-times fa-fw"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Delete Subjects -->

    <!-- Modal - Delete Subjects -->
    <div class="modal fade" id="delScheduleModal" tabindex="-1" role="dialog" aria-labelledby="delScheduleModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    <h4 class="modal-title" id="delScheduleModalTitle">ลบข้อมูลตารางเรียน</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="delScheduleForm">
                        <p>
                            คุณแน่ใจที่จะลบข้อมูล <strong></strong> หรือไม่
                            <input type="hidden" value="" name="scid" />
                            <input type="hidden" value="" name="type" />
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit" form="delScheduleForm" name="delScheduleBtn" value="true"><i class="fas fa-times fa-fw"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Delete Subjects -->

   <!-- include js -->
   <?php include_once('js.inc.php') ?>
   <script>
    $(document).ready(function() {
        $('#data_table').DataTable();
        $('#data_table2').DataTable();
    });

    $('#delSubjectsModal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var sjid = button.data('sjid');
        var type = button.data('type');

        var modal = $(this);
        modal.find('.modal-body p strong').text(sjid);
        modal.find('.modal-body input[name=sjid]').val(sjid);
        modal.find('.modal-body input[name=type]').val(type);
    });

    $('#delScheduleModal').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var scid = button.data('scid');
        
        var modal = $(this);
        modal.find('.modal-body p strong').text(scid);
        modal.find('.modal-body input[name=scid]').val(scid);
    });
   </script>

</body>

</html>
