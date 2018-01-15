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
            try {
                $st_stmt = $conn->prepare("SELECT * FROM `student` WHERE `class_id` = :cid");
                $st_stmt->execute(array(":cid"=>$_POST["rclass"]));
                $conn->beginTransaction();
                while ($st_rows = $st_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $conn->exec("INSERT INTO `roll` VALUES ('".$st_rows["student_id"]."', '".$_POST["rclass"]."', 0, 0, 0, 0, ".$_POST["rterm"].", YEAR(CAST(STR_TO_DATE('".($_POST["ryear"] - 543)."', '%Y') AS DATE)))");
                }
                $conn->commit();
                unset($_POST["insRollBtn"]);
                $user->redirect("Evaluation-5.php");
            } catch (PDOException $e) {
                $conn->rollback();
                echo 'ERROR : ' . $e->getMessage();
            }
        }

        if (isset($_POST["insTraitBtn"])) {
            try {
                $st_stmt = $conn->prepare("SELECT * FROM `student` WHERE `class_id` = :cid");
                $st_stmt->execute(array(":cid"=>$_POST["rclass"]));
                $conn->beginTransaction();
                while ($st_rows = $st_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $conn->exec("INSERT INTO `trait` VALUES ('".$st_rows["student_id"]."', '".$_POST["rclass"]."', 0, 0, 0, 0, 0, 0, 0, 0, 0, ".$_POST["rterm"].", YEAR(CAST(STR_TO_DATE('".($_POST["ryear"] - 543)."', '%Y') AS DATE)))");
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
                                <li><a class="btn btn-link" style="text-decoration: none;color:black;text-align:left;" type="button" data-toggle="modal" data-target="#insTraitModal">อัตลักษณ์ & อ่านเขียน</a></li>
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
                                <div class="panel panel-'.$func->scheduleStatusPanel($rows2["status"]).'">
                                    <div class="panel-heading"> 
                                        เทอม '.$rows2["term"].' - ปีการศึกษา '.($rows2["year"]+543).'  
                                    </div>
                                    <div class="panel-body">
                                        <p>'.$rows2['subjects_name'] . ' <br>ชั้น ป.' . $rows2["class_grade"] . ' ห้อง ' . $rows2["class_room"] . '</p>
                                        <a href="ev5.php?sc='.$rows2["schedule_id"].'"><button class="btn btn-success">บันทึกคะแนน</button></a> 
                                        <a href="ev5-times.php?sc='.$rows2["schedule_id"].'"><button class="btn btn-info">ลงชั่วโมงเรียน</button></a>
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
                                        <p> อัตลักษณ์ & อ่าน-เขียน <br>ชั้น ป.' . $trait_rows["class_grade"] . ' ห้อง ' . $trait_rows["class_room"] . '</p> 
                                        <a href="ev5-trait.php?sc='.$trait_rows["class_id"].'"><button class="btn btn-success">บันทึกคะแนน</button></a>
                                        <button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#delTraitModal" data-sjid="'.$rows["subjects_id"].'" data-type="'.$rows["subjects_type"].'"><i class="fas fa-times fa-fw"></i> ลบ</button>
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
                                        <p> เช็ควันมาเรียน <br>ชั้น ป.' . $roll_rows["class_grade"] . ' ห้อง ' . $roll_rows["class_room"] . '</p> 
                                        <a href="ev5-roll.php?c='.$roll_rows["class_id"].'"><button class="btn btn-success">บันทึกวันมาเรียน</button></a>
                                        <button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#delRollModal" data-sjid="'.$rows["subjects_id"].'" data-type="'.$rows["subjects_type"].'"><i class="fas fa-times fa-fw"></i> ลบ</button>
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
                            <label for="ins13" class="col-xs-3 control-label">ชั้น</label>
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
                                <input class="form-control" type="number" id="ryear" name="ryear" min="0" max="5" value="" placeholder="Year" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="rterm" class="col-xs-3 control-label">เทอม</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="number" id="rterm" name="rterm" min="0" max="" value="" placeholder="Term" required />
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
                    <h4 class="modal-title" id="insTraitModalTitle"><i class="fas fa-plus-circle fa-fw"></i> เพิ่มอัตลักษณ์ & อ่านเขียน</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="insTraitForm">
                        <div class="form-group">
                            <label for="ins13" class="col-xs-3 control-label">ชั้น</label>
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
                            <label for="tryear" class="col-xs-3 control-label">ปีการศึกษา</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="number" id="tryear" name="tryear" min="0" max="5" value="" placeholder="Year" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="trterm" class="col-xs-3 control-label">เทอม</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="number" id="trterm" name="trterm" min="0" max="" value="" placeholder="Term" required />
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

    <?php include_once('js.inc.php') ?>

</body>

</html>
