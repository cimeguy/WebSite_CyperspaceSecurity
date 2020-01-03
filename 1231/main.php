<?php
include_once (dirname(__FILE__)."/./inc/config.inc.php");
include_once './inc/mysql.inc.php';
include_once './inc/tool.inc.php';
$link = connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>网络安全课程学习系统</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.css">

    <!-- ElegantFonts CSS -->
    <link rel="stylesheet" href="css/elegant-fonts.css">

    <!-- themify-icons CSS -->
    <link rel="stylesheet" href="css/themify-icons.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="css/swiper.css">

    <!-- Styles -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="hero-content">
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
                                    $student_id = is_login($link);
                                    $student_id = '2017302230';
                                    if($student_id){
$str=<<<A
                                        <li><a href="./self-center/pixel-html/self-center.html">个人中心</a></li>
                                        <li><a href="../main.html">退出</a></li>
A;
                                        echo $str;
                                    }
                                    else{
$str=<<<A
                                        <li><a href="./self-center/pixel-html/self-center.html">登录</a></li>
                                        <li><a href="../main.html">注册</a></li>
A;
                                        echo $str;
                                    }
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
                                <h1 class="site-title"  style="font-size:40px"><a href="main.html" rel="home">网络安全<span>课程</span></a></h1>
                            </div><!-- .site-branding -->
                        </div><!-- .col -->

                        <div class="col-3 col-lg-9 flex justify-content-end align-content-center">
                            <nav class="site-navigation flex justify-content-end align-items-center">
                                <ul class="flex flex-column flex-lg-row justify-content-lg-end align-content-center">
                                    <li class="current-menu-item" style="font-size:20px"><a href="main.html">首页</a></li>
                                    <li style="font-size:20px"><a href="about.html">介绍</a></li>
                                    <li style="font-size:20px"><a href="#">课程</a></li>
                                    <li style="font-size:20px"><a href="discuss.html">讨论</a></li>
                                    <li style="font-size:20px"><a href="#">下载</a></li>
                                </ul>

                                <div class="hamburger-menu d-lg-none">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div><!-- .hamburger-menu -->

                                <div class="header-bar-cart">
                                    <a href="http://www.baidu.com" class="flex justify-content-center align-items-center"><span aria-hidden="true" class="icon_bag_alt"></span></a>
                                    
                                </div><!-- .header-bar-search -->
                            </nav><!-- .site-navigation -->
                        </div><!-- .col -->
                    </div><!-- .row -->
                </div><!-- .container -->
            </div><!-- .nav-bar -->
        </header><!-- .site-header -->

        <div class="hero-content-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="hero-content-wrap flex flex-column justify-content-center align-items-start">
                            <header class="entry-header">
                                <h4>开始你的在线学习</h4>
                                <h1>网络安全课程<br/>学习系统</h1>
                            </header><!-- .entry-header -->

                            <div class="entry-content">
                                <p>该网站由西北工业大学陈旿老师的学生搭建……</p>
                            </div><!-- .entry-content -->

                            <footer class="entry-footer read-more">
                                <a href="about.html">了解更多</a>
                            </footer><!-- .entry-footer -->
                        </div><!-- .hero-content-wrap -->
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .hero-content-hero-content-overlay -->
    </div><!-- .hero-content -->

    <div class="icon-boxes">
        <div class="container-fluid">
            <div class="flex flex-wrap align-items-stretch">
                <div class="icon-box">
                    <div class="icon">
                        <span class="ti-folder"></span>
                    </div><!-- .icon -->

                    <header class="entry-header">
                        <h2 class="entry-title">课程详情</h2>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p>关于网络安全课程的相关内容……</p>
                    </div><!-- .entry-content -->

                    <footer class="entry-footer read-more">
                        <a href="#">进入<i class="fa fa-long-arrow-right"></i></a>
                    </footer><!-- .entry-footer -->
                </div><!-- .icon-box -->

                <div class="icon-box">
                    <div class="icon">
                        <span class="ti-user"></span>
                    </div><!-- .icon -->

                    <header class="entry-header">
                        <h2 class="entry-title">在线讨论</h2>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p>欢迎大家在此进行思想的汇聚……</p>
                    </div><!-- .entry-content -->

                    <footer class="entry-footer read-more">
                        <a href="discuss.html">进入<i class="fa fa-long-arrow-right"></i></a>
                    </footer><!-- .entry-footer -->
                </div><!-- .icon-box -->

                <div class="icon-box">
                    <div class="icon">
                        <span class="ti-book"></span>
                    </div><!-- .icon -->

                    <header class="entry-header">
                        <h2 class="entry-title">提交作业</h2>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p>在这里提交作业、考试……</p>
                    </div><!-- .entry-content -->

                    <footer class="entry-footer read-more">
                        <a href="#">进入<i class="fa fa-long-arrow-right"></i></a>
                    </footer><!-- .entry-footer -->
                </div><!-- .icon-box -->

                <div class="icon-box">
                    <div class="icon">
                        <span class="ti-world"></span>
                    </div><!-- .icon -->

                    <header class="entry-header">
                        <h2 class="entry-title">更多功能</h2>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p>敬请期待……</p>
                    </div><!-- .entry-content -->

                    <footer class="entry-footer read-more">
                        <a href="#">进入<i class="fa fa-long-arrow-right"></i></a>
                    </footer><!-- .entry-footer -->
                </div><!-- .icon-box -->
            </div><!-- .row -->
        </div><!-- .container-fluid -->
    </div><!-- .icon-boxes -->

  
    <section class="testimonial-section">
        <!-- Swiper -->
        <div class="swiper-container testimonial-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-6 order-2 order-lg-1 flex align-items-center mt-5 mt-lg-0">
                                <figure class="user-avatar">
                                    <img src="images/user-1.jpg" alt="">
                                </figure><!-- .user-avatar -->
                            </div><!-- .col -->

                            <div class="col-12 col-lg-6 order-1 order-lg-2 content-wrap h-100">
                                <div class="entry-content">
                                    <p>Together as teachers, students and universities we can help make this education available for everyone.</p>
                                </div><!-- .entry-content -->

                                <div class="entry-footer">
                                    <h3 class="testimonial-user">Russell Stephens - <span>University in UK</span></h3>
                                </div><!-- .entry-footer -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .container -->
                </div><!-- .swiper-slide -->
                

                <div class="swiper-slide">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-6 order-2 order-lg-1 flex align-items-center mt-5 mt-lg-0">
                                <figure class="user-avatar">
                                    <img src="images/user-2.jpg" alt="">
                                </figure><!-- .user-avatar -->
                            </div><!-- .col -->

                            <div class="col-12 col-lg-6 order-1 order-lg-2 content-wrap h-100">
                                <div class="entry-content">
                                    <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div><!-- .entry-content -->

                                <div class="entry-footer">
                                    <h3 class="testimonial-user">Robert Stephens - <span>University in Oxford</span></h3>
                                </div><!-- .entry-footer -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .container -->
                </div><!-- .swiper-slide -->

                <div class="swiper-slide">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-6 flex order-2 order-lg-1 align-items-center mt-5 mt-lg-0">
                                <figure class="user-avatar">
                                    <img src="images/user-3.jpg" alt="">
                                </figure><!-- .user-avatar -->
                            </div><!-- .col -->

                            <div class="col-12 col-lg-6 order-1 order-lg-2 content-wrap h-100">
                                <div class="entry-content">
                                    <p>Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
                                </div><!-- .entry-content -->

                                <div class="entry-footer">
                                    <h3 class="testimonial-user">James Stephens - <span>University in Cambridge</span></h3>
                                </div><!-- .entry-footer -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .container -->
                </div><!-- .swiper-slide -->
            </div><!-- .swiper-wrapper -->

            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-6 mt-5 mt-lg-0">
                        <div class="swiper-pagination position-relative flex justify-content-center align-items-center"></div>
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .testimonial-slider -->
    </section><!-- .testimonial-section -->
    <div class="tlinks">Collect from <a href="http://www.cssmoban.com/"  title="网站模板">网站模板</a></div>

    <section class="featured-courses vertical-column courses-wrap">
        <div class="container">
            <div class="row mx-m-25">
                <div class="col-12 px-25">
                    <header class="heading flex flex-wrap justify-content-between align-items-center">
                        <h2 class="entry-title">Featured Courses</h2>

                        <nav class="courses-menu mt-3 mt-lg-0">
                            <ul class="flex flex-wrap justify-content-md-end align-items-center">
                                <li class="active"><a href="#">All</a></li>
                                <li><a href="#">Business</a></li>
                                <li><a href="#">Design</a></li>
                                <li><a href="#">Web Development</a></li>
                                <li><a href="#">Photography</a></li>
                            </ul>
                        </nav><!-- .courses-menu -->
                    </header><!-- .heading -->
                </div><!-- .col -->

                <div class="col-12 col-md-6 col-lg-4 px-25">
                    <div class="course-content">
                        <figure class="course-thumbnail">
                            <a href="#"><img src="images/1.jpg" alt=""></a>
                        </figure><!-- .course-thumbnail -->

                        <div class="course-content-wrap">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="#">The Complete Android Developer Course</a></h2>

                                <div class="entry-meta flex align-items-center">
                                    <div class="course-author"><a href="#">Ms. Lara Croft </a></div>

                                    <div class="course-date">July 21, 2018</div>
                                </div><!-- .course-date -->
                            </header><!-- .entry-header -->

                            <footer class="entry-footer flex justify-content-between align-items-center">
                                <div class="course-cost">
                                    $45 <span class="price-drop">$68</span>
                                </div><!-- .course-cost -->

                                <div class="course-ratings flex justify-content-end align-items-center">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star-o"></span>

                                    <span class="course-ratings-count">(4 votes)</span>
                                </div><!-- .course-ratings -->
                            </footer><!-- .entry-footer -->
                        </div><!-- .course-content-wrap -->
                    </div><!-- .course-content -->
                </div><!-- .col -->

                <div class="col-12 col-md-6 col-lg-4 px-25">
                    <div class="course-content">
                        <figure class="course-thumbnail">
                            <a href="#"><img src="images/2.jpg" alt=""></a>
                        </figure><!-- .course-thumbnail -->

                        <div class="course-content-wrap">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="#">The Ultimate Drawing Course Beginner to Advanced</a></h2>

                                <div class="entry-meta flex align-items-center">
                                    <div class="course-author"><a href="#">Michelle Golden</a></div>

                                    <div class="course-date">Mar 14, 2018</div>
                                </div><!-- .course-date -->
                            </header><!-- .entry-header -->

                            <footer class="entry-footer flex justify-content-between align-items-center">
                                <div class="course-cost">
                                    <span class="free-cost">Free</span>
                                </div><!-- .price-drop -->

                                <div class="course-ratings flex justify-content-end align-items-center">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star-o"></span>

                                    <span class="course-ratings-count">(4 votes)</span>
                                </div><!-- .course-ratings -->
                            </footer><!-- .entry-footer -->
                        </div><!-- .course-content-wrap -->
                    </div><!-- .course-content -->
                </div><!-- .col -->

                <div class="col-12 col-md-6 col-lg-4 px-25">
                    <div class="course-content">
                        <figure class="course-thumbnail">
                            <a href="#"><img src="images/3.jpg" alt=""></a>
                        </figure><!-- .course-thumbnail -->

                        <div class="course-content-wrap">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="#">The Complete Digital Marketing Course</a></h2>

                                <div class="entry-meta flex align-items-center">
                                    <div class="course-author"><a href="#">Ms. Lucius</a></div>

                                    <div class="course-date">Dec 18, 2018</div>
                                </div><!-- .course-date -->
                            </header><!-- .entry-header -->

                            <footer class="entry-footer flex justify-content-between align-items-center">
                                <div class="course-cost">
                                    $55 <span class="price-drop">$78</span>
                                </div><!-- .course-cost -->

                                <div class="course-ratings flex justify-content-end align-items-center">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star-o"></span>

                                    <span class="course-ratings-count">(4 votes)</span>
                                </div><!-- .course-ratings -->
                            </footer><!-- .entry-footer -->
                        </div><!-- .course-content-wrap -->
                    </div><!-- .course-content -->
                </div><!-- .col -->

                <div class="col-12 col-md-6 col-lg-4 px-25">
                    <div class="course-content">
                        <figure class="course-thumbnail">
                            <a href="#"><img src="images/4.jpg" alt=""></a>
                        </figure><!-- .course-thumbnail -->

                        <div class="course-content-wrap">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="#">The Unreal Engine Developer Course</a></h2>

                                <div class="entry-meta flex align-items-center">
                                    <div class="course-author"><a href="#">Mr. John Wick</a></div>

                                    <div class="course-date">Otc 17, 2018</div>
                                </div><!-- .course-date -->
                            </header><!-- .entry-header -->

                            <footer class="entry-footer flex justify-content-between align-items-center">
                                <div class="course-cost">
                                    <span class="free-cost">Free</span>
                                </div><!-- .course-cost -->

                                <div class="course-ratings flex justify-content-end align-items-center">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star-o"></span>

                                    <span class="course-ratings-count">(4 votes)</span>
                                </div><!-- .course-ratings -->
                            </footer><!-- .entry-footer -->
                        </div><!-- .course-content-wrap -->
                    </div><!-- .course-content -->
                </div><!-- .col -->

                <div class="col-12 col-md-6 col-lg-4 px-25">
                    <div class="course-content">
                        <figure class="course-thumbnail">
                            <a href="#"><img src="images/5.jpg" alt=""></a>
                        </figure><!-- .course-thumbnail -->

                        <div class="course-content-wrap">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="#">Progressive Web Apps (PWA) - The Complete Guide</a></h2>

                                <div class="entry-meta flex align-items-center">
                                    <div class="course-author"><a href="#">Mr. Tom Redder</a></div>

                                    <div class="course-date">Sep 14, 2018</div>
                                </div><!-- .course-date -->
                            </header><!-- .entry-header -->

                            <footer class="entry-footer flex justify-content-between align-items-center">
                                <div class="course-cost">
                                    $38 <span class="price-drop">$48</span>
                                </div><!-- .course-cost -->

                                <div class="course-ratings flex justify-content-end align-items-center">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star-o"></span>

                                    <span class="course-ratings-count">(4 votes)</span>
                                </div><!-- .course-ratings -->
                            </footer><!-- .entry-footer -->
                        </div><!-- .course-content-wrap -->
                    </div><!-- .course-content -->
                </div><!-- .col -->

                <div class="col-12 col-md-6 col-lg-4 px-25">
                    <div class="course-content">
                        <figure class="course-thumbnail">
                            <a href="#"><img src="images/6.jpg" alt=""></a>
                        </figure><!-- .course-thumbnail -->

                        <div class="course-content-wrap">
                            <header class="entry-header">
                                <h2 class="entry-title"><a href="#">Cryptocurrency Investment Course 2018</a></h2>

                                <div class="entry-meta flex align-items-center">
                                    <div class="course-author"><a href="#">Russell Stephens</a></div>

                                    <div class="course-date">Nov 06, 2018</div>
                                </div><!-- .course-date -->
                            </header><!-- .entry-header -->

                            <footer class="entry-footer flex justify-content-between align-items-center">
                                <div class="course-cost">
                                    <span class="free-cost">Free</span>
                                </div><!-- .course-cost -->

                                <div class="course-ratings flex justify-content-end align-items-center">
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star checked"></span>
                                    <span class="fa fa-star-o"></span>

                                    <span class="course-ratings-count">(4 votes)</span>
                                </div><!-- .course-ratings -->
                            </footer><!-- .entry-footer -->
                        </div><!-- .course-content-wrap -->
                    </div><!-- .course-content -->
                </div><!-- .col -->

                <div class="col-12 px-25 flex justify-content-center">
                    <a class="btn" href="#">view all courses</a>
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </section><!-- .courses-wrap -->

    <section class="latest-news-events">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <header class="heading flex justify-content-between align-items-center">
                        <h2 class="entry-title">最新消息 & 公告板</h2>
                    </header><!-- .heading -->
                </div><!-- .col -->

                <div class="col-12 col-lg-6">
                    <div class="featured-event-content">
                        <figure class="event-thumbnail position-relative m-0">
                            <a href="#"><img src="images/event-1.jpg" alt=""></a>

                            <div class="posted-date position-absolute">
                                <div class="day">23</div>
                                <div class="month">mar</div>
                            </div><!-- .posted-date -->
                        </figure><!-- .event-thumbnail -->

                        <header class="entry-header flex flex-wrap align-items-center">
                            <h2 class="entry-title"><a href="#">The Complete Financial Analyst Training & Investing Course</a></h2>

                            <div class="event-location"><i class="fa fa-map-marker"></i>40 Baria Sreet 133/2 NewYork City, US</div>

                            <div class="event-duration"><i class="fa fa-calendar"></i>10 Dec - 12 dec</div>
                        </header><!-- .entry-header -->
                    </div><!-- .featured-event-content -->
                </div><!-- .col -->

                <div class="col-12 col-lg-6 mt-5 mt-lg-0">
                    <div class="event-content flex flex-wrap justify-content-between align-content-stretch">
                        <figure class="event-thumbnail">
                            <a href="#"><img src="images/event-2.jpg" alt=""></a>
                        </figure><!-- .course-thumbnail -->

                        <div class="event-content-wrap">
                            <header class="entry-header">
                                <div class="posted-date">
                                    <i class="fa fa-calendar"></i> 22 Mar 2018
                                </div><!-- .posted-date -->

                                <h2 class="entry-title"><a href="#">Personalized online learning experience</a></h2>

                                <div class="entry-meta flex flex-wrap align-items-center">
                                    <div class="post-author"><a href="#">Ms. Lara Croft </a></div>

                                    <div class="post-comments">02 Comments  </div>
                                </div><!-- .entry-meta -->
                            </header><!-- .entry-header -->

                            <div class="entry-content">
                                <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.</p>
                            </div><!-- .entry-content -->
                        </div><!-- .event-content-wrap -->
                    </div><!-- .event-content -->

                    <div class="event-content flex flex-wrap justify-content-between align-content-lg-stretch">
                        <figure class="event-thumbnail">
                            <a href="#"><img src="images/event-3.jpg" alt=""></a>
                        </figure><!-- .course-thumbnail -->

                        <div class="event-content-wrap">
                            <header class="entry-header">
                                <div class="posted-date">
                                    <i class="fa fa-calendar"></i> 22 Mar 2018
                                </div><!-- .posted-date -->

                                <h2 class="entry-title"><a href="#">Which investment project should my company choose?</a></h2>

                                <div class="entry-meta flex flex-wrap align-items-center">
                                    <div class="post-author"><a href="#">Ms. Lara Croft </a></div>

                                    <div class="post-comments">02 Comments  </div>
                                </div><!-- .entry-meta -->
                            </header><!-- .entry-header -->

                            <div class="entry-content">
                                <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt.</p>
                            </div><!-- .entry-content -->
                        </div><!-- .event-content-wrap -->
                    </div><!-- .event-content -->
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </section><!-- .latest-news-events -->

    <section class="home-gallery">
        <div class="gallery-wrap flex flex-wrap">
            <div class="gallery-grid gallery-grid1x1">
                <a href="#"><img src="images/a.jpg" alt=""></a>
            </div><!-- .gallery-grid -->

            <div class="gallery-grid gallery-grid1x1">
                <a href="#"><img src="images/b.jpg" alt=""></a>
            </div><!-- .gallery-grid -->

            <div class="gallery-grid gallery-grid2x2">
                <a href="#"><img src="images/c.jpg" alt=""></a>
            </div><!-- .gallery-grid -->

            <div class="gallery-grid gallery-grid1x1">
                <a href="#"><img src="images/d.jpg" alt=""></a>
            </div><!-- .gallery-grid -->

            <div class="gallery-grid gallery-grid1x1">
                <a href="#"><img src="images/e.jpg" alt=""></a>
            </div><!-- .gallery-grid -->

            
            </div><!-- .gallery-grid -->
        </div><!-- .gallery-wrap -->
    </section><!-- .home-gallery -->

    
    <footer class="site-footer">
        <div class="footer-widgets">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="foot-about">
                            

                            
                     

                        </div><!-- .foot-about -->
                    </div><!-- .col -->

                   
                   
                   
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .footer-widgets -->

        <div class="footer-bar">
            <div class="container">
                
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .footer-bar -->
    </footer><!-- .site-footer -->

<script type='text/javascript' src='js/jquery.js'></script>
<script type='text/javascript' src='js/swiper.min.js'></script>
<script type='text/javascript' src='js/masonry.pkgd.min.js'></script>
<script type='text/javascript' src='js/jquery.collapsible.min.js'></script>
<script type='text/javascript' src='js/custom.js'></script>

</body>
</html>
