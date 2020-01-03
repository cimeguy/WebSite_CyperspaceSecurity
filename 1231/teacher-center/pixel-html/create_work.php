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

if(isset($_POST['add_submit'])){
    if(!empty($_POST['work_name'])){

        @$title_choose_result = $_POST['data']['title_choose'];
        @$radio_result = $_POST['data']['radio'];
        @$score_choose_result = $_POST['data']['score_choose'];

        @$title_fill_result = $_POST['data']['title_fill'];
        @$key_fill_result = $_POST['data']['key_fill'];
        @$score_fill_result = $_POST['data']['score_fill'];

        @$title_answer_result = $_POST['data']['title_answer'];
        @$key_answer_result = $_POST['data']['key_answer'];
        @$score_answer_result = $_POST['data']['score_answer'];

        $choose_num = count($title_choose_result);
        $fill_num = count($title_fill_result);
        $answer_num = count($title_answer_result);

        $query = "select * from Work where wno=(select max(wno) from Work )";
        $new_wno = execute($link,$query);
        $new_wno = mysqli_fetch_assoc($new_wno);
        $new_wno = $new_wno['wno'];
        $new_wno++;

        $_POST = escape($link, $_POST);
        $query = "replace into Work ( wno, wname, wcourse, ddl, wchapter, wteacher)
        VALUES
        ( '$new_wno', '{$_POST['work_name']}','{$_POST['work_course']}','{$_POST['work_ddl']}','{$_POST['work_chapter']}','$myname' );";
        execute($link, $query);

        $query = "select * from Student";
        $result_stu = execute($link, $query);
        while($data_stu = mysqli_fetch_assoc($result_stu)){
            $stu_id = $data_stu['sno'];
            $query = "insert into SeleWork ( sno, wno )
            VALUES
            ( '$stu_id', '$new_wno' );";
            execute($link, $query);
        }
        

        //题目表
        //选择题
        $num=0;
        for($i=0;$i<$choose_num;$i++){
            $query = "replace into Question ( wno, qno, qtitle, is_select, qscore, qkey)
            VALUES
            ( '$new_wno', '$i', '$title_choose_result[$i]','1','$score_choose_result[$i]','$radio_result[$i]');";
            execute($link, $query);
            $num++;
        }
        for($i=0;$i<$choose_num;$i++){
            $query = "replace into Q_Choose ( wno, qno, A, B, C, D)
            VALUES
            ( '$new_wno', '$i','{$_POST['data']['choose_1'][$i]}','{$_POST['data']['choose_2'][$i]}','{$_POST['data']['choose_3'][$i]}','{$_POST['data']['choose_4'][$i]}');";
            execute($link, $query);
        }
        //填空题
        for($i=0;$i<$fill_num;$i++){
            $query = "replace into Question ( wno, qno, qtitle, is_select, qscore, qkey)
            VALUES
            ( '$new_wno', '$num', '$title_fill_result[$i]','0','$score_fill_result[$i]','$key_fill_result[$i]');";
            execute($link, $query);
            $num++;
        }
        //简答题
        for($i=0;$i<$answer_num;$i++){
            $query = "replace into Question ( wno, qno, qtitle, is_select, qscore, qkey)
            VALUES
            ( '$new_wno', '$num', '$title_answer_result[$i]','0','$score_answer_result[$i]','$key_answer_result[$i]');";
            execute($link, $query);
            $num++;
        }

        skip_with_alert('tea_homework.php','作业已发布！');
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
    <link href="../pixel-html/css/style2.css" rel="stylesheet">
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
        .text_name{
            border:0;
            border-radius:5px;
            background-color:rgba(241,241,241,.98);
            width: 355px;
            height: 38px;
            padding: 10px;
            resize: none;
        }

    </style>

    <style>
            /* 控制编辑区域的 */
          input[type="date"]::-webkit-datetime-edit{
            /* content: '起始时间'; */
            padding-left: 15px;
            padding-right: 15%;
            height: 20px;
          }
          /* 控制年月日这个区域的 */
          input[type="date"]::-webkit-datetime-edit-fields-wrapper { 
       
          } 
          /* 这是控制年月日之间的斜线或短横线的 */
          input[type="date"]::-webkit-datetime-edit-text {
            color: #333; 
            padding: 0 .3em; 
          } 
          /* 控制年字 */
          input[type="date"]::-webkit-datetime-edit-year-field { 
            color: #333; 
          } 
          /* 控制月字 */
          input[type="date"]::-webkit-datetime-edit-month-field { 
            color: #333; 
          } 
          /* 控制日字 */
          input[type="date"]::-webkit-datetime-edit-day-field  { 
            color: #333; 
          } 
        /*控制下拉小箭头的*/ 
        input[type="date"]::-webkit-calendar-picker-indicator {
          display: inline-block;
          width: 15px;
          height: 15px;
          /* position: absolute;
          top: 12px;
          right: 0px; */
          border: 1px solid #ccc;
          border-radius: 2px;
          box-shadow: inset 0 1px #fff, 0 1px #eee;
          background-color: #eee;
          /* background:url('../images/icon.png') -188px -99px; */
          background-image: -webkit-linear-gradient(top, #f0f0f0, #e6e6e6);
          color: #666; 
        } 
        /* 去掉date中上下小三角，但是保留input类型为number的小三角。 */
        input[type=date]::-webkit-inner-spin-button { 
          visibility: hidden; 
          
        }
        .login-button { /* 按钮美化 */
            width: auto; /* 宽度 */
            height: 30px; /* 高度 */
            padding-left: 15px;
            padding-right: 15px;
            border-width: 0px; /* 边框宽度 */
            border-radius: 3px; /* 边框半径 */
            background: #79aabd; /* 背景颜色 */
            cursor: pointer; /* 鼠标移入按钮范围时出现手势 */
            outline: none; /* 不显示轮廓线 */
            font-family: Microsoft YaHei; /* 设置字体 */
            color: white; /* 字体颜色 */
            font-size: 17px; /* 字体大小 */
        }
        .login-button:hover { /* 鼠标移入按钮范围时改变颜色 */
            background: #516673;
}
    </style>


    <script src="./js/jquery-3.3.1.min.js">
    </script>
    <script>
        var choose_radio=0;
        $(document).ready(function(){
            $("#choose").click(function(){
                html_choose='';
                html_choose+='<div class="row">';
                html_choose+='<div class="col-sm-12">';
                html_choose+='<div class="white-box">';
                html_choose+='<section id="spinner">';
                html_choose+='<div class="row icon-list-demo">';
                html_choose+='<div class="col-12 col-lg-12">';
                html_choose+='<div class="contact-form">';

                html_choose+='<textarea name=data[title_choose][] placeholder="请输入题目" rows="1"></textarea>';
                html_choose+='<br/>';
                html_choose+='<textarea id="choose" name=data[choose_1][] placeholder="选项A" rows="1" width=25%></textarea>';
                html_choose+='<textarea id="choose" name=data[choose_2][] placeholder="选项B" rows="1" cols=25%></textarea>';
                html_choose+='<textarea id="choose" name=data[choose_3][] placeholder="选项C" rows="1" cols=25%></textarea>';
                html_choose+='<textarea id="choose" name=data[choose_4][] placeholder="选项D" rows="1" cols=25%></textarea>';
                html_choose+='<div class="choice" style="font-size:20px">请输入答案：';
                html_choose+='<label class="radio">选项A<input type="radio" value="A" name="data[radio]['+choose_radio+']" checked><i></i></label>';
                html_choose+='<label class="radio">选项B<input type="radio" value="B" name="data[radio]['+choose_radio+']"><i></i></label>';
                html_choose+='<label class="radio">选项C<input type="radio" value="C" name="data[radio]['+choose_radio+']"><i></i></label>';
                html_choose+='<label class="radio">选项D<input type="radio" value="D" name="data[radio]['+choose_radio+']"><i></i></label>';
                html_choose+='<textarea id="choose" name=data[score_choose][] placeholder="请输入分值" rows="1"></textarea>';

                html_choose+='</div><!-- .contact-form -->';                       
                html_choose+='</div><!-- .col -->';   
                html_choose+='</div>';
                html_choose+='</section>';
                html_choose+='</div>';
                html_choose+='</div>';
                html_choose+='</div>';
                choose_radio++;
            $("#create").append(html_choose);
            });
            $("#fill").click(function(){
                html_fill='';
                html_fill+='<div class="row">';
                html_fill+='<div class="col-sm-12">';
                html_fill+='<div class="white-box">';
                html_fill+='<section id="spinner">';
                html_fill+='<div class="row icon-list-demo">';
                html_fill+='<div class="col-12 col-lg-12">';
                html_fill+='<div class="contact-form">';

                html_fill+='<textarea name=data[title_fill][] placeholder="请输入题目" rows="2"></textarea>';
                html_fill+='<br/>';
                html_fill+='<textarea name=data[key_fill][] placeholder="请输入答案" rows="2"></textarea>'; 
                html_fill+='<br/>';
                html_fill+='<textarea id="choose" name=data[score_fill][] placeholder="请输入分值" rows="1"></textarea>';     
                                                
                html_fill+='</div><!-- .contact-form -->';                       
                html_fill+='</div><!-- .col -->';   
                html_fill+='</div>';
                html_fill+='</section>';
                html_fill+='</div>';
                html_fill+='</div>';
                html_fill+='</div>';
            $("#create").append(html_fill);
            });
            $("#answer").click(function(){
                html_answer='';
                html_answer+='<div class="row">';
                html_answer+='<div class="col-sm-12">';
                html_answer+='<div class="white-box">';
                html_answer+='<section id="spinner">';
                html_answer+='<div class="row icon-list-demo">';
                html_answer+='<div class="col-12 col-lg-12">';
                html_answer+='<div class="contact-form">';

                html_answer+='<textarea name=data[title_answer][] placeholder="请输入题目" rows="2"></textarea>';
                html_answer+='<br/>';
                html_answer+='<textarea name=data[key_answer][] placeholder="请输入答案" rows="2"></textarea>'; 
                html_answer+='<br/>';
                html_answer+='<textarea id="choose" name=data[score_answer][] placeholder="请输入分值" rows="1"></textarea>';     
                                                
                html_answer+='</div><!-- .contact-form -->';                       
                html_answer+='</div><!-- .col -->';   
                html_answer+='</div>';
                html_answer+='</section>';
                html_answer+='</div>';
                html_answer+='</div>';
                html_answer+='</div>';
            $("#create").append(html_answer);
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
                        <h4 class="page-title">添加新的作业：</h4> 
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                
                        <form method="post">
                            
                            <fieldset class="contact-inner">
                            <div class="col-md-6">
                                <p class="contact-input">
                                    <textarea class="text_name" name=work_name placeholder="请输入作业名" rows="1" style="font-size:16px" required></textarea>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="contact-input">
                                    <label for="select" class="select">
                                    <select name="work_chapter" id="work_chapter">
                                        <option value="第一章">第一章</option>
                                        <option value="第二章">第二章</option>
                                        <option value="第三章">第三章</option>
                                        <option value="第四章">第四章</option>
                                        <option value="第五章">第五章</option>
                                        <option value="第六章">第六章</option>
                                    </select>
                                    </label>
                                </p>

                                <p class="contact-input">
                                    <label for="select" class="select">
                                    <select name="work_course" id="work_course">
                                        <option value="理论">理论</option>
                                        <option value="实验">实验</option>
                                    </select>
                                    </label>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="contact-submit" style="text-align:center;font-size:16px">
                                    请输入截止时间：<input id="work_ddl" name="work_ddl" type="date" value="2019-12-31" style="font-size:16px"/>
                                </p>
                            </div>
                            </fieldset>
                            
                            <div id="create"></div>
                            <input class="login-button" type="button" id="choose" name="choose" value="添加选择题">
                            <input class="login-button" type="button" id="fill" name="fill" value="添加填空题">
                            <input class="login-button" type="button" id="answer" name="answer" value="添加简答题">
                            <input class="login-button" type="submit" name="add_submit" value="添加完毕，确认提交">
                        </form>
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
    
    
   
</body>

</html>
