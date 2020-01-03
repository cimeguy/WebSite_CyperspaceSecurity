<?php 
include_once './inc/config.inc.php';
include_once './inc/mysql.inc.php';
include_once './inc/tool.inc.php';
include_once 'head.php';
$link=connect();


$member_id=is_login($link);//是否登录
$isteacher=isteacher($link);//是不是老师

$htmlupload="";//上传显示
//┼
$htmldelete="";
$sname=0;
$tname=0;
if(!$member_id){//未登录  /不能上传
	$html=<<<A
		<li><a href="sign-up.php">注册</a></li>
		<li><a href="sign-in.php">登录</a></li>
A;

}else if($isteacher){
	
	
	
	
	
	$html=<<<A
	<li><a href="teacher-center/pixel-html/tea_self-center.php">老师后台管理系统</a></li>
	<li><a href="sign-out.php">退出</a></li>
A;
	
//可以上传
//上传
	$squery="select * from Teacher where teano={$member_id}";
	$sresult=execute($link, $squery);
	  while ($sdata=mysqli_fetch_assoc($sresult)){
	  	$tname=$sdata['name'];
	  }
	  $htmlupload=<<<load
	  
	  <center>
                     <div class="col-12 col-lg-10">
                		<div class="contact-form">
	  
                     	<form action="course_info.php?tname={$tname}" method="post" enctype="multipart/form-data" >
	                  		<h4>&emsp;&emsp;</h4>
	  
							&emsp;<div class="jia">浏览</div>
							<input class="name" type="file" name="myfile" />
	  
							<input type="text" name="sfname" placeholder="老师请上传课程视频并输入名称（必填），仅支持MP4 最大200M" autocomplete="off"  >
                     		<br/><br/>	<label>选择章节
								<select style="width:289px;height:25px;" name="vzhang">
									<option value="第一章">第一章</option>
									<option value="第二章">第二章</option>
									<option value="第三章">第三章</option>
									<option value="第四章">第四章</option>
                     				<option value="第五章">第五章</option>
                     				<option value="第六章">第六章</option>
								</select>
							</label><br/>
							<input type="submit" name="submit" value="开始上传"/>
                    	</form>
	  
                </div><!-- .contact-form -->
            </div><!-- .col -->
	  </center>
load;
	
}
else{//学生 不能上传
	$html=<<<A
	<li><a href="self-center.php">个人中心</a></li>
	<li><a href="sign-out.php">退出</a></li>
A;
	
	
}


?>
<?php
//上传

//header('Content-type:text/html;charset=utf-8');
//var_dump($_FILES);//一开始保存在tmp临时文件夹中
$allowed = array("mp4");//支持的格式
if(isset($_POST['submit'])){//判断变量存在
	$arr=pathinfo($_FILES['myfile']['name']);//获得扩展名 （数组） $arr['extension']
	//&&$_FILES["myfile"]["type"] == "application/pdf"   "text/plain"  application/octet-stream  application/x-zip-compressed  "aplication/zip"  "application/msword"
	if(is_uploaded_file($_FILES['myfile']['tmp_name'])&&in_array($arr['extension'], $allowed))
		{//如果是httppost上传
		//移动
		$newname=date('YmdG').rand(10,99);//随机生成的名字
		if($_GET['tname']!==NULL){//老师传文件

			if($_POST['sfname']){
				move_uploaded_file($_FILES['myfile']['tmp_name'], 'videos/'.$newname.'.'.$arr['extension']);
				$newaddr='videos/'.$newname.'.'.$arr['extension'];
				$q1="insert into Video(vname,vlink,vteacher,vzhang,vtime) values('{$_POST['sfname']}','{$newaddr}','{$_GET['tname']}',  '{$_POST['vzhang']}' ,now())";//按fno分组取出每组最大的
				$result1=execute($link,$q1);
				if(mysqli_affected_rows($link)==1){
					skip_message('course_info.php', '上传成功！');
				}else{
					skip_message('course_info.php', '上传失败1！');
				}

			}
			
			else{
				skip_message('course_info.php', '您必须输入该视频名称！');
			
			}
			


		}
		else{
			skip_message('course_info.php', '上传失败2！');
		}
	}
	else{
		skip_message('course_info.php', "可能有攻击,请你做合法的事！且仅接受MP4文件！");
		}
	
}
?>
<?php 

if($isteacher){
	$qt="select * from Teacher where teano={$member_id}";//如果是自己发的可以视频
	$rt=execute($link,$qt);
	$tname="";
	if(($dt=mysqli_fetch_assoc($rt))){//查找自己的名字
		$tname=$dt['name'];
	}
	if(isset($_GET['isdelete'])){//如果删除

		if($_GET['tname']==$tname){//如果是自己
			$qv="select * from Video where vno={$_GET['vno']}";
			$rv=execute($link,$qv);
			$vlink="";
			if($dv=mysqli_fetch_assoc($rv)){
				$vlink=$dv['vlink'];

			}
			
			$qd="DELETE from Video where vno={$_GET['vno']}";//如果是自己发的可以视频
			$rd=execute($link,$qd);
			if(mysqli_affected_rows($link)==1){

				
				if (file_exists($vlink)) {
					unlink($vlink);
				} else {
					// File not found.
				}
            	skip_message('course_info.php', '删除成功！');
	        }
	        else{
	            skip_message('course_info.php', '删除失败！');
	        }
		}
		else{
			
			skip_message('course_info.php', '删除失败！不是你本人发布的视频！');

		}
	}
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hello World</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- 上传 -->
   
<style>
body{
	
}
.form{
	position:absolute;
	width:290px;
	height:50px;
	top:75%;left:80%;
	-webkit-transform:translate(-50%,-50%);
	transform:translate(-50%,-50%);
	background-color:#SSS;
}
.jia{
	position:absolute;
	width:100px;height:50px;line-height:51px;
	top:0;left:2%;color:#999;background-color:#f1faf6;
	outline:none;font-size:18px;text-align:center;
	border-radius:5px 0 0 5px;
	box-shadow:0 0 1px #ccc;
}
.name{
	position:absolute;
	width:100px;height:50px;top:0;left:0;
	outline:medium none;
	filter:alpha(opacity=0);-moz-opacity:0;opacity:0;
}
.submit{
	position:absolute;
	width:240px;height:50px;line-height:50px;
	top:0;left:50px;outline:none;
	border:0;color:#999;font-size:15px;
	background-color:#fff;border-radius:0 5px 5px 0;
	box-shadow:0 0  1px #ccc;
}
</style>
    
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
<body class="single-courses-page">
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
                                    <?php echo $html;?>
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
                                <h1 class="site-title" style="font-size:40px"><a href="index.html" rel="home">网络安全<span>课程</span></a></h1>
                            </div><!-- .site-branding -->
                        </div><!-- .col -->

                        <div class="col-3 col-lg-9 flex justify-content-end align-content-center">
                            <nav class="site-navigation flex justify-content-end align-items-center">
                                <ul class="flex flex-column flex-lg-row justify-content-lg-end align-content-center">
									<li style="font-size:20px"><a href="index.php">首页</a></li>
                                    <li style="font-size:20px"><a href="introduce.php">介绍</a></li>
                                    <li class="current-menu-item" style="font-size:20px"><a href="course_info.php">课程</a></li>
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

        <div class="page-header-overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <header class="entry-header">
                            <h1 class="entry-title">网络安全课程详情</h1>

                            <div class="ratings flex justify-content-center align-items-center">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                 <i class="fa fa-star"></i>
<!--                                 <i class="fa fa-star-o"></i> -->
                                <span><?php 
                                $q1="select count(*) from Student ";
                               	$numstudents=num($link,$q1);
                               	echo $numstudents;echo"个学生";
                                
                                ?>
                                
                                
                                
                              </span>
                            </div><!-- .ratings -->
                        </header><!-- .entry-header -->
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .container -->
        </div><!-- .page-header-overlay -->
    </div><!-- .page-header -->
<?php 
        
        	echo $htmlupload;
        
        ?>
    <div class="container">
        

        <div class="row">
            <div class="col-12 offset-lg-1 col-lg-1">
                <div class="post-share">
<!--                     <h3>share</h3> -->

<!--                     <ul class="flex flex-wrap align-items-center p-0 m-0"> -->
<!--                         <li><a href="#"><i class="fa fa-facebook"></i></a></li> -->
<!--                         <li><a href="#"><i class="fa fa-twitter"></i></a></li> -->
<!--                         <li><a href="#"><i class="fa fa-google-plus"></i></a></li> -->
<!--                         <li><a href="#"><i class="fa fa-instagram"></i></a></li> -->
<!--                         <li><a href="#"><i class="fa fa-thumb-tack"></i></a></li> -->
<!--                     </ul> -->
                </div><!-- .post-share -->
            </div><!-- .col -->

            <div class="col-12 col-lg-8">
                <div class="single-course-wrap">
                    <div class="course-info flex flex-wrap align-items-center">
                        <div class="course-author flex flex-wrap align-items-center mt-3">
<!--                             <img src="images/course-author.jpg" alt=""> -->

                            <div class="author-wrap">
                                <label class="m-0">老师</label>
                                <div class="author-name"><a href="#"><?php 
                                $q1="select count(*) from Teacher ";
                               	$numstudents=num($link,$q1);
                               	echo $numstudents;echo"个";
                                
                                ?>
                                </a></div>
                            </div><!-- .author-wrap -->
                        </div><!-- .course-author -->

                        <div class="course-cats mt-3">
                            <label class="m-0">课程</label>
                            <div class="author-name"><a href="#">网络安全</a></div>
                        </div><!-- .course-cats -->

                        <div class="course-students mt-3">
                            <label class="m-0">学生</label>
                            <div class="author-name"><a href="#"><?php 
                                $q1="select count(*) from Student ";
                               	$numstudents=num($link,$q1);
                               	echo $numstudents;echo"个";
                                
                                ?>
                                </a></div>
                        </div><!-- .course-students -->

<!--                         <div class="buy-course mt-3"> -->
<!--                             <a class="btn" href="#">ADD to cart</a> -->
                        <!-- </div>.buy-course -->
                    </div><!-- .course-info -->

                    
					<!--  -->
                    <div class="single-course-accordion-cont mt-3">
                        <header class="entry-header flex flex-wrap justify-content-between align-items-center">
                            <h2>点击观看视频</h2>

                            <div class="number-of-lectures">共六章</div>

<!--                             <div class="total-lectures-time">42:57:42</div> -->
                        </header><!-- .entry-header -->
						
						
						
						
						
                        <div class="entry-contents">
                            <div class="accordion-wrap type-accordion">
                            <?php 
                                    //一    
                            $z1='第一章'; 
						$q1="select count(*) from Video where vzhang='第一章'";
						$num1=num($link, $q1);
						
						
						$h1=<<<hhh
							<h3 class="entry-title flex flex-wrap justify-content-between align-items-lg-center active">
                                    <span class="arrow-r"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></span>
                                    <span class="lecture-group-title">第一章</span>
                                    <span class="number-of-lectures">{$num1}个视频</span><!-- 视频数量 -->
                                    <span class="total-lectures-time">发布时间</span>
                                </h3>
						
                                <div class="entry-content">
                                    <ul class="p-0 m-0">
hhh;
						echo $h1;
						$q1="select * from Video where vzhang='第一章' order by vtime";//第一章视频
						$r1=execute($link,$q1);
						while($d1=mysqli_fetch_assoc($r1)){

							$timestrap=strtotime($d1['vtime']);//格式化，取出日期
							$d=date('d',$timestrap);
							$m=date('m',$timestrap);
							$y=date('y',$timestrap);
							if($isteacher){
								$qt="select * from Teacher where teano={$member_id}";//如果是自己发的可以视频
								$rt=execute($link,$qt);
								if(($dt=mysqli_fetch_assoc($rt))){//如果是自己可以删除
									if($dt['name']==$d1['vteacher']){
										$htmldelete=<<<A
	<a href="course_info.php?isdelete=1&vno={$d1['vno']}&tname={$dt['name']}">
			点击删除（仅能删除自己发布的视频）
			</a>
								
A;
									}
								}
								
							}
							
							
							
								
								
							$hcontent=<<<e
							<a href="{$d1['vlink']}">
							 <li class="flex flex-column flex-lg-row align-items-lg-center">
							
							 	<span class="lecture-title">{$d1['vname']}</span>
							 	
							 	<span class="lectures-preview">{$d1['vteacher']}</span>
							 	
							 	<span class="lectures-time text-left text-lg-right">{$y}年{$m}月{$d}日</span>
											
							</li>	
    						</a>
							$htmldelete										
e;

							echo $hcontent;
						
						}
						
						$h1end=<<<end
						
						 </ul>
                                </div>
                                
                                
end;
						echo $h1end;
						?>
						
                            
                         <?php 
						$q1="select count(*) from Video where vzhang='第二章'";
						$num1=num($link, $q1);
						
						$h1=<<<hhh
							<h3 class="entry-title flex flex-wrap justify-content-between align-items-lg-center active">
                                    <span class="arrow-r"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></span>
                                    <span class="lecture-group-title">第二章</span>
                                    <span class="number-of-lectures">{$num1}个视频</span><!-- 视频数量 -->
                                    <span class="total-lectures-time">发布时间</span>
                                </h3>
						
                                <div class="entry-content">
                                    <ul class="p-0 m-0">
hhh;
						echo $h1;
						$q1="select * from Video where vzhang='第二章' order by vtime ";//查找我所有的问题
						$r1=execute($link,$q1);
						while($d1=mysqli_fetch_assoc($r1)){
							$timestrap=strtotime($d1['vtime']);//格式化，取出日期
$d=date('d',$timestrap);
$m=date('m',$timestrap);
$y=date('y',$timestrap);


$qt="select * from Teacher where teano={$member_id}";//如果是自己发的可以视频
$rt=execute($link,$qt);
if(($dt=mysqli_fetch_assoc($rt))){//如果是自己可以删除
	if($dt['name']==$d1['vteacher']){
		$htmldelete=<<<A
	<a href="course_info.php?isdelete=1&vno={$d1['vno']}&tname={$dt['name']}">
			点击删除（仅能删除自己发布的视频）
			</a>


A;
	}
}
$hcontent=<<<e
							<a href="{$d1['vlink']}">
							 <li class="flex flex-column flex-lg-row align-items-lg-center"><span class="lecture-title">{$d1['vname']}</span><span class="lectures-preview">{$d1['vteacher']}</span><span class="lectures-time text-left text-lg-right">{$y}年{$m}月{$d}日</span></li>
    						</a>	$htmldelete												
e;

							echo $hcontent;
						}
						
						$h1end=<<<end
						
						 </ul>
                      </div>
                                
                                
end;
						echo $h1end;
						?>   
                           <?php 
						$q1="select count(*) from Video where vzhang='第三章'";
						$num1=num($link, $q1);
						
						$h1=<<<hhh
							<h3 class="entry-title flex flex-wrap justify-content-between align-items-lg-center active">
                                    <span class="arrow-r"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></span>
                                    <span class="lecture-group-title">第三章</span>
                                    <span class="number-of-lectures">{$num1}个视频</span><!-- 视频数量 -->
                                    <span class="total-lectures-time">发布时间</span>
                                </h3>
						
                                <div class="entry-content">
                                    <ul class="p-0 m-0">
hhh;
						echo $h1;
						$q1="select * from Video where vzhang='第三章' order by vtime ";//查找我所有的问题
						$r1=execute($link,$q1);
						while($d1=mysqli_fetch_assoc($r1)){
							$timestrap=strtotime($d1['vtime']);//格式化，取出日期
$d=date('d',$timestrap);
$m=date('m',$timestrap);
$y=date('y',$timestrap);
$qt="select * from Teacher where teano={$member_id}";//如果是自己发的可以视频
$rt=execute($link,$qt);
if(($dt=mysqli_fetch_assoc($rt))){//如果是自己可以删除
	if($dt['name']==$d1['vteacher']){
		$htmldelete=<<<A
	<a href="course_info.php?isdelete=1&vno={$d1['vno']}&tname={$dt['name']}">
			点击删除（仅能删除自己发布的视频）
			</a>


A;
	}
}
$hcontent=<<<e
							<a href="{$d1['vlink']}">
							 <li class="flex flex-column flex-lg-row align-items-lg-center"><span class="lecture-title">{$d1['vname']}</span><span class="lectures-preview">{$d1['vteacher']}</span><span class="lectures-time text-left text-lg-right">{$y}年{$m}月{$d}日</span></li>
    						</a>$htmldelete													
e;

							echo $hcontent;
						}
						
						$h1end=<<<end
						
						 </ul>
                                </div>
                                
                                
end;
						echo $h1end;
						?>    
                          <?php 
						$q1="select count(*) from Video where vzhang='第四章'";
						$num1=num($link, $q1);
						
						$h1=<<<hhh
							<h3 class="entry-title flex flex-wrap justify-content-between align-items-lg-center active">
                                    <span class="arrow-r"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></span>
                                    <span class="lecture-group-title">第四章</span>
                                    <span class="number-of-lectures">{$num1}个视频</span><!-- 视频数量 -->
                                    <span class="total-lectures-time">发布时间</span>
                                </h3>
						
                                <div class="entry-content">
                                    <ul class="p-0 m-0">
hhh;
						echo $h1;
						$q1="select * from Video where vzhang='第四章' order by vtime ";//查找我所有的问题
						$r1=execute($link,$q1);
						while($d1=mysqli_fetch_assoc($r1)){
							$timestrap=strtotime($d1['vtime']);//格式化，取出日期
$d=date('d',$timestrap);
$m=date('m',$timestrap);
$y=date('y',$timestrap);
$qt="select * from Teacher where teano={$member_id}";//如果是自己发的可以视频
$rt=execute($link,$qt);
if(($dt=mysqli_fetch_assoc($rt))){//如果是自己可以删除
	if($dt['name']==$d1['vteacher']){
		$htmldelete=<<<A
	<a href="course_info.php?isdelete=1&vno={$d1['vno']}&tname={$dt['name']}">
			点击删除（仅能删除自己发布的视频）
			</a>


A;
	}
}
$hcontent=<<<e
							<a href="{$d1['vlink']}">
							 <li class="flex flex-column flex-lg-row align-items-lg-center"><span class="lecture-title">{$d1['vname']}</span><span class="lectures-preview">{$d1['vteacher']}</span><span class="lectures-time text-left text-lg-right">{$y}年{$m}月{$d}日</span></li>
    						</a>	$htmldelete												
e;

							echo $hcontent;
						}
						
						$h1end=<<<end
						
						 </ul>
                                </div>
                                
                                
end;
						echo $h1end;
						?>        
<?php 
						$q1="select count(*) from Video where vzhang='第五章'";
						$num1=num($link, $q1);
						
						$h1=<<<hhh
							<h3 class="entry-title flex flex-wrap justify-content-between align-items-lg-center active">
                                    <span class="arrow-r"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></span>
                                    <span class="lecture-group-title">第五章</span>
                                    <span class="number-of-lectures">{$num1}个视频</span><!-- 视频数量 -->
                                    <span class="total-lectures-time">发布时间</span>
                                </h3>
						
                                <div class="entry-content">
                                    <ul class="p-0 m-0">
hhh;
						echo $h1;
						$q1="select * from Video where vzhang='第五章' order by vtime ";//查找我所有的问题
						$r1=execute($link,$q1);
						while($d1=mysqli_fetch_assoc($r1)){
							$timestrap=strtotime($d1['vtime']);//格式化，取出日期
$d=date('d',$timestrap);
$m=date('m',$timestrap);
$y=date('y',$timestrap);
$qt="select * from Teacher where teano={$member_id}";//如果是自己发的可以视频
$rt=execute($link,$qt);
if(($dt=mysqli_fetch_assoc($rt))){//如果是自己可以删除
	if($dt['name']==$d1['vteacher']){
		$htmldelete=<<<A
	<a href="course_info.php?isdelete=1&vno={$d1['vno']}&tname={$dt['name']}">
			点击删除（仅能删除自己发布的视频）
			</a>


A;
	}
}
$hcontent=<<<e
							<a href="{$d1['vlink']}">
							 <li class="flex flex-column flex-lg-row align-items-lg-center"><span class="lecture-title">{$d1['vname']}</span><span class="lectures-preview">{$d1['vteacher']}</span><span class="lectures-time text-left text-lg-right">{$y}年{$m}月{$d}日</span></li>
    						</a>	$htmldelete												
e;

							echo $hcontent;
						}
						
						$h1end=<<<end
						
						 </ul>
                                </div>
                                
                                
end;
						echo $h1end;
						?>  
                         <?php 
						$q1="select count(*) from Video where vzhang='第六章'";
						$num1=num($link, $q1);
						
						$h1=<<<hhh
							<h3 class="entry-title flex flex-wrap justify-content-between align-items-lg-center active">
                                    <span class="arrow-r"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></span>
                                    <span class="lecture-group-title">第六章</span>
                                    <span class="number-of-lectures">{$num1}个视频</span><!-- 视频数量 -->
                                    <span class="total-lectures-time">发布时间</span>
                                </h3>
						
                                <div class="entry-content">
                                    <ul class="p-0 m-0">
hhh;
						echo $h1;
						$q1="select * from Video where vzhang='第六章' order by vtime ";//查找我所有的问题
						$r1=execute($link,$q1);
						while($d1=mysqli_fetch_assoc($r1)){
							$timestrap=strtotime($d1['vtime']);//格式化，取出日期
$d=date('d',$timestrap);
$m=date('m',$timestrap);
$y=date('y',$timestrap);
$qt="select * from Teacher where teano={$member_id}";//如果是自己发的可以视频
$rt=execute($link,$qt);
if(($dt=mysqli_fetch_assoc($rt))){//如果是自己可以删除
	if($dt['name']==$d1['vteacher']){
		$htmldelete=<<<A
	<a href="course_info.php?isdelete=1&vno={$d1['vno']}&tname={$dt['name']}">
			点击删除（仅能删除自己发布的视频）
			</a>

A;
	}
}
$hcontent=<<<e
							<a href="{$d1['vlink']}">
							 <li class="flex flex-column flex-lg-row align-items-lg-center"><span class="lecture-title">{$d1['vname']}</span><span class="lectures-preview">{$d1['vteacher']}</span><span class="lectures-time text-left text-lg-right">{$y}年{$m}月{$d}日</span></li>
    						</a>$htmldelete													
e;

							echo $hcontent;
						}
						
						$h1end=<<<end
						
						 </ul>
                                </div>
                                
                                
end;
						echo $h1end;
						?>              
                                   

                               

                            </div>
                        </div><!-- .entry-contents -->
                    </div><!-- .single-course-accordion-cont  -->

<!--                     

                    <di
                </div><!-- .single-course-wrap -->
            </div><!-- .col -->
            <div class="single-course-cont-section">
                        <h2>我将学习什么？</h2>

                        <ul class="p-0 m-0 green-ticked">
                            <li>叙述网络安全概念，定义网络安全术语。在此基础上，宏观分析数据有效性，规划网络安全组件，并定义网络安全策略。</li>
                            <li>熟练掌握CIDR和VLSM技术、IP路由原理，了解IPSec和IPv6协议。</li>
                            <li>使用控制台进行Windows安全策略设置。</li>
                            <li>通过配置启动脚本设置Linux安全性。</li>
                            <li>对Web服务、DNS服务、FTP和电子邮件服务进行用户权限和访问控制设置。<li>
                            <li>掌握病毒的原理，了解杀毒软件的原理的使用。</li>
                        </ul>

                        <h2>先修课程</h2>

                        <ul class="p-0 m-0 black-doted">
                            <li>计算机操作系统</li>
                            <li>计算机网络</li>
                            <li>数据结构</li>
                            <li>密码学</li>
                        </ul>

                        <h2>具体介绍</h2>
						<p>课程包含理论和实验部分。课程包含六章，每章可能会有作业……</p>
                        <p>网络安全是一门综合性较强的计算机专业技术课程，它是计算机专业各门基础技术课程在安全方面的延伸和集成，它直接为实际应用服务，具有很强的实际意义。</p>
                        <p>本门课程的任务是培养学生将所学过的各专业基础知识融会贯通的能力，使其明确计算机安全的基本概念、基础知识，对什么是网络安全有一个比较全面的了解，具有一定的安全问题分析和解决能力；理解并掌握网络安全体系的基本原理、方法和策略；并能够从管理角度研究网络系统的安全问题。</p>
                        <p>1、通过本课程的教学和实践，使学生较系统地掌握网络安全协议、网络安全工具及网络安全标准的基本原理、相关理论、技术与实现方法，学会基本的网络安全协议和网络安全工具的使用方法，培养学生掌握网络安全协议、工具和标准的基本原理和实际操作能力，以及具有分析、设计、构建并维护网络安全系统的初步能力，通过实践性教学环节培养学生的工程实践能力、交流沟通能力、创新应用能力。掌握网络安全协议、网络攻击工具的分析和设计方法，对网络安全具有分析、设计和评估的初步能力，熟悉和掌握常用的网络安全体系结构、协议和标准、相关的安全实用技术。</p>
                        <p>2、本课程的理论性强、知识面宽、应用广泛、实用强，是高度面向应用的课程，教师在理论教学和实验教学的过程中要结合实际的网络工程项目和应用，深入浅出地讲解理论，培养学生的工程实践能力。</p>
                        <p>3、网络协议的分析、网络的组建和测试、网络管理等都离不开相关的工具软件，教师要熟练掌握虚拟机软件 VMware workstation、网络协议分析工具 Wireshark等一系列的工具软件和虚拟软件，懂得网络虚拟实验平台的搭建和使用，授课时根据实际的内容适当使用这些软件进行演示。并且要求学生要逐步熟悉这些软件的使用。</p>
                       

                       
                    </div>
        </div><!-- .row -->
        
        
        
        
    </div><!-- .container -->

    

    <footer class="site-footer">
        <div class="footer-widgets">
            <div class="container">
                
            </div><!-- .container -->
        </div><!-- .footer-widgets -->

        <div class="footer-bar">
            <div class="container">
                
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