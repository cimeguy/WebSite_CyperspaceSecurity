<?php
include_once (dirname(__FILE__)."/../inc/config.inc.php");
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$link=connect();
$member_id=is_login($link);//是否登录
$isteacher=isteacher($link);

if(!$member_id){//未登录
	$html_login=<<<A
		<li><a href="../sign-up.php">注册</a></li>
		<li><a href="../sign-in.php">登录</a></li>
A;
}else if($isteacher){
	$html_login=<<<A
	<li><a href="../teacher-center/pixel-html/tea_self-center.php">老师后台管理系统</a></li>
	<li><a href="../sign-out.php">退出</a></li>
A;
}
else{
	$html_login=<<<A
	<li><a href="../self-center/pixel-html/self-center.php">个人中心</a></li>
	<li><a href="../sign-out.php">退出</a></li>
A;
}

if(isset($_POST['reply_submit'])){
    if(isteacher($link)){
        $qano = $_GET['qano'];
        $tea_name = $_GET['tea'];
        $answer = $_POST['replytext'];

        $query = "update Q_A set qateacher='$tea_name', qanswer='$answer', answer_time=now() where qano={$qano}";
        execute($link, $query);
        if(mysqli_affected_rows($link)==1){
            skip_with_alert('discuss_q_a.php', '回复成功！');
        }else{
            skip_with_alert('discuss_q_a.php', '回复失败！');
        }
    }
    else{
        skip_with_alert('discuss_q_a.php', '您不是老师，不能答疑！');
    }
    
}

if(isset($_POST['new_submit'])){
    $member_id = is_login($link);
    if($member_id){
        $_POST = escape($link, $_POST);

        $query = "select * from Q_A where qano=(select max(qano) from Q_A)";
        $q_a_tno = execute($link, $query);
        $q_a_tno = mysqli_fetch_assoc($q_a_tno);
        $q_a_tno = (int)$q_a_tno['qano'];
        $q_a_tno++;

        $query = "insert into Q_A(qano, sno, qatext, qaarea, qatime) values({$q_a_tno}, {$member_id},'{$_POST['new_content']}','{$_POST['talk_course']}',now())";
        execute($link, $query);
        if(mysqli_affected_rows($link)==1){     //发表讨论内容成功
            skip_with_alert('discuss_q_a.php','评论发表成功！');
        }
    }
    else{
        skip_with_alert('../sign-in.php','请先登录！');
    }
    
}


if(isset($_GET['del_qano'])){
    $del_qano = $_GET['del_qano'];
    $query="delete from Q_A where qano=$del_qano";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){     //删除成功
        skip_with_alert('discuss_q_a.php', '删除成功！');
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>网络安全课程学习系统——讨论区</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.css">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="../css/font-awesome.css">

    <!-- ElegantFonts CSS -->
    <link rel="stylesheet" href="../css/elegant-fonts.css">

    <!-- themify-icons CSS -->
    <link rel="stylesheet" href="../css/themify-icons.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="../css/swiper.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="../style.css">

    <script src="../teacher-center/pixel-html/js/jquery-3.3.1.min.js">
    </script>
<script type="text/javascript">
    $(function(){
        //页面加载完毕后开始执行的事件
        $(".reply_btn").click(function(){
            var qano_ = $(this).attr("reply_qano");
            var name_ = $(this).attr("reply_name");
            var tea_ = $(this).attr("reply_tea");
            $(".reply_textarea").remove();
            html='';
            html+="<div class='comment-center'>";
            html+="<div class=col-lg-12 col-md-12 col-sm-12'>";
            html+="<div class='contact-form'>";
            html+="<form action='discuss_q_a.php?qano=";
            html+=qano_;
            html+="&tea=";
            html+=tea_;
            html+="' method='post'>";
            html+="<div class='dis_bottom-comment'>";
            html+="<br/><div class='dis_comment-date'>回复：";
            html+=name_;
            html+="</div></div>";
            html+="<div class='reply_textarea'>";
            html+="<textarea name='replytext' cols='105' rows='5'></textarea><br/>";
            html+="<input type='submit' name='reply_submit' value='回复' />";
            html+="</div></form></div></div></div>";

            $(this).parent().append(html);
        });
        $(".detail_btn").click(function(){
            var answer = $(this).attr("d_answer");
            var tea = $(this).attr("d_tea");
            var an_time = $(this).attr("d_time");
            html='';
            html+="<div class='comment-center'>";
            html+="<div class=col-lg-12 col-md-12 col-sm-12'>";
            html+="<div class='contact-form'>";
            html+="<div class='dis_bottom-comment'>";
            html+="<br/><div class='dis_comment-date'>回复人：";
            html+=tea;
            html+="</div><div class='dis_comment-date'>&nbsp;&nbsp;&nbsp;&nbsp;回复时间："
            html+=an_time;
            html+="</div></div><br/>";
            html+="<br/><div class='dis_comment-date'>";
            html+=answer;
            html+="</div></div></div></div>";
            $(this).parent().append(html);
        });
    });
        
    </script>
</head>
<body class="contact-page">
    <div class="page-header">
        <header class="site-header">
            <div class="top-header-bar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-lg-6 d-none d-md-flex flex-wrap justify-content-center justify-content-lg-start mb-3 mb-lg-0">
                            <div class="header-bar-email d-flex align-items-center">
                                <i class="fa fa-envelope"></i><a href="#">110@gmail.com</a>
                            </div><!-- .header-bar-email -->

                            <div class="header-bar-text lg-flex align-items-center">
                                <p><i class="fa fa-phone"></i>110 </p>
                            </div><!-- .header-bar-text -->
                        </div><!-- .col -->

                        <div class="col-12 col-lg-6 d-flex flex-wrap justify-content-center justify-content-lg-end align-items-center">
                            <div class="header-bar-search">
                                <form class="flex align-items-stretch">
                                    <input type="search" placeholder="搜索">
                                    <button type="submit" value="" class="flex justify-content-center align-items-center"><i class="fa fa-search"></i></button>
                                </form>
                            </div><!-- .header-bar-search -->

                            <div class="header-bar-menu">
                                <ul class="flex justify-content-center align-items-center py-2 pt-md-0">
                                <?php
                                    echo $html_login;
                                ?>
                                    <!-- <li><a href="./self-center/pixel-html/self-center.php">个人中心</a></li>
                                    <li><a href="../index.php">退出</a></li> -->
                                </ul>
                            </div><!-- .header-bar-menu -->
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .container-fluid -->
            </div><!-- .top-header-bar -->

            <div class="nav-bar">
                <div class="container">
                    <div class="row">
                        <div class="col-9 col-lg-3">
                            <div class="site-branding">
                                <h1 class="site-title"  style="font-size:40px"><a href="index.php" rel="home">网络安全<span>课程</span></a></h1>
                            </div><!-- .site-branding -->
                        </div><!-- .col -->

                        <div class="col-3 col-lg-9 flex justify-content-end align-content-center">
                            <nav class="site-navigation flex justify-content-end align-items-center">
                                <ul class="flex flex-column flex-lg-row justify-content-lg-end align-content-center">
                                    <li class="current-menu-item" style="font-size:20px"><a href="../index.php">首页</a></li>
                                    <li style="font-size:20px"><a href="../introduce.php">介绍</a></li>
                                    <li style="font-size:20px"><a href="../course_info.php">课程</a></li>
                                    <li style="font-size:20px"><a href="./discuss.php">讨论</a></li>
                                    <li style="font-size:20px"><a href="../file.php">下载</a></li>
                                </ul>

                                <div class="hamburger-menu d-lg-none">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div><!-- .hamburger-menu -->

                                <div class="header-bar-cart">
                                    <a href="#" class="flex justify-content-center align-items-center"><span aria-hidden="true" class="icon_bag_alt"></span></a>
                                </div><!-- .header-bar-search -->
                            </nav><!-- .site-navigation -->
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .container -->
            </div><!-- .nav-bar -->
        </header><!-- .site-header -->

        <div class="page-header-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <header class="entry-header">
                            <h1>讨论区</h1>
                        </header><!-- .entry-header -->
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .page-header-overlay -->
    </div><!-- .page-header -->

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumbs">
                    <ul class="flex flex-wrap align-items-center p-0 m-0">
                        <li><a href="../index.php"><i class="fa fa-home"></i> 首页</a></li>
                        <li><a href="discuss.php">讨论</a></li>
                        <li>老师答疑区</li>
                    </ul>
                </div><!-- .breadcrumbs -->
            </div><!-- .col -->
        </div><!-- .row -->

        <div class="row justify-content-between">
            <div class="col-12 col-lg-12">
                <div class="contact-form">
                    <h3 style="font-size:35px">发起新问题</h3>

                    <form method="post">
                        <textarea name="new_content" placeholder="Your Message" rows="4"></textarea>
                        请选择版块：<select name="talk_course">
                            <option value="理论">理论</option>
                            <option value="实验">实验</option>
                        </select>
                        <input type="submit" name="new_submit" value="发送">
                    </form>
                </div><!-- .contact-form -->
            </div><!-- .col -->

            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="100%" SIZE=3>

                <div class="col-12 col-lg-12">
                    <div class="contact-form">
                        <h3 style="font-size:35px">全部主题</h3>
                        <?php
                       
                        //$query="select * from Talk order by ttime desc";
                        $query="select * from Q_A order by qatime desc";
                        $result_q_a=execute($link, $query);

                        while ($data_q_a=mysqli_fetch_assoc($result_q_a)){
                            $q_a_qano = $data_q_a['qano'];
                            $q_a_sno = $data_q_a['sno'];
                            $q_a_text = $data_q_a['qatext'];
                            $q_a_time = $data_q_a['qatime'];
                            $q_a_area = $data_q_a['qaarea'];
                            $q_a_teacher = $data_q_a['qateacher'];
                            $q_a_qanswer = $data_q_a['qanswer'];
                            $q_a_answer_time = $data_q_a['answer_time'];

                            if($member_id){
                                $myname="select * from Teacher where teano={$member_id}";
                                $myname=execute($link,$myname);
                                $myname=mysqli_fetch_assoc($myname);
                                $myname=$myname['name'];
                            }else{
                                $myname="";
                            }
                            

                            $query = "select * from Student where sno=$q_a_sno";
                            $name = execute($link, $query);
                            $name = mysqli_fetch_assoc($name);
                            $name = $name['name'];
                            //<li style="font-size: 25px; text-overflow:ellipsis;" >$talk_text</li>
                            if(!$q_a_teacher){          //尚未回复
$html=<<<A
                            <div class="dis_comment-wrap">
                                <div class="dis_comment-block">
                                <a href="javascript:void(0);" class="reply_btn" reply_qano=$q_a_qano reply_name=$name reply_tea=$myname>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="breadcrumbs_top">
                                                <ul class="flex flex-wrap align-items-center p-0 m-0">
                                                    <li style="font-size: 30px">$q_a_area</li>
                                                
                                                </ul>
                                            </div><!-- .breadcrumbs_top -->
                                        </div><!-- .col -->
                                    </div><!-- .row -->
                                    <p class="dis_comment-text">$q_a_text</p>
                                    <div class="dis_bottom-comment">
                                        <div class="dis_comment-date">发帖人：$name</div>
                                        <div class="dis_comment-date">&nbsp;&nbsp;&nbsp;&nbsp;发帖时间：$q_a_time</div>
                                        <ul class="dis_comment-actions">
                                            <li class="complain">该贴尚未回复</li>
A;
                                    echo $html;
                                    if($member_id==$q_a_sno){
                                        $html=<<<A
                                        
                                        <form method="get">
                                            <li class="complain"><a href="discuss_q_a.php?del_qano=$q_a_qano" >删除</ a></li>
                                        <form>
A;
                                    echo $html;
                                    }
$html=<<<A
                                        </ul>
                                    </div>
                                </a>
                                </div>
                            </div>
A;
                                    echo $html;
                            }
                            else{           //已经回复
$html=<<<A
                            <div class="dis_comment-wrap">
                                <div class="dis_comment-block">
                                <a href="javascript:void(0);" class="detail_btn" d_answer=$q_a_qanswer d_tea=$q_a_teacher d_time=$q_a_answer_time>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="breadcrumbs_top">
                                                <ul class="flex flex-wrap align-items-center p-0 m-0">
                                                    <li style="font-size: 30px">$q_a_area</li>
                                                </ul>
                                            </div><!-- .breadcrumbs_top -->
                                        </div><!-- .col -->
                                    </div><!-- .row -->
                                    <p class="dis_comment-text">$q_a_text</p>
                                    <div class="dis_bottom-comment">
                                        <div class="dis_comment-date">发帖人：$name</div>
                                        <div class="dis_comment-date">&nbsp;&nbsp;&nbsp;&nbsp;发帖时间：$q_a_time</div>
                                        <ul class="dis_comment-actions">
                                            <li class="complain">该贴已回复，单击查看详情</li>
A;
                        echo $html;
                        if($member_id==$q_a_sno||isteacher($link)){
$html=<<<A
                                        
                                        <form method="get">
                                            <li class="complain"><a href="discuss_q_a.php?del_qano=$q_a_qano" >删除</ a></li>
                                        <form>
A;
                        echo $html;
                        }
$html=<<<A
                                        </ul>
                                    </div>
                                </a>
                                </div>
                            </div>
A;
                        echo $html;
                            }
                        }
                        ?>
                        <!-- <form>
                            <textarea placeholder="Your Message" rows="4"></textarea>
                        </form> -->
                    </div><!-- .contact-form -->
                </div><!-- .col -->

        </div><!-- .row -->
    </div><!-- .container -->

    

    <div class="clients-logo">
        <div class="container">
            <div class="row">
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- .clients-logo -->

    

    <script type='text/javascript' src='../js/jquery.js'></script>
    <script type='text/javascript' src='../js/swiper.min.js'></script>
    <script type='text/javascript' src='../js/masonry.pkgd.min.js'></script>
    <script type='text/javascript' src='../js/jquery.collapsible.min.js'></script>
    <script type='text/javascript' src='../js/custom.js'></script>
    

</body>
</html>
