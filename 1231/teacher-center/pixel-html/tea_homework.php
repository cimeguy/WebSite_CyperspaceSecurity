<?php
include_once (dirname(__FILE__)."/../../inc/config.inc.php");
include_once '../../inc/mysql.inc.php';
include_once '../../inc/tool.inc.php';
$link = connect();
$member_id=is_login($link);//是否登录
$myname="select * from Teacher where teano={$member_id}";
$myname=execute($link,$myname);
$myname=mysqli_fetch_assoc($myname);
$myname=$myname['name'];

if(isset($_GET['del_wno_id'])){
    $wno_id=intval($_GET['del_wno_id']);
    $query="delete from Question where wno=$wno_id";
    execute($link, $query);
    $query="delete from SeleWork where wno=$wno_id";
    execute($link, $query);
    $query="delete from Q_Choose where wno=$wno_id";
    execute($link, $query);
    $query="delete from Answer where wno=$wno_id";
    execute($link, $query);
    $query="delete from Work where wno=$wno_id";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){     //删除成功
        skip_with_alert('tea_homework.php','删除成功');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>Pixel Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="css/colors/blue-dark.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <script>
    function go_to_create_work(){
        window.open("create_work.php");
    }
    </script>

</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars
"></i></a>
            <div class="top-left-part"><a class="logo" href="self-center.php"><b><img src="../plugins/images/pixeladmin-logo.png" alt="home" /></b><fond style="font-size:25px">个人中心</fond></a></div>
            <ul class="nav navbar-top-links navbar-left m-l-20 hidden-xs">
                    <li>
                        <form role="search" class="app-search hidden-xs">
                            <input type="text" placeholder="个人中心" class="form-control"> <a href=""><i class="fa fa-search"></i></a>
                        </form>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <a class="profile-pic"> <img src="../plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo $myname?></b> </a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li style="padding: 10px 0 0;">
                        <a href="tea_self-center.php" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i><span class="hide-menu">消息</span></a>
                    </li>
                    <li>
                        <a href="tea_information.php" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i><span class="hide-menu">个人信息</span></a>
                    </li>
                    <li>
                        <a href="tea_homework.php" class="waves-effect"><i class="fa fa-table fa-fw" aria-hidden="true"></i><span class="hide-menu">作业情况</span></a>
                    </li>
                    <li>
                        <a href="course_detail.php" class="waves-effect"><i class="fa fa-table fa-fw" aria-hidden="true"></i><span class="hide-menu">课程详情</span></a>
                    </li>
                    
                </ul>
                <div class="center p-20">
                </div>
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">作业列表</h4> </div>
                        <ol class="breadcrumb">
                            <li><a href="../../index.php">首页</a></li>
                            <li><a href="../../sign-out.php">退出</a></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">作业情况</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>名称</th>
                                            <th>章节</th>
                                            <th>理论or实验</th>
                                            <th>发布者</th>
                                            <th>详情</th>
                                            <th>截止时间</th>
                                            <th>批改</th>
                                            <th>删除</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $query="select * from Work order by wno";
                                    $result_work=execute($link, $query);
                                    while ($data_work=mysqli_fetch_assoc($result_work)){
                                        $work_teacher = $data_work['wteacher'];
                                        //if($work_teacher==$myname)
                                        {
                                            $work_wno = $data_work['wno'];
                                            $work_wname = $data_work['wname'];
                                            $work_wcourse = $data_work['wcourse'];
                                            $work_ddl = $data_work['ddl'];
                                            $work_wchapter = $data_work['wchapter'];
					    $thistime=(new \DateTime())->format('Y-m-d H:i:s');
                                $html=<<<A
                                            <tbody>
                                            <tr>
                                                <td>$work_wno</td>
                                                <td>$work_wname</td>
                                                <td>$work_wchapter</td>
                                                <td>$work_wcourse</td>
                                                <td>$work_teacher</td>
                                                <td><a href="show_work.php?show_wno=$work_wno" >详情</ a></td>
                                                <td>$work_ddl</td>
A;
                                        echo $html;
                                            if($work_ddl<$thistime){
                                                $html=<<<A
                                                <td><a href="tea_homework_detail.php?pigai_wno=$work_wno" >批改</ a></td>
A;
                                        echo $html;
                                            }
                                            else{
                                                $html=<<<A
                                                <td>未到截止时间，不可修改</td>
A;
                                        echo $html;
                                            }
                                                $html=<<<A
                                                <form method="get">
                                                    <td><a href="tea_homework.php?del_wno_id=$work_wno" >删除</ a></td>
                                                <form>
                                            </tr>
                                            </tbody>
A;
                                        echo $html; 
                                        }
                                        
                                    }
                                    ?>
                                    <tbody>
                                        <tr>
                                            <form>
                                                <td><input type="button" value="添加新作业" onclick="go_to_create_work()"></td>
                                            </form>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
</body>

</html>
