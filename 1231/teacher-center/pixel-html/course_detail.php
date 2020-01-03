<?php
include_once (dirname(__FILE__)."/../../inc/config.inc.php");
include_once '../../inc/mysql.inc.php';
include_once '../../inc/tool.inc.php';
$link = connect();
$member_id=is_login($link);//是否登录

if(!$member_id){
	skip_message('../../index.php', '您未登录！');
}

$myname="select * from Teacher where teano={$member_id}";
$myname=execute($link,$myname);
$myname=mysqli_fetch_assoc($myname);
$myname=$myname['name'];

//删除学生
if(isset($_GET['del_sno_id'])){
    $sno_id=intval($_GET['del_sno_id']);
    $query="delete from SeleWork where sno=$sno_id";
    execute($link, $query);
    $query="delete from Answer where sno=$sno_id";
    execute($link, $query);
    $query="delete from Q_A where sno=$sno_id";
    execute($link, $query);
    $query="delete from Talk where sno=$sno_id";
    execute($link, $query);
    $query="delete from Student where sno=$sno_id";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){     //删除成功
        skip_with_alert('course_detail.php','删除成功');
    }
}

//删除课件
if(isset($_GET['del_fno_id'])){
    $fno_id=intval($_GET['del_fno_id']);
    $query="delete from Course_File where fno=$fno_id";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){     //删除成功
        skip_with_alert('course_detail.php','删除成功');
    }
}

//公告上传
if(isset($_POST['board_submit'])){
    $top_board="select * from Board where bno=(select max(bno) from Board)";
    $top_board=execute($link,$top_board);
    $top_board=mysqli_fetch_assoc($top_board);
    $top_board=$top_board['bno'];
    $top_board++;

    $query="insert into Board (bno, brief, text, btime, bteacher) values ({$top_board},'{$_POST['board_brief']}','{$_POST['board_text']}',now(),'$myname')";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        skip_with_alert('course_detail.php', '公告发表成功！');
    }
    else{
        skip_with_alert('course_detail.php', '公告发表失败！');
    }
}

//公告上传
if(isset($_POST['book_submit'])){

    $query="insert into Course_Book (book_name) values ('{$_POST['book_name']}')";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        skip_with_alert('course_detail.php', '教材发布成功！');
    }
    else{
        skip_with_alert('course_detail.php', '教材发表失败！');
    }
}

//公告删除
if(isset($_GET['del_bno_id'])){
    $bno_id=intval($_GET['del_bno_id']);
    $query="delete from Board where fno=$bno_id";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){     //删除成功
        skip_with_alert('course_detail.php','删除成功');
    }
}

//教材删除
if(isset($_GET['del_book_name'])){
    $del_book_name=$_GET['del_book_name'];
    $query="delete from Course_Book where book_name=$del_book_name";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){     //删除成功
        skip_with_alert('course_detail.php','删除成功');
    }
}

//视频删除
if(isset($_GET['del_vno_id'])){
    $vno_id=intval($_GET['del_vno_id']);
    $query="delete from Video where vno=$vno_id";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){     //删除成功
        skip_with_alert('course_detail.php','删除成功');
    }
}

?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>个人信息</title>
    <!-- Bootstrap Core CSS -->
    <link href="../pixel-html/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="../pixel-html/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../pixel-html/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="../pixel-html/css/colors/blue-dark.css" id="theme" rel="stylesheet">
    <link href="../pixel-html/css/public.css" rel="stylesheet">
<!--  <link rel="stylesheet" href="css/bootstrap.min.css"> -->

 
    <!-- Styles -->
    <link rel="stylesheet" href="a.css">
    <style type="text/css">
        input[type="radio"] {
            display: none;
        }
        input[type="radio"]+span {
            display: inline-block;
            width: 18px;
            height: 18px;
            vertical-align: middle;
            border-radius: 50%;
            border: 6px solid #C0C0C0;
            background-color: #ddd;
        }
        input[type="radio"]:checked+span {
            border: 6px solid #2F4F4F;
            background-color: #F0FFF0;
        }
    </style>

    <style type="text/css">
        #detail{
            display:none;
            width:100px;
            height:100px;
            background:#CCC;
            border:1px solid #333;
            padding:12px;
            text-align:center;
        }
    </style>

    <script src="./js/jquery-3.3.1.min.js">
    </script>
    <script>
        $(document).ready(function(){
            $("#board").click(function(){
                
                html='';
                html+="<div class='comment-center'><div class=col-lg-12 col-md-12 col-sm-12'><div class='contact-form'>"
                html+="<form action='course_detail.php' method='post'>";
                html+="<div class='reply_textarea'>";
                html+="<textarea name='board_brief' cols='105' rows='1' required placeholder='请输入公告标题（此为必填字段）'></textarea><br/>";
                html+="<textarea name='board_text' cols='105' rows='5' required placeholder='请输入公告内容（此为必填字段）'></textarea><br/>";
                html+="<input type='submit' name='board_submit' value='提交' /></div></form></div></div></div>";
            $("#add_board").append(html);
            });
            $("#book").click(function(){
                html='';
                html+="<div class='comment-center'><div class=col-lg-12 col-md-12 col-sm-12'><div class='contact-form'>"
                html+="<form action='course_detail.php' method='post'>";
                html+="<div class='reply_textarea'>";
                html+="<textarea name='book_name' cols='105' rows='1' required placeholder='请输入教材名（此为必填字段）'></textarea><br/>";
                html+="<input type='submit' name='book_submit' value='提交' /></div></form></div></div></div>";
            $("#add_book").append(html);
            });
        });
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
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a>
                <div class="top-left-part"><a class="logo" href="tea_self-center.php"><b><img src="../plugins/images/pixeladmin-logo.png" alt="home" /></b><fond style="font-size:25px">个人中心</fond></a></div>
                <ul class="nav navbar-top-links navbar-left m-l-20 hidden-xs">
                    <li>
                        <form role="search" class="app-search hidden-xs">
                            <input type="text" placeholder="个人中心" class="form-control"> <a href="tea_self-center.php"><i class="fa fa-search"></i></a>
                        </form>
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <a class="profile-pic"> <img src="../plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">
                        <?php echo $myname ?>
						</b> </a>
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
                        <h4 class="page-title">课程详情</h4> </div>
                        <ol class="breadcrumb">
                            <li><a href="../../index.php">首页</a></li>
                            <li><a href="../../sign-out.php">退出</a></li>
                        </ol>
                    </div>
                </div>

                <!-- 显示课程情况 -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <tbody>
                                <tr>
                                    <td>课程名称：网络安全</td><br>
                                    <td>开设学院：网络空间安全学院</td><br>
                                    <td>任课老师：</td>
                                    <?php
                                    $query = "select * from Teacher";
                                    $result_teacher=execute($link, $query);
                                    while($data_teacher=mysqli_fetch_assoc($result_teacher)){
                                        $teacher=$data_teacher['name'];
                                        $html=<<<A
                                        <td>$teacher</td>
A;
                                        echo $html;
                                    }
                                    ?><br>
                                    <td>使用教材：</td>
                                    <?php
                                    $query = "select * from Course_Book";
                                    $result_book=execute($link, $query);
                                    while($data_book=mysqli_fetch_assoc($result_book)){
                                        $book=$data_book['book_name'];
                                        $html=<<<A
                                        <td>$book</td>
A;
                                        echo $html;
                                    }
                                    ?><br>
                                </tr>
                            </tbody>
                            <form method="post">
                            <div id="add_book"></div>
                                <input type="button" id="book" name="book" value="添加教材">
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 显示学生情况 -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">选课学生情况</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>学号</th>
                                            <th>姓名</th>
                                            <th>班级</th>
                                            <th>学院</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $query="select * from Student";
                                    $result_student=execute($link, $query);
                                    $num=0;
                                    while ($data_student=mysqli_fetch_assoc($result_student)){
                                        $num++;
                                        $sno = $data_student['sno'];
                                        $name = $data_student['name'];
                                        $class = $data_student['class'];
                                        $college = $data_student['college'];
                                $html=<<<A
                                            <tbody>
                                            <tr>
                                                <td>$num</td>
                                                <td>$sno</td>
                                                <td>$name</td>
                                                <td>$class</td>
                                                <td>$college</td>
                                                <form method="get">
                                                    <td><a href="course_detail.php?del_sno_id=$sno" >删除</ a></td>
                                                <form>
                                            </tr>
                                            </tbody>
A;
                                        echo $html; 
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 课程资料 -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">课程资料</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>名称</th>
                                            <th>链接</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $query="select * from Course_File";
                                    $result_file=execute($link, $query);
                                    $num=0;
                                    while ($data_file=mysqli_fetch_assoc($result_file)){
                                        $num++;
                                        $cfname = $data_file['cfname'];
                                        $flink = $data_file['flink'];
                                        $fno = $data_file['fno'];
                                $html=<<<A
                                            <tbody>
                                            <tr>
                                                <td>$num</td>
                                                <td>$cfname</td>
                                                <td>$flink</td>
                                                <form method="get">
                                                    <td><a href="course_detail.php?del_fno_id=$fno" >删除</ a></td>
                                                <form>
                                            </tr>
                                            </tbody>
A;
                                        echo $html; 
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 显示公告情况 -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">公告</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>标题</th>
                                            <th>发布时间</th>
                                            <th>发布者</th>
                                            <th>详情</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $query="select * from Board";
                                    $result_board=execute($link, $query);
                                    $num=0;
                                    while ($data_board=mysqli_fetch_assoc($result_board)){
                                        $num++;
                                        $bno = $data_board['bno'];
                                        $brief = $data_board['brief'];
                                        $text = $data_board['text'];
                                        $btime = $data_board['btime'];
                                        $bteacher = $data_board['bteacher'];
                                $html=<<<A
                                            <tbody>
                                            <tr>
                                                <td>$num</td>
                                                <td>$brief</td>
                                                <td>$btime</td>
                                                <td>$bteacher</td>
                                                <td><a id="no_detail">详情</a></td>
                                                <div id="detail">{$text}</div>
                                                <form method="get">
                                                    <td><a href="course_detail.php?del_bno_id=$bno" >删除</ a></td>
                                                <form>
                                            </tr>
                                            </tbody>
A;
                                        echo $html; 
                                    }
                                    ?>
                                </table>
                            </div>
                            <form method="post">
                            <div id="add_board"></div>
                                <input type="button" id="board" name="board" value="添加公告">
                            </form>
                        </div>
                    </div>
                    
                </div>
                
                <!-- 显示视频情况 -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">学习视频</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>标题</th>
                                            <th>章节</th>
                                            <th>链接</th>
                                            <th>发布者</th>
                                            <th>发布时间</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $query="select * from Video";
                                    $result_video=execute($link, $query);
                                    $num=0;
                                    while ($data_video=mysqli_fetch_assoc($result_video)){
                                        $num++;
                                        $vno = $data_video['vno'];
                                        $vname = $data_video['vname'];
                                        $vzhang = $data_video['vzhang'];
                                        $vlink = $data_video['vlink'];
                                        $vteacher = $data_video['vteacher'];
                                        $vtime = $data_video['vtime'];
                                $html=<<<A
                                            <tbody>
                                            <tr>
                                                <td>$num</td>
                                                <td>$vname</td>
                                                <td>$vzhang</td>
                                                <td>$vlink</td>
                                                <td>$vteacher</td>
                                                <td>$vtime</td>
                                                <form method="get">
                                                    <td><a href="course_detail.php?del_vno_id=$vno" >删除</ a></td>
                                                <form>
                                            </tr>
                                            </tbody>
A;
                                        echo $html; 
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../pixel-html/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="../pixel-html/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="../pixel-html/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="../pixel-html/js/custom.min.js"></script>

    <script>
        (function(){
            var no_detail = document.getElementById('no_detail');
            var detail = document.getElementById('detail');
            no_detail.onmouseover = function(){
                detail.style.display = 'block';
            }
            no_detail.onmouseout = function(){
                detail.style.display = 'none';
            }
        })();
    </script>
    
    
   
</body>

</html>
