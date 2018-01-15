<?php include_once("../../../lib/conn.php") ?>
<?php include_once("../../../lib/Func.php") ?>
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
    $class_stmt = $conn->prepare("SELECT * FROM class");
    $class_stmt->execute();
    $error_manage_user;
    $func = new Func();
?>
<?php 
    if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
        if ( isset($_POST["delStudentBtn"] )) {
            $sid = (string)$_POST["sid"];
            $uid = (string)$_POST["uid"];
            try {
                $conn->beginTransaction();
                $conn->exec("DELETE FROM `score` WHERE `student_id` = '".$sid."'");
                $conn->exec("DELETE FROM `score_detail` WHERE `student_id` = '".$sid."'");
                $conn->exec("DELETE FROM `period` WHERE `student_id` = '".$sid."'");
                $conn->exec("DELETE FROM `student` WHERE `student_id` = '".$sid."' AND `user_id` = '".$uid."'");
                $conn->exec("DELETE FROM `user` WHERE `user_id` = '".$uid."'");
                $conn->commit();
            } catch ( PDOException $e ) {
                $conn->rollback();
                echo 'Error : ' . $e->getMessage();
            }
        }
        if ( isset($_POST["delTeacherBtn"]) ) {
            $tid = (string)$_POST["tid"];
            $uid = (string)$_POST["uid"];
            try {
                $conn->beginTransaction();
                $conn->exec("DELETE FROM `teacher` WHERE `teacher_id` = '$tid' AND `user_id` = '$uid'");
                $conn->exec("DELETE FROM `user` WHERE `user_id` = '$uid'");
                $conn->commit();
            } catch ( PDOException $e ) {
                $conn->rollback();
                echo 'Error : ' . $e->getMessage();
            }
        }
        if ( isset($_POST["insStudentBtn"]) ) {
            try {
                $conn->beginTransaction();
                $conn->exec("INSERT INTO `student` VALUES ('".$_POST["sid"]."','".$_POST["firstname"]."','".$_POST["lastname"]."',".$_POST["num"].",CAST('".$_POST["birth"]."' AS DATE),".$_POST["sex"].",'".$_POST["address"]."','".$_POST["pid"]."','".$_POST["class"]."','".$_POST["uid"]."')");
                $conn->exec("INSERT INTO `user` VALUES ('".$_POST["uid"]."','".$_POST["password"]."',1,1)");
                $conn->commit();
            } catch(PDOException $e) {
                $conn->rollback();
                echo $birth;
                echo 'Error : ' . $e->getMessage();
            }
            unset($_POST["insStudentBtn"]);
        }
        if ( isset($_POST["insTeacherBtn"]) ) {
            try {
                unset($error_manage_user);
                $conn->beginTransaction();
                $conn->exec("INSERT INTO `teacher` VALUES ('".$_POST["tid"]."','".$_POST["firstname"]."','".$_POST["lastname"]."',CAST('".$_POST["birth"]."' AS DATE),'".$_POST["address"]."','".$_POST["tel"]."','".$_POST["uid"]."')");
                $conn->exec("INSERT INTO `user` VALUES ('".$_POST["uid"]."','".$_POST["password"]."',1,2)");
                $conn->commit();
            } catch(PDOException $e) {
                $conn->rollback();
                // echo 'Error : ' . $e->getMessage();
                $error_manage_user = "ไม่สามารถเพิ่มข้อมูลได้";
            }
            unset($_POST["insTeacherBtn"]);
        }
        if ( isset($_POST["changeStatusBtn"]) ) {
            $uid = $_POST["uid"];
            $status = ($_POST["status"] == 0) ? 1 : 0 ;
            try {
                $changeStatusStmt = $conn->prepare("UPDATE `user` SET `user_status` = $status WHERE `user_id` = '$uid'");
                $changeStatusStmt->execute();
            } catch(PDOException $e) {
                echo 'Error : ' . $e->getMessage();
            }
        }
    }
?>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include_once('nav.php') ?>
        <!-- /Navigation -->

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">จัดการข้อมูลผู้ใช้ 
                        <div class="dropdown" style="display: inline-block;">
                            <button class="btn btn-success dropdown-toggle" id="insDropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-plus-circle"> เพิ่ม</i>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-lebelledby="insDropdown">
                                <li><a class="btn btn-link" style="text-decoration: none;color:black;text-align:left;" type="button" data-toggle="modal" data-target="#insStudentModal">นักเรียน</a></li>
                                <li><a class="btn btn-link" style="text-decoration: none;color:black;text-align:left;" type="button" data-toggle="modal" data-target="#insTeacherModal">ครู</a></li>
                            </ul>
                        </div>
                    </h1>
                    <?php
                    if(isset($error_manage_user)) {
                        echo 
                        '<div class="row" style="padding-top: 10px;">
                            <div class="col-xs-12">
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="fas fa-times fa-xs" aria-hidden="true"></i>
                                    </button>
                                    <strong><i class="fas fa-exclamation-circle fa-fw fa-lg" aria-hidden></i> '. $error_manage_user .'</strong>
                                </div>
                            </div>
                        </div>';
                    }
                    ?>
                    <ul class="nav nav-pills nav-justified" role="tablist" style="padding-bottom: 1em;">
                        <li role="presentation" class="active"><a href="#student" aria-controls="student" role="tab" data-toggle="tab">นักเรียน</a></li>
                        <li role="presentation" class=""><a href="#teacher" aria-controls="teacher" role="tab" data-toggle="tab">ครู</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- Student -->
                        <div role="tabpanel" class="tab-pane active" id="student">
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
                                                        <a href="edit-user.php?uid='.$rows["user_id"].'&level='.$rows["user_level"].'"><button class="btn btn-info btn-sm"><i class="fas fa-edit fa-fw"></i> แก้ไข</button></a>
                                                        <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#changeStatus" data-id="'.$rows["user_id"].'" data-status="'.$rows["user_status"].'"><i class="fas fa-exchange-alt fa-fw"></i> '.$func->checkStatusUser(!$rows["user_status"]).'</button>
                                                        <button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#delStudentModal" data-sid="'.$rows["student_id"].'" data-uid="'.$rows["user_id"].'"><i class="fas fa-times fa-fw"></i> ลบ</button>
                                                    </td>
                                                </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /Student -->

                        <!-- Teacher -->
                        <div role="tabpanel" class="tab-pane" id="teacher">
                            <div class="col-xs-12">
                                <table id="data_table2" class="table table-hover table-condensed table-responsive" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>UID</th>
                                            <th>TID</th>
                                            <th>ชื่อ</th>
                                            <th>นามสกุล</th>
                                            <th>เบอร์โทรฯ</th>
                                            <th>สถานะ</th>
                                            <th><i class="fas fa-cog fa-fw"></i> ตั้งค่า</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>UID</th>
                                            <th>TID</th>
                                            <th>ชื่อ</th>
                                            <th>นามสกุล</th>
                                            <th>เบอร์โทรฯ</th>
                                            <th>สถานะ</th>
                                            <th><i class="fas fa-cog fa-fw"></i> ตั้งค่า</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                                        $stmt2 = $conn->prepare(
                                            "SELECT * FROM user AS u
                                            INNER JOIN teacher AS t ON t.user_id = u.user_id
                                            WHERE u.user_level = 2
                                            ");
                                        $stmt2->execute();
                                        while ($rows2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                                            echo '
                                                <tr>
                                                    <td>'.$rows2["user_id"].'</td>
                                                    <td>'.$rows2["teacher_id"].'</td>
                                                    <td>'.$rows2["teacher_firstname"].'</td>
                                                    <td>'.$rows2["teacher_lastname"].'</td>
                                                    <td>'.$rows2["teacher_tel"].'</td>
                                                    <td>'.$user->isAvailable($rows2["user_status"]).'</td>
                                                    <td>
                                                        <a href="edit-user.php?uid='.$rows2["user_id"].'&level='.$rows2["user_level"].'"><button class="btn btn-info btn-sm"><i class="fas fa-edit fa-fw"></i> แก้ไข</button></a>
                                                        <button class="btn btn-warning btn-sm" type="button" data-toggle="modal" data-target="#changeStatus" data-id="'.$rows2["user_id"].'" data-status="'.$rows2["user_status"].'"><i class="fas fa-exchange-alt fa-fw"></i> '.$func->checkStatusUser(!$rows2["user_status"]).'</button>
                                                        <button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#delTeacherModal" data-tid="'.$rows2["teacher_id"].'" data-uid="'.$rows2["user_id"].'"><i class="fas fa-times fa-fw"></i> ลบ</button>
                                                    </td>
                                                </tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /Teacher -->

                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Modal - Insert Student -->
    <div class="modal fade" id="insStudentModal" tabindex="-1" role="dialog" aria-labelledby="insStudentModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                    </button>
                    <h4 class="modal-title" id="insStudentModalTitle"><i class="fas fa-plus-circle fa-fw"></i> เพิ่มนักเรียน</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="insStudentForm">
                        <div class="form-group">
                            <label for="ins01" class="col-xs-3 control-label">UID</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="uid" id="ins01" placeholder="User ID" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins02" class="col-xs-3 control-label">SID</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="sid" id="ins02" placeholder="Student ID" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins03" class="col-xs-3 control-label">Password</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="password" id="ins02" placeholder="Password" />
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <label for="ins04-1" class="col-xs-3 control-label">ชื่อ-นามสกุล</label>
                            <div class="col-xs-9">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control" name="firstname" id="ins04-1" placeholder="ชื่อ" />
                                    </div>
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control" name="lastname" id="ins04-2" placeholder="นามสกุล" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins05" class="col-xs-3 control-label">ชั้นเรียน</label>
                            <div class="col-xs-9">
                                <select class="form-control" id="ins05" name="class" id="class" required>
                                    <option value="" disabled selected>ชั้นเรียน</option>
                                    <?php 
                                        while ( $class_rows = $class_stmt->fetch(PDO::FETCH_ASSOC) ) {
                                            echo "<option value=".$class_rows["class_id"].">ป.".$class_rows["class_grade"]."/".$class_rows["class_room"]."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins06" class="col-xs-3 control-label">เลขที่ในชั้น</label>
                            <div class="col-xs-9">
                                <input type="number" min="0" max="" class="form-control" name="num" id="ins06" placeholder="เลขที่ในชั้น" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins07" class="col-xs-3 control-label">วันเกิด</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="birth" id="ins07" placeholder="วันเกิด" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins08" class="col-xs-3 control-label">เพศ</label>
                            <div class="col-xs-9">
                                <label class="radio-inline"><input type="radio" name="sex" id="sex_male" value="1">ชาย</label>
                                <label class="radio-inline"><input type="radio" name="sex" id="sex_female" value="2">หญิง</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins09" class="col-xs-3 control-label">ที่อยู่</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" name="address" id="ins09" value="" placeholder="ที่อยู่..."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pid" class="col-xs-3 control-label">เลขบัตรประชาชน</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="pid" id="pid" placeholder="เลขบัตรประชาชน" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit" form="insStudentForm" name="insStudentBtn" value="true"><i class="fas fa-plus-circle fa-fw"></i> Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Insert Student -->

    <!-- Modal - Insert Teacher -->
    <div class="modal fade" id="insTeacherModal" tabindex="-1" role="dialog" aria-labelledby="insTeacherModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                    </button>
                    <h4 class="modal-title" id="insTeacherModalTitle"><i class="fas fa-plus-circle fa-fw"></i> เพิ่มครู</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="insTeacherForm">
                        <div class="form-group">
                            <label for="ins11" class="col-xs-3 control-label">UID</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="uid" id="ins11" placeholder="User ID" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins12" class="col-xs-3 control-label">TID</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="tid" id="ins12" placeholder="Teacher ID" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins13" class="col-xs-3 control-label">Password</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" name="password" id="ins13" placeholder="Password" />
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <label for="ins14-1" class="col-xs-3 control-label">ชื่อ-นามสกุล</label>
                            <div class="col-xs-9">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control" name="firstname" id="ins14-1" placeholder="ชื่อ" />
                                    </div>
                                    <div class="col-xs-6">
                                        <input type="text" class="form-control" name="lastname" id="ins14-2" placeholder="นามสกุล" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins15" class="col-xs-3 control-label">วันเกิด</label>
                            <div class="col-xs-9">
                                <input type="date" class="form-control" name="birth" id="ins15" placeholder="วันเกิด" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ins16" class="col-xs-3 control-label">ที่อยู่</label>
                            <div class="col-xs-9">
                                <textarea class="form-control" rows="4" name="address" id="ins16" value="" placeholder="ที่อยู่..."></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tel" class="col-xs-3 control-label">เบอร์โทร</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" name="tel" id="tel" value="" placeholder="เบอร์โทรฯ">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit" form="insTeacherForm" name="insTeacherBtn" value="true"><i class="fas fa-plus-circle fa-fw"></i> Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Insert Teacher -->

    <!-- Modal - Delete Student -->
    <div class="modal fade" id="delStudentModal" tabindex="-1" role="dialog" aria-labelledby="delStudentModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    <h4 class="modal-title">ลบข้อมูลนักเรียน</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="delStudentForm">
                        <p>
                            คุณแน่ใจที่จะลบข้อมูล <strong></strong> หรือไม่
                            <input type="hidden" value="" name="sid" />
                            <input type="hidden" value="" name="uid" />
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit" form="delStudentForm" name="delStudentBtn" value="true"><i class="fas fa-times fa-fw"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Delete Student -->

    <!-- Modal - Delete Teacher -->
    <div class="modal fade" id="delTeacherModal" tabindex="-1" role="dialog" aria-labelledby="delTeacherModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    <h4 class="modal-title">ลบข้อมูลครู</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="delTeacherForm">
                        <p>
                            คุณแน่ใจที่จะลบข้อมูล <strong></strong> หรือไม่
                            <input type="hidden" value="" name="tid" />
                            <input type="hidden" value="" name="uid" />
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit" form="delTeacherForm" name="delTeacherBtn" value="true"><i class="fas fa-times fa-fw"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Delete Teacher -->

    <!-- Modal - Change Status -->
    <div class="modal fade" id="changeStatus" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                    <h4 class="modal-title" id="changeStatusModalTitle"><i class="fas fa-plus-circle fa-fw"></i> เปลี่ยนสถานะ</h4>
                </div>
                <div class="modal-body">
                    <form class="" method="post" id="changeStatusForm">
                        <p>
                            คุณแน่ใจที่เปลี่ยนสถานะของ <strong></strong> หรือไม่
                            <input type="hidden" value="" name="status" />
                            <input type="hidden" value="" name="uid" />
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-warning" type="submit" form="changeStatusForm" name="changeStatusBtn" value="true"><i class="fas fa-exchange-alt fa-fw"></i> Change</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Change Status -->

    <!-- include js -->
    <?php include_once('js.inc.php') ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#data_table').DataTable();
            $('#data_table2').DataTable();
            $('#pid').inputmask({ "mask": "9-9999-99999-99-9" });
            $('#tel').inputmask({ "mask": "999-999-9999"});
        });

        $('#delStudentModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var sid = button.data('sid');
            var uid = button.data('uid');

            var modal = $(this);
            modal.find('.modal-body p strong').text(uid);
            modal.find('.modal-body input[name=sid]').val(sid);
            modal.find('.modal-body input[name=uid]').val(uid);
        });

        $('#delTeacherModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var tid = button.data('tid');
            var uid = button.data('uid');

            var modal = $(this);
            modal.find('.modal-body p strong').text(uid);
            modal.find('.modal-body input[name=tid]').val(tid);
            modal.find('.modal-body input[name=uid]').val(uid);
        });

        $('#changeStatus').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var id = button.data('id');
            var status = button.data('status');
            
            var modal = $(this);
            modal.find('.modal-body p strong').text(id);
            modal.find('.modal-body input[name=uid]').val(id);
            modal.find('.modal-body input[name=status]').val(status);
        });

    </script>

</body>

</html>