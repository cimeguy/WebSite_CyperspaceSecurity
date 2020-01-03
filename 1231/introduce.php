<?php 
include_once './inc/config.inc.php';
include_once './inc/mysql.inc.php';
include_once './inc/tool.inc.php';
include_once 'head.php';
$link=connect();

$member_id=is_login($link);//是否登录
$isteacher=isteacher($link);

if(!$member_id){//未登录
	$html=<<<A
		<li><a href="sign-up.php">注册</a></li>
		<li><a href="sign-in.php">登录</a></li>
A;
}else if($isteacher){
	$html=<<<A
	<li><a href="./teacher-center/pixel-html/tea_self-center.php">老师后台管理系统</a></li>
	<li><a href="sign-out.php">退出</a></li>
A;
	

}
else{
	$html=<<<A
	<li><a href="self-center.php">个人中心</a></li>
	<li><a href="sign-out.php">退出</a></li>
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
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- ElegantFonts CSS -->
    <link rel="stylesheet" href="css/elegant-fonts.css">

    <!-- themify-icons CSS -->
    <link rel="stylesheet" href="css/themify-icons.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="css/swiper.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="style.css">
</head>
<body class="about-page">
    <div class="page-header">
        <header class="site-header">
            <header class="site-header">
                <div class="top-header-bar">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 col-lg-6 d-none d-md-flex flex-wrap justify-content-center justify-content-lg-start mb-3 mb-lg-0">
                                <div class="header-bar-email d-flex align-items-center">
                                    <i class="fa fa-envelope"></i><a href="#">2017302207</a>
                                </div><!-- .header-bar-email -->

                                <div class="header-bar-text lg-flex align-items-center">
                                    <p><i class="fa fa-phone"></i>2017302230</p>
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
                                        <?php  echo $html;?>
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
                                        <li  style="font-size:20px"><a href="index.php">首页</a></li>
                                    <li class="current-menu-item"  style="font-size:20px"><a href="introduce.php">介绍</a></li>
                                    <li style="font-size:20px"><a href="course_info.php">课程</a></li>
                                    <li style="font-size:20px"><a href="./discuss/discuss.php">讨论</a></li>
                                    <li style="font-size:20px"><a href="file.php">下载</a></li>
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
        </header><!-- .site-header -->

        <div class="page-header-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <header class="entry-header">
                            <h1>系统介绍</h1>
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
                        <li><a href="#"><i class="fa fa-home"></i> 首页</a></li>
                        <li>介绍</li>
                    </ul>
                </div><!-- .breadcrumbs -->
            </div><!-- .col -->
        </div><!-- .row -->

        <div class="row">
            <div class="col-12">
                <div class="about-heading">
                    <h2 class="entry-title">Welcome！</h2>

                    <p>本系统为西北工业大学学生&ensp;高丽、陈湘媚&ensp;自主研发，版权所有，翻版必究！</p><br/><br/>
                </div><!-- .about-heading -->
            </div><!-- .col -->

            <div class="col-12 col-lg-6">
                <div class="about-stories">
                    

                    <ul class="p-0 m-0 green-ticked">
                        <li>注册登录</li>
                        <li>在线讨论（发帖、回复、删除、查看）</li>
                       
                        <li>上传下载（支持图片、PDF、PPT、Word文档、压缩包rar、zip、txt文本）</li>
                    </ul><!-- .green-ticked -->
                </div><!-- .about-stories -->
            </div><!-- .col -->

            <div class="col-12 col-lg-6">
                <div class="about-values">
                    

                    <ul class="p-0 m-0 green-ticked">
                         <li>老师答疑（一对多）</li>
                        <li>作业模块（学生在线完成作业；老师批改、发布作业）</li>
                        <li>公告板（老师可以发布公告）</li>
                        <li>在线观看视频学习</li>
                    </ul><!-- .green-ticked -->
                </div><!-- .about-values -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container -->

    <section class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 align-content-lg-stretch">
                    <header class="heading">
                        <h2 class="entry-title">关于系统</h2>

                        <p>  </p>
                    </header><!-- .heading -->

                    <div class="entry-content ezuca-stats">
                        <div class="stats-wrap flex flex-wrap justify-content-lg-between">
                            <div class="stats-count">
                             2<span>人</span>
                                <p>参与</p>
                               
                            </div><!-- .stats-count -->

                            <div class="stats-count">
                                	5<span>个</span>
                                <p>模块</p>
                            </div><!-- .stats-count -->

                            <div class="stats-count">
                            7<span>项</span>
                                <p>功能</p>
                                
                            </div><!-- .stats-count -->
 								
                            <div class="stats-count">
                               8<span>天</span>
                                <p>完成</p>
                            </div><!-- .stats-count -->
                        </div><!-- .stats-wrap -->
                    </div><!-- .ezuca-stats -->
                </div><!-- .col -->

                <div class="col-12 col-lg-6 flex align-content-center mt-5 mt-lg-0">
                    <div class="ezuca-video position-relative">
                        <div class="video-play-btn position-absolute">
                            <img src="images/video-icon.png" alt="Video Play">
                        </div><!-- .video-play-btn -->

                        <img src="images/合1.jpeg" alt="">
                    </div><!-- .ezuca-video -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </section><!-- .about-section -->


    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="team-heading">
                    <h2 class="entry-title">联系我们</h2>
                    <p></p>
                </div><!-- .team-heading -->
            </div><!-- .col -->

            

            <div class="col-12 col-md-6 col-lg-6">
                <div class="team-member">
                    <img src="images/我1.jpg" alt="">

                    <h3>高丽</h3>
                    <h4>1196033301@mail.nwpu.edu.cn</h4>

                    <ul class="p-0 m-0 d-flex justify-content-center align-items-center">
                        
                    </ul>
                </div><!-- .team-member -->
            </div><!-- .col -->

            <div class="col-12 col-md-6 col-lg-6">
                <div class="team-member">
                    <img src="images/陈1.jpg" alt="">

                    <h3>陈湘媚</h3>
                    <h4>cxm_irene@mail.nwpu.edu.cn</h4>

                    <ul class="p-0 m-0 d-flex justify-content-center align-items-center">
          
                    </ul>
                </div><!-- .team-member -->
            </div><!-- .col -->

        </div><!-- .row -->
    </div><!-- .container -->

    

    <footer class="site-footer">
        <div class="footer-widgets">
           
        </div><!-- .footer-bar -->
    </footer><!-- .site-footer -->

    <script type='text/javascript' src='js/jquery.js'></script>
    <script type='text/javascript' src='js/swiper.min.js'></script>
    <script type='text/javascript' src='js/masonry.pkgd.min.js'></script>
    <script type='text/javascript' src='js/jquery.collapsible.min.js'></script>
    <script type='text/javascript' src='js/custom.js'></script>

</body>
</html>