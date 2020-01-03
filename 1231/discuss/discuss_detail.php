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

$talk_tno = isset($_GET["talk_tno"]) ? intval($_GET["talk_tno"]) : '';
if(!$talk_tno){
    $talk_tno = isset($_GET["back_id"]) ? intval($_GET["back_id"]) : '';
}

if(isset($_POST['submit'])){
    $member_id = is_login($link);
    $talk_tno = $_GET['tno'];
    if(!$member_id){
        skip_with_alert('../sign-in.php', '请先登录！');
    }
    else if($isteacher){
        back_with_alert('discuss_detail.php', '您是老师，不能回复！', $talk_tno);
    }
    
    $query = "select * from Talk where tno=$talk_tno and cno=(select max(cno) from Talk where tno=$talk_tno)";
    $talk_cno = execute($link, $query);
    $talk_cno = mysqli_fetch_assoc($talk_cno);
    $talk_cno = (int)$talk_cno['cno'];
    $talk_cno++;

    $query="insert into Talk(tno,cno,sno,text,tarea,ttime,reno)
    values({$talk_tno},{$talk_cno},{$member_id},'{$_POST['replytext']}','{$_GET['tarea']}',now(),{$_GET['cno']})";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        back_with_alert('discuss_detail.php', '回复成功！', $talk_tno);
    }else{
        back_with_alert('discuss_detail.php', '回复失败！', $talk_tno);
    }
}

if(isset($_GET['del_cno'])){
    $del_cno = $_GET['del_cno'];
    $del_tno = $_GET['del_tno'];
    $wno_id=intval($_GET['del_cno_id']);
    $query="delete from Talk where tno=$del_tno and cno=$del_cno";
    execute($link, $query);
    if(mysqli_affected_rows($link)==1){     //删除成功
        back_with_alert('discuss_detail.php', '删除成功！', $del_tno);
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
            var tno_ = $(this).attr("reply_tno");
            var cno_ = $(this).attr("reply_cno");
            var tarea_ = $(this).attr("reply_tarea");
            $(".reply_textarea").remove();
            html='';
            html+="<div class='comment-center'>";
            html+="<div class=col-lg-12 col-md-12 col-sm-12'>";
            html+="<div class='contact-form'>";
            html+="<form action='discuss_detail.php?tno=";
            html+=tno_;
            html+="&cno=";
            html+=cno_;
            html+="&tarea=";
            html+=tarea_;
            html+="' method='post'>";
            html+="<div class='dis_bottom-comment'>";
            html+="<br/><div class='dis_comment-date'>回复：";
            html+=cno_;
            html+="</div></div>";
            html+="<div class='reply_textarea'>";
            html+="<textarea name='replytext' cols='105' rows='5'></textarea><br/>";
            html+="<input type='submit' name='submit' value='回复' />";
            html+="</div></form></div></div></div>";

            $(this).parent().append(html);
        });
        $(".reply_btn").dblclick(function(){
            window.location.href="../index.php";
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
                        <li><a href="discuss_com.php">综合讨论区</a></li>
                        <li><?php echo $talk_tno?></li>
                    </ul>
                </div><!-- .breadcrumbs -->
            </div><!-- .col -->
        </div><!-- .row -->

        <div class="row justify-content-between">

            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="100%" SIZE=3>

                <div class="col-12 col-lg-12">
                    <div class="contact-form">
                        <h3 style="font-size:35px">详情</h3>
                        <?php
                        //$query="select * from Talk order by ttime desc";
                        $query="select * from Talk where tno=$talk_tno order by cno";
                        $result_talk=execute($link, $query);
                        $first_member="select * from Talk where tno=$talk_tno and cno=1";
                        $first_member=execute($link, $first_member);
                        $first_member=mysqli_fetch_assoc($first_member);
                        $first_member=$first_member['sno'];
                        while ($data_talk=mysqli_fetch_assoc($result_talk)){
                            $talk_cno = $data_talk['cno'];
                            $talk_sno = $data_talk['sno'];
                            $talk_text = $data_talk['text'];
                            $talk_ttime = $data_talk['ttime'];
                            $talk_tarea = $data_talk['tarea'];
                            $talk_reno = $data_talk['reno'];

                            $query = "select * from Student where sno=$talk_sno";
                            $name = execute($link, $query);
                            $name = mysqli_fetch_assoc($name);
                            $name = $name['name'];
                            //<li style="font-size: 25px; text-overflow:ellipsis;" >$talk_text</li>
                            if($talk_cno==1){
$html=<<<A
                            <div class="dis_comment-wrap">
                                <div class="dis_comment-block">
                                <a href="javascript:void(0);" class="reply_btn" reply_tno=$talk_tno reply_cno=$talk_cno reply_tarea=$talk_tarea>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="breadcrumbs_top">
                                                <ul class="flex flex-wrap align-items-center p-0 m-0">
                                                    <li style="font-size: 30px">$talk_tarea</li>
                                                    <li style="font-size: 22px">帖号:#$talk_tno</li>
                                                    
                                                </ul>
                                            </div><!-- .breadcrumbs_top -->
                                        </div><!-- .col -->
                                    </div><!-- .row -->
                                    <p class="dis_comment-text">$talk_text</p>
                                    <div class="dis_bottom-comment">
                                        <div class="dis_comment-date">发帖人：$name</div>
                                        <div class="dis_comment-date">&nbsp;&nbsp;&nbsp;&nbsp;发帖时间：$talk_ttime</div>
                                        
A;
                        echo $html;
                        if($member_id==$talk_sno||$member_id==$first_member){
$html=<<<A
                                        <ul class="dis_comment-actions">
                                        <form method="get">
                                            <div class="dis_comment-date">&nbsp;&nbsp;&nbsp;&nbsp;
                                            <li class="complain"><a href="discuss_com.php" >删除</ a></li></div>
                                        <form>
                                        </ul>
A;
                        echo $html;
                        }
$html=<<<A
                                        
                                    </div>
                                </a>
                                </div>
                            </div>
A;
                        echo $html;
                            }
                            else{
$html=<<<A
                            <div class="dis_comment-wrap">
                                <div class="dis_comment-block">
                                <a href="javascript:void(0);" class="reply_btn" reply_tno=$talk_tno reply_cno=$talk_cno reply_tarea=$talk_tarea>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="breadcrumbs_top">
                                                <ul class="flex flex-wrap align-items-center p-0 m-0">
                                                    <li style="font-size: 20px">层号:##&nbsp;$talk_cno</li>
                                                </ul>
                                            </div><!-- .breadcrumbs_top -->
                                        </div><!-- .col -->
                                    </div><!-- .row -->
                                    <p class="dis_comment-text">$talk_text</p>
                                    <div class="dis_bottom-comment">
                                        <div class="dis_comment-date">回复人：$name</div>
                                        <div class="dis_comment-date">&nbsp;&nbsp;&nbsp;&nbsp;回复：$talk_reno</div>
                                        <div class="dis_comment-date">&nbsp;&nbsp;&nbsp;&nbsp;发帖时间：$talk_ttime</div>
                                        
A;
                        echo $html;
                        if($member_id==$talk_sno||$member_id==$first_member){
$html=<<<A
                                        <ul class="dis_comment-actions">
                                        <form method="get">
                                            <div class="dis_comment-date">&nbsp;&nbsp;&nbsp;&nbsp;
                                            <li class="complain"><a href="discuss_detail.php?del_cno=$talk_cno&&del_tno=$talk_tno" >删除</ a></li></div>
                                        <form>
                                        </ul>
A;
                        echo $html;
                        }
$html=<<<A
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

    

    <script type='text/javascript' src='js/jquery.js'></script>
    <script type='text/javascript' src='js/swiper.min.js'></script>
    <script type='text/javascript' src='js/masonry.pkgd.min.js'></script>
    <script type='text/javascript' src='js/jquery.collapsible.min.js'></script>
    <script type='text/javascript' src='js/custom.js'></script>
    

</body>
</html>
