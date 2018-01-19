<?php include_once('../../../lib/conn.php'); ?>
<?php
    if(!$user->isLogin() || !$user->isStudent()){
        $user->redirect("../../../index.php");
    }
?>
<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["logout"])) {
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
                        <i class="fas fa-user fa-fw" aria-hidden="true"></i> <?php echo $_SESSION["firstname"] . " " . $_SESSION["lastname"]; ?> <i class="fa fa-caret-down" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="profile.php"><i class="fas fa-user fa-fw" aria-hidden="true"></i> User Profile</a>
                        </li>
                        <li><a href="settings.php"><i class="fas fa-cog fa-fw" aria-hidden="true"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#" onclick="document.getElementById('logout').submit();"><i class="fas fa-sign-out-alt fa-fw"></i> Logout</a>
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
                            <a href="index.php"><i class="fas fa-home fa-fw" aria-hidden="true"></i> หน้าหลัก</a>
                        </li>
                        <li>
                            <a href="school-record.php"><i class="fa fa-table fa-fw" aria-hidden="true"></i> ผลการเรียน</a>
                        </li>
                        <li>
                            <a href="Evaluation-6.php"><i class="fas fa-edit fa-fw" aria-hidden="true"></i> ปพ.6</a>
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

