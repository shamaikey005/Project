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

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["insRollBtn"])) {
            $check_roll = $conn->prepare("SELECT * FROM `roll` WHERE `year` = :year AND `term` = :term");
            $check_roll->execute(array(":year"=>($_POST["ryear"] - 543), ":term"=>$_POST["rterm"]));
            $check_roll_rows = $check_roll->fetch(PDO::FETCH_ASSOC);
            if ( !isset($check_roll_rows["roll_id"]) ) {
                try {
                    $st_stmt = $conn->prepare("SELECT * FROM `student` WHERE `class_id` = :cid");
                    $st_stmt->execute(array(":cid"=>$_POST["rclass"]));
                    $insRollStmt = $conn->prepare("INSERT INTO `roll` VALUES (NULL, '".$_POST["rclass"]."', ".$_POST["rterm"].", YEAR(CAST(STR_TO_DATE('".($_POST["ryear"] - 543)."', '%Y') AS DATE)))");
                    $insRollStmt->execute();
                    $roll_check_stmt = $conn->prepare("SELECT * FROM `roll` WHERE class_id = :cid AND term = :term AND year = :year");
                    $roll_check_stmt->execute(array(":cid"=>$_POST["rclass"],":term"=>$_POST["rterm"],":year"=>($_POST["ryear"]-543)));
                    $roll_check_rows = $roll_check_stmt->fetch(PDO::FETCH_ASSOC);
                    $conn->beginTransaction();
                    while ($st_rows = $st_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $conn->exec("INSERT INTO `roll_detail` VALUES ('".$roll_check_rows["roll_id"]."', '".$st_rows["student_id"]."', 0, 0, 0, 0)");
                    }
                    $conn->commit();
                    unset($_POST["insRollBtn"]);
                    $user->redirect("Evaluation-5.php");
                } catch (PDOException $e) {
                    $conn->rollback();
                    echo 'ERROR : ' . $e->getMessage();
                }
            }
        }

        if (isset($_POST["insTraitBtn"])) {
            $check_trait = $conn->prepare("SELECT * FROM `trait` WHERE `year` = :year AND `term` = :term");
            $check_trait->execute(array(":year"=>($_POST["tryear"] - 543), ":term"=>$_POST["trterm"]));
            $check_trait_rows = $check_trait->fetch(PDO::FETCH_ASSOC);
            if ( !isset($check_trait_rows["trait_id"]) ) {
                try {
                
                    $st_stmt = $conn->prepare("SELECT * FROM `student` WHERE `class_id` = :cid");
                    $st_stmt->execute(array(":cid"=>$_POST["trclass"]));
                    $insTraitStmt = $conn->prepare("INSERT INTO `trait` VALUES (NULL, '".$_POST["trclass"]."', ".$_POST["trterm"].", YEAR(CAST(STR_TO_DATE('".($_POST["tryear"] - 543)."', '%Y') AS DATE)))");
                    $insTraitStmt->execute();
                    $trait_check_stmt = $conn->prepare("SELECT * FROM `trait` WHERE class_id = :cid AND term = :term AND year = :year");
                    $trait_check_stmt->execute(array(":cid"=>$_POST["trclass"],":term"=>$_POST["trterm"],":year"=>($_POST["tryear"]-543)));
                    $trait_check_rows = $trait_check_stmt->fetch(PDO::FETCH_ASSOC);
                    $conn->beginTransaction();
                    while ($st_rows = $st_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $conn->exec("INSERT INTO `trait_detail` VALUES ('".$trait_check_rows["trait_id"]."' ,'".$st_rows["student_id"]."', 0, 0, 0, 0, 0, 0, 0, 0, 0)");
                    }
                    $conn->commit();
                    unset($_POST["insTraitBtn"]);
                    $user->redirect("Evaluation-5.php");
                } catch (PDOException $e) {
                    $conn->rollback();
                    echo 'ERROR : ' . $e->getMessage();
                }
            } 
            
        }

        if (isset($_POST["delRollBtn"])) {
            try {
                $roll_detail_stmt = $conn->prepare("SELECT * FROM `roll_detail` WHERE `roll_id` = :rid");
                $roll_detail_stmt->bindParam(":rid", $_POST["rid"]);
                $roll_detail_stmt->execute();
                $count = $roll_detail_stmt->rowCount();
                if ($count > 0) {
                    $del_roll_detail_stmt = $conn->prepare("DELETE FROM `roll_detail` WHERE `roll_id` = '" . $_POST["rid"] . "'");
                    $del_roll_detail_stmt->execute();
                }
                $del_roll_stmt = $conn->prepare("DELETE FROM `roll` WHERE `roll_id` = '".$_POST["rid"]."'");
                $del_roll_stmt->execute();

            } catch (PDOException $e) {
                echo 'ERROR : ' . $e->getMessage();
            }

            unset($_POST["delRollBtn"]);
            $user->redirect("Evaluation-5.php");
        }

        if (isset($_POST["delTraitBtn"])) {
            try {
                $trait_detail_stmt = $conn->prepare("SELECT * FROM `trait_detail` WHERE `trait_id` = :trid");
                $trait_detail_stmt->bindParam(":trid", $_POST["trid"]);
                $trait_detail_stmt->execute();
                $count = $trait_detail_stmt->rowCount();
                if ($count > 0) {
                    $del_trait_detail_stmt = $conn->prepare("DELETE FROM `trait_detail` WHERE `trait_id` = '" . $_POST["trid"] . "'");
                    $del_trait_detail_stmt->execute();
                }
                $del_trait_stmt = $conn->prepare("DELETE FROM `trait` WHERE `trait_id` = '".$_POST["trid"]."'");
                $del_trait_stmt->execute();
                
            } catch (PDOException $e) {
                echo 'ERROR : ' . $e->getMessage();
            }

            unset($_POST["delTraitBtn"]);
            $user->redirect("Evaluation-5.php");
        }

        if (isset($_POST["sendGradeBtn"])) {
            try {
                $send_grade_stmt = $conn->prepare("UPDATE `schedule` SET `status` = 2 WHERE `schedule_id` = :scid");
                $send_grade_stmt->bindParam(":scid", $_POST["scid"]);
                $send_grade_stmt->execute();
                
            } catch (PDOException $e) {
                echo 'ERROR : ' . $e->getMessage();
            }

            unset($_POST["sendGradeBtn"]);
            $user->redirect("Evaluation-5.php");
        }

    }
?>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include_once('nav-teacher.php') ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">ปพ.5 
                        <div class="dropdown" style="display: inline-block;">
                            <button class="btn btn-success dropdown-toggle" id="insDropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-plus-circle"> เพิ่ม</i>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-lebelledby="insDropdown">
                                <li><a class="btn btn-link" style="text-decoration: none;color:black;text-align:left;" type="button" data-toggle="modal" data-target="#insRollModal">วันมาเรียน</a></li>
                                <li><a class="btn btn-link" style="text-decoration: none;color:black;text-align:left;" type="button" data-toggle="modal" data-target="#insTraitModal">คุณลักษณะ & อ่านเขียน</a></li>
                            </ul>
                        </div>
                    </h1>
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
                        $trait_stmt = $conn->prepare("SELECT * FROM `trait` AS tr INNER JOIN `class` AS c ON c.class_id = tr.class_id WHERE c.teacher_id = :tid");
                        $trait_stmt->execute(array(':tid'=>$_SESSION["id"]));
                        $roll_stmt = $conn->prepare("SELECT * FROM `roll` AS r INNER JOIN `class` AS c ON c.class_id = r.class_id WHERE c.teacher_id = :tid");
                        $roll_stmt->execute(array(':tid'=>$_SESSION["id"]));
                        
                        while ($rows2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '
                                <div class="panel panel-primary">
                                    <div class="panel-heading"> 
                                        เทอม '.$rows2["term"].' - ปีการศึกษา '.($rows2["year"]+543).' ('.$func->scheduleStatusText($rows2["status"]).')  
                                    </div>
                                    <div class="panel-body">
                                        <p>'.$rows2["subjects_id"].' <br> '.$rows2['subjects_name'] . ' <br>ชั้น ป.' . $rows2["class_grade"] . '/' . $rows2["class_room"] . '</p>
                                        <a href="'.(($rows2["subjects_type"] != 3) ? "ev5" : "ev5-2") .'.php?sc='.$rows2["schedule_id"].'"><button class="btn btn-success">บันทึกคะแนน</button></a> 
                                        <a href="ev5-times.php?sc='.$rows2["schedule_id"].'"><button class="btn btn-info">ลงชั่วโมงเรียน</button></a>
                                        <button class="btn btn-primary '.(($rows2["status"] == 2 || $rows2["status"] == 3) ? "disabled" : "" ).'" type="button" data-toggle="modal" data-target="#sendGradeModal" data-scid="'.$rows2["schedule_id"].'" data-sjid="'.$rows2["subjects_id"].'" data-cgrade="'.$rows2["class_grade"].'/'.$rows2["class_room"].'" '.(($rows2["status"] == 2 || $rows2["status"] == 3) ? 'disabled="disabled"' : "" ).'>ส่งเกรด</button>
                                    </div>
                                </div>';
                        }

                        while ($trait_rows = $trait_stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '
                                <div class="panel panel-info">
                                    <div class="panel-heading"> 
                                        เทอม '.$trait_rows["term"].' - ปีการศึกษา '.($trait_rows["year"]+543).'  
                                    </div>
                                    <div class="panel-body">
                                        <p> คุณลักษณะ & อ่าน-เขียน <br>ชั้น ป.' . $trait_rows["class_grade"] . ' ห้อง ' . $trait_rows["class_room"] . '</p> 
                                        <a href="ev5-trait.php?tr='.$trait_rows["trait_id"].'&c='.$trait_rows["class_id"].'"><button class="btn btn-success">บันทึกคะแนน</button></a>
                                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#delTraitModal" data-trid="'.$trait_rows["trait_id"].'" data-term="'.$trait_rows["term"].'" data-year="'.$trait_rows["year"].'"><i class="fas fa-times fa-fw"></i> ลบ</button>
                                    </div>
                                </div>';
                        }

                        while ($roll_rows = $roll_stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '
                                <div class="panel panel-warning">
                                    <div class="panel-heading"> 
                                        เทอม '.$roll_rows["term"].' - ปีการศึกษา '.($roll_rows["year"]+543).'  
                                    </div>
                                    <div class="panel-body">
                                        <p> ลงวันมาเรียน <br>ชั้น ป.' . $roll_rows["class_grade"] . ' ห้อง ' . $roll_rows["class_room"] . '</p> 
                                        <a href="ev5-roll.php?r='.$roll_rows["roll_id"].'&c='.$roll_rows["class_id"].'"><button class="btn btn-success">บันทึกวันมาเรียน</button></a>
                                        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#delRollModal" data-rid="'.$roll_rows["roll_id"].'" data-term="'.$roll_rows["term"].'" data-year="'.$roll_rows["year"].'"><i class="fas fa-times fa-fw"></i> ลบ</button>
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

    <!-- Modal - Insert Roll -->
    <div class="modal fade" id="insRollModal" tabindex="-1" role="dialog" aria-labelledby="insRollModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                    </button>
                    <h4 class="modal-title" id="insRollModalTitle"><i class="fas fa-plus-circle fa-fw"></i> เพิ่มวันมาเรียน</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="insRollForm">
                        <div class="form-group">
                            <label for="rclass" class="col-xs-3 control-label">ชั้น</label>
                            <div class="col-xs-9">
                                <select class="form-control" name="rclass" id="rclass" required>
                                    <?php 
                                        $class_stmt = $conn->prepare("SELECT * FROM `class` WHERE `teacher_id` = '".$_SESSION["id"]."'");
                                        $class_stmt->execute();
                                        while ( $class_rows = $class_stmt->fetch(PDO::FETCH_ASSOC) ) {
                                            echo '<option value="'.$class_rows["class_id"].'">ป.'.$class_rows["class_grade"].'/'.$class_rows["class_room"].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ryear" class="col-xs-3 control-label">ปีการศึกษา</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" id="ryear" name="ryear" value="" placeholder="Year" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rterm" class="col-xs-3 control-label">เทอม</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="number" id="rterm" name="rterm" min="1" max="" value="" placeholder="Term" required />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit" form="insRollForm" name="insRollBtn" value="true"><i class="fas fa-plus-circle fa-fw"></i> Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Insert Roll -->

    <!-- Modal - Insert Trait -->
    <div class="modal fade" id="insTraitModal" tabindex="-1" role="dialog" aria-labelledby="insTraitModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times"></i>
                    </button>
                    <h4 class="modal-title" id="insTraitModalTitle"><i class="fas fa-plus-circle fa-fw"></i> เพิ่มคุณลักษณะ & อ่านเขียน</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="insTraitForm">
                        <div class="form-group">
                            <label for="trclass" class="col-xs-3 control-label">ชั้น</label>
                            <div class="col-xs-9">
                                <select class="form-control" name="trclass" id="trclass" required>
                                    <?php 
                                        $class_stmt = $conn->prepare("SELECT * FROM `class` WHERE `teacher_id` = '".$_SESSION["id"]."'");
                                        $class_stmt->execute();
                                        while ( $class_rows = $class_stmt->fetch(PDO::FETCH_ASSOC) ) {
                                            echo '<option value="'.$class_rows["class_id"].'">ป.'.$class_rows["class_grade"].'/'.$class_rows["class_room"].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tryear" class="col-xs-3 control-label">ปีการศึกษา</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" id="tryear" name="tryear" value="" placeholder="Year" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="trterm" class="col-xs-3 control-label">เทอม</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="number" id="trterm" name="trterm" min="1" max="" value="" placeholder="Term" required />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-success" type="submit" form="insTraitForm" name="insTraitBtn" value="true"><i class="fas fa-plus-circle fa-fw"></i> Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Insert Trait -->

    <!-- Modal - Delete Roll -->
    <div class="modal fade" id="delRollModal" tabindex="-1" role="dialog" aria-labelledby="delRollModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    <h4 class="modal-title">ลบข้อมูลวันมาเรียน</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="delRollForm">
                        <p>
                            คุณแน่ใจที่จะลบข้อมูล <strong></strong> หรือไม่
                            <input type="hidden" value="" name="rid" />
                            <input type="hidden" value="" name="term" />
                            <input type="hidden" value="" name="year" />
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit" form="delRollForm" name="delRollBtn" value="true"><i class="fas fa-times fa-fw"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Delete Roll -->

    <!-- Modal - Delete Trait -->
    <div class="modal fade" id="delTraitModal" tabindex="-1" role="dialog" aria-labelledby="delTraitModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    <h4 class="modal-title">ลบข้อมูลนักเรียน</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="delTraitForm">
                        <p>
                            คุณแน่ใจที่จะลบข้อมูล <strong></strong> หรือไม่
                            <input type="hidden" value="" name="trid" />
                            <input type="hidden" value="" name="term" />
                            <input type="hidden" value="" name="year" />
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit" form="delTraitForm" name="delTraitBtn" value="true"><i class="fas fa-times fa-fw"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Delete Trait -->

    <!-- Modal - Send Grade -->
    <div class="modal fade" id="sendGradeModal" tabindex="-1" role="dialog" aria-labelledby="sendGradeModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
                    <h4 class="modal-title">ส่งเกรด</h4>
                </div>
                <div class="modal-body">
                    <form method="post" id="sendGradeForm">
                        <p>
                            คุณแน่ใจที่จะส่งเกรด <strong></strong> หรือไม่
                            <input type="hidden" value="" name="scid" />
                            <input type="hidden" value="" name="sjid" />
                            <input type="hidden" value="" name="cgrade" />
                        </p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" form="sendGradeForm" name="sendGradeBtn" value="true"><i class="fas fa-times fa-fw"></i> Send</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal - Send Grade -->

    <?php include_once('js.inc.php') ?>
    <script>
        $('#delRollModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var rid = button.data('rid');
            var term = button.data('term');
            var year = button.data('year');

            var modal = $(this);
            modal.find('.modal-body p strong').text(rid);
            modal.find('.modal-body input[name=rid]').val(rid);
            modal.find('.modal-body input[name=term]').val(term);
            modal.find('.modal-body input[name=year]').val(year);
        });

        $('#delTraitModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var trid = button.data('trid');
            var term = button.data('term');
            var year = button.data('year');

            var modal = $(this);
            modal.find('.modal-body p strong').text(trid);
            modal.find('.modal-body input[name=trid]').val(trid);
            modal.find('.modal-body input[name=term]').val(term);
            modal.find('.modal-body input[name=year]').val(year);
        });

        $('#sendGradeModal').on('show.bs.modal', function(e) {
            var button = $(e.relatedTarget);
            var scid = button.data('scid');
            var sjid = button.data('sjid');
            var cgrade = button.data('cgrade');

            var modal = $(this);
            modal.find('.modal-body p strong').text("วิชา " + sjid + " - ชั้น " + cgrade);
            modal.find('.modal-body input[name=scid]').val(scid);
            modal.find('.modal-body input[name=sjid]').val(sjid);
            modal.find('.modal-body input[name=cgrade]').val(cgrade);
        });
    </script>

</body>

</html>
