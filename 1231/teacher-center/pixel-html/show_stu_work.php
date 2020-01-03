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

$get_wno = isset($_GET["stu_wno"]) ? intval($_GET["stu_wno"]) : '';
$get_sno = isset($_GET["stu_sno"]) ? intval($_GET["stu_sno"]) : '';
$query="select wname from Work where wno=$get_wno";
$result_work=execute($link, $query);
$data_work=mysqli_fetch_assoc($result_work);
$name = $data_work['wname'];

if(isset($_POST['score_submit'])){
    @$score = $_POST['data']['score'];
    @$score_num = count($score);
    $final_score=0;
    for($i=0;$i<$score_num;$i++){
        echo $score[$i];
        $final_score += (int)$score[$i];
    }
    $query="update SeleWork set grade={$final_score} where wno={$get_wno} and sno={$get_sno};";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){     
        back_with_alert('tea_homework_detail.php','分数提交成功！',$get_wno); 
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
    <link href="./bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="./css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="./css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="./css/colors/blue-dark.css" id="theme" rel="stylesheet">
    <link href="./css/publish.css" rel="stylesheet">
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
.alert-success {
            display: flex;
            border-color:#63c59c;
            background-color: #e8f7e0;
            color:#000000;
        }
.alert-success[name="final"] {
            display: flex;
            border:none;
            background-color: rgba(255,255,255,0.5);
            color:#000000;
        }
</style>
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
                <div class="top-left-part"><a class="logo" href="self-center.php"><b><img src="../plugins/images/pixeladmin-logo.png" alt="home" /></b><fond style="font-size:25px">个人中心</fond></a></div>
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
                <div class="center p-20">
                </div>
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">作业：<?php
                            echo $name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;学生（&nbsp;<?php
                            echo $get_sno; ?>）的答题详情：
                        </h4> </div>
                        <ol class="breadcrumb">
                            <li><a href="#" onClick="javascript :history.back(-1);">
                           			 返回
                            	</a>
                            </li>
                           
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- row -->
                <form method="post">
                <?php
                    $query="select * from Question where wno=$get_wno";
                    $result_question = execute($link,$query);
                    
                    while ($data_question=mysqli_fetch_assoc($result_question)){
                        $qno=$data_question['qno'];
                        $qtitle=$data_question['qtitle'];
                        $qscore=$data_question['qscore'];
                        $qkey=$data_question['qkey'];

                        $query="select * from Answer where wno=$get_wno and sno=$get_sno and qno=$qno";
                        $result_answer = execute($link,$query);
                            $data_answer = mysqli_fetch_object($result_answer);
                            @$atext = $data_answer->atext;
                        
                        if($data_question['is_select']=='1'){     //该题为选择题
                            $query="select * from Q_Choose where wno=$get_wno and qno=$qno";
                            $result_this = execute($link,$query);
                            $data_this = mysqli_fetch_assoc($result_this);
                            $this_A=$data_this['A'];
                            $this_B=$data_this['B'];
                            $this_C=$data_this['C'];
                            $this_D=$data_this['D'];
$html_select=<<<A
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="white-box">
                                        <section id="spinner">
                                            <h4><b>第{$qno}题：&nbsp;&nbsp;&nbsp;&nbsp;分值：&nbsp;{$qscore}</b></h4>             
                                            <div class="alert alert-success" style="font-size:20px">{$qtitle} </br>
                                                &emsp;A:&ensp;{$this_A}<br/>
                                                &emsp;B:&ensp;{$this_B}<br/>
                                                &emsp;C:&ensp;{$this_C}<br/>
                                                &emsp;D:&ensp;{$this_D}<br/>
                                            </div>
                                            <div class="alert alert-success">标准答案：{$qkey} </div>
                                            <div class="alert alert-success" name="final">学生答案：{$atext} </div>
                                            <div class="row icon-list-demo">
                                                <div class="col-12 col-lg-12">
                                                    <div class="contact-form">
                                                        <textarea id="score" name=data[score][] placeholder="请输入得分" rows="1" required  oninvalid="setCustomValidity('请输入分数')" οninput="setCustomValidity('')"></textarea>
                                                    </div><!-- .contact-form -->
                                                </div><!-- .col -->      
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
A;
                    echo $html_select;
                        }
                        else
                        {
                            $html_no_select=<<<A
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="white-box">
                                        <section id="spinner">
                                        
                                            <h4><b>第{$qno}题：&nbsp;&nbsp;&nbsp;&nbsp;得分：&nbsp;{$qscore}</b></h4>             
                                            <div class="alert alert-success" style="font-size:20px">题目：{$qtitle} </div>
                                            <div class="alert alert-success" style="font-size:20px">标准答案：{$qkey} </div>
                                            <div class="alert alert-success" style="font-size:20px">学生答案：{$atext} </div>
                                        <!-- 这里开始 -->
                                            <div class="row icon-list-demo">
                                                <div class="col-12 col-lg-12">
                                                    <div class="contact-form">
                                                        <textarea id="score" name=data[score][] placeholder="请输入得分" rows="1" required></textarea>
                                                    </div><!-- .contact-form -->
                                                </div><!-- .col -->      
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
A;
                    echo $html_no_select;
                        }
                    }
                    ?>
                
                    <input type="submit" name="score_submit" value="批改完毕，确认提交">
                </form>
            </div>
            <!-- /.container-fluid -->
<!--             <footer class="footer text-center"> 2019 &copy; Pixel Admin brought to you by wrappixel - More Templates <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a> </footer> -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="./bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="./js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="./js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="./js/custom.min.js"></script>
</body>

</html>
