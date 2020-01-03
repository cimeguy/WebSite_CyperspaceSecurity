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
	<li><a href="./self-center/pixel-html/self-center.php">个人中心</a></li>
	<li><a href="sign-out.php">退出</a></li>
A;
}

?>


<?php 
//公告

$q1="select * from Board order by btime desc";
$result1=execute($link,$q1);
$count=0;//取三条
$b1ok=0;
$b2ok=0;
$b3ok=0;
if($data1=mysqli_fetch_assoc($result1)){
	//第一条  最新
	$board1=$data1;
	$b1ok=1;

}
if($data1=mysqli_fetch_assoc($result1)){
	//第二条  
	$board2=$data1;
	$b2ok=1;

}
if($data1=mysqli_fetch_assoc($result1)){
	//第三条  
	$board3=$data1;
	$b3ok=1;

}

?>

<?php 
//最新讨论

$qt="select * from Talk where reno=0 order by tno desc ";
$resultt=execute($link,$qt);
$t1ok=0;
$t2ok=0;
$t3ok=0;
if($talk1=mysqli_fetch_assoc($resultt)){
	//第一条  最新
	
	$t1=$talk1;
	$qs="select * from Student where sno={$t1['sno']}";
	$results=execute($link,$qs);
	if($sss=mysqli_fetch_assoc($results)){
		$s1=$sss;$t1ok=1;
		$t1['text']=substr($t1['text'],0,30);
		$htmltalk1=<<<ttt
	<div class="swiper-slide">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-6 order-2 order-lg-1 flex align-items-center mt-5 mt-lg-0">
                                <figure class="user-avatar">
                                    <img src="images/user-1.jpg" alt="">
                                </figure><!-- .user-avatar -->
                            </div><!-- .col -->
		
                            <div class="col-12 col-lg-6 order-1 order-lg-2 content-wrap h-100">
                                <div class="entry-content"><a href="./discuss/discuss_com.php">
                                    <p>
                                   	最新帖#{$t1['tno']}
                                    &nbsp; &nbsp;
                                    {$t1['text']}</p></a>
                                </div><!-- .entry-content -->
		
                                <div class="entry-footer">
                                    <h3 class="testimonial-user"> {$s1['name']} <span>&emsp;{$t1['ttime']}</span></h3>
                                </div><!-- .entry-footer -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .container -->
                </div><!-- .swiper-slide -->
ttt;
	}
	

}
if($talk1=mysqli_fetch_assoc($resultt)){
	//第二条  
	$t2=$talk1;
	$qs="select * from Student where sno={$t2['sno']}";
	$results=execute($link,$qs);
	if($sss=mysqli_fetch_assoc($results)){
		$s2=$sss;$t2ok=1;
		$t2['text']=substr($t2['text'],0,30);
		$htmltalk2=<<<ttt
	 <div class="swiper-slide">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-6 order-2 order-lg-1 flex align-items-center mt-5 mt-lg-0">
                                <figure class="user-avatar">
                                    <img src="images/user-2.jpg" alt="">
                                </figure><!-- .user-avatar -->
                            </div><!-- .col -->

                            <div class="col-12 col-lg-6 order-1 order-lg-2 content-wrap h-100">
                                <div class="entry-content"><a href="./discuss/discuss_com.php?talk_tno={$t2['tno']}">
                                    <p>
                                  	最新帖#{$t2['tno']}
                                    &nbsp; &nbsp;
                                    {$t2['text']}</p></a>
                                </div><!-- .entry-content -->

                                <div class="entry-footer">
                                    <h3 class="testimonial-user">{$s2['name']} <span>&emsp;{$t2['ttime']}</span></h3>
                                </div><!-- .entry-footer -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .container -->
                </div><!-- .swiper-slide -->	
ttt;
	}

}
if($talk1=mysqli_fetch_assoc($resultt)){
	//第三新 
	$t3=$talk1;
	$qs="select * from Student where sno={$t3['sno']}";
	$results=execute($link,$qs);
	if($sss=mysqli_fetch_assoc($results)){
		$s3=$sss;$t3ok=1;
        $t3['text']=substr($t3['text'],0,30);
        
		$htmltalk3=<<<aaa
			 <div class="swiper-slide">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-lg-6 flex order-2 order-lg-1 align-items-center mt-5 mt-lg-0">
                                <figure class="user-avatar">
                                    <img src="images/user-3.jpg" alt="">
                                </figure><!-- .user-avatar -->
                            </div><!-- .col -->

                            <div class="col-12 col-lg-6 order-1 order-lg-2 content-wrap h-100">
                                <div class="entry-content"><a href="./discuss/discuss_com.php?talk_tno={$t3['tno']}">
                                    <p>
                                  	 最新帖#{$t3['tno']}
                                    &nbsp; &nbsp;
                                    {$t3['text']}</p></a>
                                </div><!-- .entry-content -->

                                <div class="entry-footer">
                                    <h3 class="testimonial-user">{$s3['name']} <span>&emsp;{$t3['ttime']}</span></h3>
                                </div><!-- .entry-footer -->
                            </div><!-- .col -->
                        </div><!-- .row -->
                    </div><!-- .container -->
                </div><!-- .swiper-slide -->
           
aaa;
		
		
	}

}

?>
<!DOCTYPE html>
<html lang="zh-CN">
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
                                <form id="myform" class="flex align-items-stretch">
                                    <input type="search" name="searchText" placeholder="搜索">
                               		
                                    <button type="submit" value="" class="flex justify-content-center align-items-center" onclick="window.location.href = 'search.php'"><i class="fa fa-search"></i></button>
                                	
                                </form>
                            </div><!-- .header-bar-search -->

                            <div class="header-bar-menu">
                                <ul class="flex justify-content-center align-items-center py-2 pt-md-0">
                                <?php echo $html?> 
                                <!-- todo -->
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
                                   
									<li class="current-menu-item" style="font-size:20px"><a href="index.php">首页</a></li>
                                    <li style="font-size:20px"><a href="introduce.php">介绍</a></li>
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
                                <a href="course_info.php">了解更多</a>
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
                        <a href="course_info.php">进入<i class="fa fa-long-arrow-right"></i></a>
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
                        <a href="./discuss/discuss.php">进入<i class="fa fa-long-arrow-right"></i></a>
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
                        <a href="./self-center/pixel-html/homework.php">进入<i class="fa fa-long-arrow-right"></i></a>
                    </footer><!-- .entry-footer -->
                </div><!-- .icon-box -->

                <div class="icon-box">
                    <div class="icon">
                        <span class="ti-world"></span>
                    </div><!-- .icon -->

                    <header class="entry-header">
                        <h2 class="entry-title">资源分享</h2>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p>在这里学生和老师可以互相分享课程资源……</p>
                    </div><!-- .entry-content -->

                    <footer class="entry-footer read-more">
                        <a href="file.php">进入<i class="fa fa-long-arrow-right"></i></a>
                    </footer><!-- .entry-footer -->
                </div><!-- .icon-box -->
            </div><!-- .row -->
        </div><!-- .container-fluid -->
    </div><!-- .icon-boxes -->

  
    <section class="testimonial-section">
        <!-- Swiper -->
        <div class="swiper-container testimonial-slider">
         <h5>&emsp;&emsp;&emsp;最新讨论帖（点击内容查看详情）</h5><br/><br/><br/>
            <div class="swiper-wrapper">
              
                <?php 
                
                if($t3ok==1){
                	echo $htmltalk3;
                
                }
                if($t1ok==1){
                	echo $htmltalk1;
                
                }
                
                if($t2ok==1){
                	echo $htmltalk2;
                
                }
                
               
                

                ?>
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
				<?php 
				if($b1ok==1){

					$timestrap=strtotime($board1['btime']);//格式化，取出日期
					$da=date('d',$timestrap);
					$mo=date('m',$timestrap);
					$hb1=<<<bbb
					<div class="col-12 col-lg-6">
                    <div class="featured-event-content">
                        <figure class="event-thumbnail position-relative m-0">
                            <a href="#"><img src="images/event-1.jpg" alt=""></a>

                            <div class="posted-date position-absolute">
                                <div class="day">{$da}</div>
                                <div class="month">{$mo}月</div>
                            </div><!-- .posted-date -->
                        </figure><!-- .event-thumbnail -->

                        <header class="entry-header flex flex-wrap align-items-center">
                            <h2 class="entry-title"><a href="#">{$board1['brief']}</a></h2>

                            <div class="event-location"><i class="fa fa-map-marker"></i>西北工业大学</div>

                            <div class="event-duration"><i class="fa fa-calendar"></i>{$board1['btime']}</div>
                        </header><!-- .entry-header -->
                    </div><!-- .featured-event-content -->
                </div><!-- .col -->
					
bbb;
					

				echo $hb1;
				}
				?>
				<div class="col-12 col-lg-6 mt-5 mt-lg-0">
				<?php 
				if($b2ok==1){
				$hb2=<<<bbb
					<div class="event-content flex flex-wrap justify-content-between align-content-stretch">
                        <figure class="event-thumbnail">
                            <a href="#"><img src="images/event-2.jpg" alt=""></a>
                        </figure><!-- .course-thumbnail -->

                        <div class="event-content-wrap">
                            <header class="entry-header">
                                <div class="posted-date">
                                    <i class="fa fa-calendar"></i> {$board2['btime']}
                                </div><!-- .posted-date -->

                                <h2 class="entry-title"><a href="#">{$board2['brief']}</a></h2>

                                <div class="entry-meta flex flex-wrap align-items-center">
                                    <div class="post-author"><a href="#">{$board2['bteacher']}</a></div>

                                    <div class="post-comments">老师 </div>
                                </div><!-- .entry-meta -->
                            </header><!-- .entry-header -->

                            <div class="entry-content">
                                <p>{$board2['text']}</p>
                            </div><!-- .entry-content -->
                        </div><!-- .event-content-wrap -->
                    </div><!-- .event-content -->
			
bbb;
				echo $hb2;
				}
				?>
                
                <?php 
                
                if($b3ok==1){
                	$hb3=<<<bbb
					<div class="event-content flex flex-wrap justify-content-between align-content-lg-stretch">
                        <figure class="event-thumbnail">
                            <a href="#"><img src="images/event-3.jpg" alt=""></a>
                        </figure><!-- .course-thumbnail -->

                        <div class="event-content-wrap">
                            <header class="entry-header">
                                <div class="posted-date">
                                    <i class="fa fa-calendar"></i> {$board3['btime']}
                                </div><!-- .posted-date -->

                                <h2 class="entry-title"><a href="#">{$board3['brief']}</a></h2>

                                <div class="entry-meta flex flex-wrap align-items-center">
                                    <div class="post-author"><a href="#">{$board3['bteacher']}</a></div>

                                    <div class="post-comments">老师  </div>
                                </div><!-- .entry-meta -->
                            </header><!-- .entry-header -->

                            <div class="entry-content">
                                <p>{$board3['text']}</p>
                            </div><!-- .entry-content -->
                        </div><!-- .event-content-wrap -->
                    </div><!-- .event-content -->
bbb;
echo $hb3;
                	}
                if($b1ok==0&&$b2ok==0&&$b3ok==0){
					echo "暂无公告";

				}
                ?>
                
                

                
                    

                    
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .container -->
    </section><!-- .latest-news-events -->

  

    
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