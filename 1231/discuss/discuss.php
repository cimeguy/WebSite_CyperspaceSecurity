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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hello World</title>

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
                                <h1 class="site-title"  style="font-size:40px"><a href="../index.php" rel="home">网络安全<span>课程</span></a></h1>
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
                        <li>讨论</li>
                    </ul>
                </div><!-- .breadcrumbs -->
            </div><!-- .col -->
        </div><!-- .row -->

        <div class="icon-boxes">
            <div class="container-fluid">
                <div class="flex flex-wrap align-items-stretch">
    
                    <div class="icon-box-talk">
                        <div class="icon">
                            <span class="ti-book"></span>
                        </div><!-- .icon -->
    
                        <header class="entry-header">
                            <h2 class="entry-title">综合讨论区</h2>
                        </header><!-- .entry-header -->
    
                        <div class="entry-content">
                            <p>发表任何想与大家分享的经验及想法！关于本课程、学习、工作、生活等一般性话题</p>
                        </div><!-- .entry-content -->
    
                        <footer class="entry-footer read-more">
                            <a href="discuss_com.php">进入<i class="fa fa-long-arrow-right"></i></a>
                        </footer><!-- .entry-footer -->
                    </div><!-- .icon-box -->
    
                    <div class="icon-box-talk">
                        <div class="icon">
                            <span class="ti-world"></span>
                        </div><!-- .icon -->
    
                        <header class="entry-header">
                            <h2 class="entry-title">老师答疑区</h2>
                        </header><!-- .entry-header -->
    
                        <div class="entry-content">
                            <p>发表关于作业、考试、课程内容希望能够得到老师回答的疑问</p>
                        </div><!-- .entry-content -->
    
                        <footer class="entry-footer read-more">
                            <a href="discuss_q_a.php">进入<i class="fa fa-long-arrow-right"></i></a>
                        </footer><!-- .entry-footer -->
                    </div><!-- .icon-box -->
                </div><!-- .row -->
            </div><!-- .container-fluid -->
        </div><!-- .icon-boxes -->

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
