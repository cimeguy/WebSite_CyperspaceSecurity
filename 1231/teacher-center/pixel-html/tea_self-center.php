<?php 
include_once (dirname(__FILE__)."/../../inc/config.inc.php");
include_once '../../inc/mysql.inc.php';
include_once '../../inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);//是否登录

if(!$member_id){
	skip_message('../../index.php', '您未登录！');
}

$myname="select * from Teacher where teano={$member_id}";
$myname=execute($link,$myname);
$myname=mysqli_fetch_assoc($myname);
$myname=$myname['name'];

$sql_count="select count(*) from Q_A";//评论数 
$comment_num=num($link, $sql_count);
$sum =100;
$commentpercent=round(($comment_num/$sum)*100).'%';//评论率

$sql_count="select count(*) from Work";//作业发布数 
$work_num=num($link, $sql_count);

$sql_count="select count(*) from Course_File";//资料数 
$file_num=num($link, $sql_count);

?>
<?php 

if(isset($_POST['submit'])){
    $qano = $_GET['qano'];
    $qateacher = $_GET['qateacher'];
    $qanswer = $_POST['replytext'];
    $query = "update Q_A set qateacher='$qateacher', qanswer='$qanswer', answer_time=now() where qano=$qano";
  
    execute($link,$query);
	if(mysqli_affected_rows($link)==1){
        skip_with_alert('tea_self-center.php', '回复成功！');
    }
    else{
        skip_with_alert('tea_self-center.php', '回复失败！');
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
    <title>个人中心</title>
    <!-- Bootstrap Core CSS -->
    <link href="./bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="../plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="../plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="./css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="./css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="./css/colors/blue-dark.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" href="a.css">

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
                <div class="top-left-part"><a class="logo" href="self-center.php"><b><img src="../plugins/images/pixeladmin-logo.png" alt="home" /></b><fond style="font-size:25px">个人中心</fond></a>
                </div>
                <ul class="nav navbar-top-links navbar-left m-l-20 hidden-xs">
                    <li>
                        <form role="search" class="app-search hidden-xs">
                            <input type="text" placeholder="个人中心" class="form-control"> <a href="self-center.php"><i class="fa fa-search"></i></a>
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
                
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">消息</h4> </div>
                        <ol class="breadcrumb">
                            <li><a href="../../index.php">首页</a></li>
                            <li><a href="../../sign-out.php">退出</a></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- row -->
                <div class="row">
                    <!--col -->
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <div class="col-in row">
                                <div class="col-md-6 col-sm-6 col-xs-6"> <i data-icon="E" class="linea-icon linea-basic"></i>
                                    <h5 class="text-muted vb">评论数</h5> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h3 class="counter text-right m-t-15 text-danger"><?php echo  $comment_num ?></h3> </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                        <?php 
//                                        $html=<<<START
//                                         <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{$commentpercent}"> <span class="sr-only">40% Complete (success)</span> </div>
// START;
//                                        echo $html;
                                       ?> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <!--col -->
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <div class="col-in row">
                                <div class="col-md-6 col-sm-6 col-xs-6"> <i class="linea-icon linea-basic" data-icon="&#xe01b;"></i>
                                    <h5 class="text-muted vb">作业总数</h5> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h3 class="counter text-right m-t-15 text-megna"><?php echo  $work_num ?></h3> </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-megna" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <!--col -->
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <div class="col-in row">
                                <div class="col-md-6 col-sm-6 col-xs-6"> <i class="linea-icon linea-basic" data-icon="&#xe00b;"></i>
                                    <h5 class="text-muted vb">提交资料数</h5> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h3 class="counter text-right m-t-15 text-primary"><?php echo  $file_num ?></h3> </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!--row -->
  
                <!--row -->

                <!-- /.row -->
                <!-- row -->
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">最近发言</h3>  
                           	<div class="comment-center">

                            <?php //寻找所有我回复的人和消息 我的发帖
                            $myname = (string)$myname;
                            $query="select * from Q_A where qateacher='$myname' order by answer_time";//找出我的talk
                            $result_q_a=execute($link,$query);
                            if(num($link,$query)==0){//尚未进行答疑
                                $html=<<<A
                                        <div class="comment-body">
                                            <div class="mail-contnet">
                                            <h5>尚未答疑……</h5>
                                            <span class="mail-desc"></span>
                                            <a href="javacript:void(0)"><i class="ti-close text-danger"></i></a>
                                            <a href="javacript:void(0)" class="action"><i class="ti-check text-success"></i></a>
                                            <span class="time pull-left"></span></div>
                                        </div>
A;
                                echo $html;
                            }
                            else{
                                while ($data_q_a=mysqli_fetch_assoc($result_q_a)){
                                        //我的发言、回复
                                        $html=<<<A
                                            <div class="comment-body">
                                                <div class="mail-contnet">
                                                <h5>我回复了：</h5>
                                                <span class="mail-desc">{$data_q_a['sno']}</span>
                                                <span class="mail-desc">{$data_q_a['qatext']}</span>
                                                <span class="time pull-left">{$data_q_a['qatime']}</span></div>
                                            </div>
                                            <div class="comment-body">
                                                <div class="mail-contnet">
                                                <span class="mail-desc">{$data_q_a['qanswer']}</span>
                                                <span class="time pull-left">{$data_q_a['answer_time']}</span></div>
                                            </div>
A;
                                        echo $html;
                                }
                            }
                            ?>                          
							</div>                                                        	                    
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="white-box">
                        <?php   //得出尚未回复的答疑数量
                        $no_answer=0;
                        $query="select * from Q_A where qanswer=NULL";//找出没答疑的评论
                        $result_no_answer=execute($link,$query);
                        while($data_no_answer=mysqli_fetch_assoc($result_no_answer)) $no_answer++;
                        $htmltitle=<<<A
                        <h3 class="box-title">你有{$no_answer}条消息，单击回复、双击自动跳转：</h3>
                            <div class="message-center">
A;
                        echo $htmltitle;
                        ?>
                        <?php
                        $query="select * from Q_A where qanswer is NULL";//找出没答疑的评论
                        $result_no_answer=execute($link,$query);
                        while ($data_no_answer=mysqli_fetch_assoc($result_no_answer)){
                            $stu_sno = $data_no_answer['sno'];
                            $qano = $data_no_answer['qano'];

                            $query="select * from Student where sno=$stu_sno";
                            $stu_name=execute($link,$query);
                            $stu_name=mysqli_fetch_assoc($stu_name);
                            $stu_name=$stu_name['name'];

                            $html=<<<A
                            <div class="row justify-content-between">
                                <div class=col-lg-12 col-md-12 col-sm-12>
                                    <a href="javascript:void(0);" class="reply_btn" myvalue1=$qano myvalue2=$myname>
                                    <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"><span class="profile-status online pull-right"></span> </div>
                                    <div class="mail-contnet">
                                        <h5>{$stu_name}</h5><span class="mail-desc">{$data_no_answer['qatext']}</span><span class="time">{$data_no_answer['qatime']}</span> 
                                    </div>
                                    </a>
                                </div>
                            </div>
A;
                            echo $html;
                            }
                            ?>
	<!-- if(num($link,$query1)==0){//没有发言
		$html=<<<A
		<a href="#">	
			<span class="profile-status online pull-right"></span> </div>
			<div class="mail-contnet">
			<h5></h5> <span class="mail-desc"></span> <span class="time"></span> </div>
 		</a>
A;
	echo $html; -->
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
    <script src="./../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="./bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="./js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="./js/waves.js"></script>
    <!--Counter js -->
    <script src="../plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="../plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--Morris JavaScript -->
    <script src="../plugins/bower_components/raphael/raphael-min.js"></script>
    <script src="../plugins/bower_components/morrisjs/morris.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="./js/custom.min.js"></script>
    <script src="./js/dashboard1.js"></script>
    <script src="../plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $.toast({
            heading: '欢迎来到个人中心',
            text: '这里你可以他人的评论、作业详情、个人信息',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'info',
            hideAfter: 3500,
            stack: 6
        })
    });
    </script>
    

    <script type="text/javascript">
    $(function(){
        //页面加载完毕后开始执行的事件
        $(".reply_btn").click(function(){
            var qano_ = $(this).attr("myvalue1");
            var myname_ = $(this).attr("myvalue2");
            $(".reply_textarea").remove();
            html='';
            html+="<div class='comment-center'><div class=col-lg-12 col-md-12 col-sm-12'><div class='contact-form'><form action='tea_self-center.php?qano="
            html+=qano_;
            html+="&qateacher=";
            html+=myname_;
			html+="' method='post'><div class='reply_textarea'><textarea name='replytext' cols='105' rows='5'></textarea><br/><input type='submit' name='submit' value='回复' /></div></form></div></div></div>";
		
            $(this).parent().append(html);
        });
        $(".reply_btn").dblclick(function(){
            window.location.href="index.php";
        });
    });
        
    </script>
    
</body>

</html>