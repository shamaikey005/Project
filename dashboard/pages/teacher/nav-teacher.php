<?php include_once(dirname(__DIR__, 3)."/lib/conn.php"); ?>
<?php
    if(!$user->isLogin() || !$user->isTeacher()){
        $user->redirect("../../../index.php");
    }
?>
<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST["logout"] == true) {
            $user->logout();
            $user->redirect("../../../index.php");
        }
    }
?>
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">ยินดีต้อนรับเข้าสู่ระบบเกรดออนไลน์</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw" aria-hidden="true"></i> <?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="profile.php"><i class="fa fa-user fa-fw" aria-hidden="true"></i> User Profile</a>
                        </li>
                        <li><a href="settings.php"><i class="fa fa-gear fa-fw" aria-hidden="true"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                        <a href="#" onclick="document.getElementById('logout').submit();"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> Logout</a>
                            <form method="post" id="logout"><input type="hidden" name="logout" value="true"></form>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw" aria-hidden="true"></i> หน้าหลัก</a>
                        </li>
                        <li>
                            <a href="interaction-rating.php"><i class="fa fa-table fa-fw" aria-hidden="true"></i> อัตราการให้คะแนน</a>
                        </li>
                        <li>
                            <a href="evaluation-5.php"><i class="fa fa-edit fa-fw" aria-hidden="true"></i> ปพ.5</a>
                        </li>
                        <li>
                            <a href="evaluation-6.php"><i class="fa fa-edit fa-fw" aria-hidden="true"></i> ปพ.6</a>
                        </li>
                        <li>
                            <a href="check-grade1.php"><i class="fa fa-edit fa-fw" aria-hidden="true"></i> เกรดรวม</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw" aria-hidden="true"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>