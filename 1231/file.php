<?php 
include_once './inc/config.inc.php';
include_once './inc/mysql.inc.php';
include_once './inc/tool.inc.php';
include_once './head.php';
$link=connect();

$member_id=is_login($link);//是否登录
$isteacher=isteacher($link);//是不是老师

$htmlupload="";//上传显示
//┼

$sname=0;
$tname=0;
if(!$member_id){//未登录
	$html=<<<A
		<li><a href="sign-up.php">注册</a></li>
		<li><a href="sign-in.php">登录</a></li>
A;
//不能下载和上传

	if(isset($_GET['flink'])){
		
		//点击链接
		skip_message("file.php", "你没有登录，无法下载");
		
		
	}
}else if($isteacher){
	$html=<<<A
	<li><a href="./teacher-center/pixel-html/tea_self-center.php">老师后台管理系统</a></li>
	<li><a href="sign-out.php">退出</a></li>
A;
	
//可以上传也可以下载 
//上传
	$squery="select * from Teacher where teano={$member_id}";
	$sresult=execute($link, $squery);
	  while ($sdata=mysqli_fetch_assoc($sresult)){
	  	$tname=$sdata['name'];
	  }
	  $htmlupload=<<<load
	  
	  
                     <div class="col-12 col-lg-12">
                		<div class="contact-form">
	  
                     	<form action="file.php?sname=isteacher" method="post" enctype="multipart/form-data" >
	                  		<h4>&emsp;&emsp;</h4>
	  
							&emsp;<div class="jia">浏览</div>
							<input class="name" type="file" name="myfile" />
	  
							<input type="text" name="sfname" placeholder="分享你的文件并填写文件描述，最多32个字符，支持" autocomplete="off"  >
							<input type="submit" name="submit" value="开始上传"/>
                    	</form>
	  
                </div><!-- .contact-form -->
            </div><!-- .col -->
	  
load;
	
}
else{//学生 上传
	$html=<<<A
	<li><a href="./self-center/pixel-html/self-center.php">个人中心</a></li>
	<li><a href="sign-out.php">退出</a></li>
A;
	
	$squery="select * from Student where sno={$member_id}";
	$sresult=execute($link, $squery);
	while ($sdata=mysqli_fetch_assoc($sresult)){
		$sname=$sdata['name'];
	}

	$htmlupload=<<<load
	 
	 
                     <div class="col-12 col-lg-12">
                		<div class="contact-form">
	 
                     	<form action="file.php?sname={$sname}" method="post" enctype="multipart/form-data" >
	                  		<h4>&emsp;&emsp;</h4>
	     
							&emsp;<div class="jia">浏览</div>
							<input class="name" type="file" name="myfile" />
	
							<input type="text" name="sfname" placeholder="分享你的文件并填写文件描述，最多32个字符，支持.docx .doc .pdf .jpg .png .pptx .txt .rar .zip .gif .jpeg " autocomplete="off"  >
							<input type="submit" name="submit" value="开始上传"/>
                    	</form>
	 
                </div><!-- .contact-form -->
            </div><!-- .col -->
	 
load;
}
//下载
if($member_id){//登录状态下载
	
	if(isset($_GET['flink'])){
		if(!function_exists('finfo_open')){
			header('Content-type:text/html;charset=utf-8');
			exit('请先开启PHP扩展:fileinfo！');
		}
	
		$file=$_GET['flink'];
		$fileinfo=finfo_open(FILEINFO_MIME_TYPE);
		$mimeType=finfo_file($fileinfo,$file);
		finfo_close($fileinfo);
		//发送指定的文件MIME类型的头信息
		header('Content-type:'.$mimeType);
		//指定下载文件的描述
		header('Content-Disposition:attachment;filename='.basename($file));
		//指定文件的大小
		header('Content-Length:'.filesize($file));
		//读取文件内容至输出缓冲区,返回这个文件
		readfile($file);
	
	}
	
}	


?>
<?php
//上传下载

//header('Content-type:text/html;charset=utf-8');
//var_dump($_FILES);//一开始保存在tmp临时文件夹中
$allowed = array("gif", "jpeg", "jpg", "png","pptx","docx","doc","pdf","txt","rar","zip");//支持的格式
if(isset($_POST['submit'])){//判断变量存在
	$arr=pathinfo($_FILES['myfile']['name']);//获得扩展名 （数组） $arr['extension']
	//&&$_FILES["myfile"]["type"] == "application/pdf"   "text/plain"  application/octet-stream  application/x-zip-compressed  "aplication/zip"  "application/msword"
	if(is_uploaded_file($_FILES['myfile']['tmp_name'])&&in_array($arr['extension'], $allowed))
		{//如果是httppost上传
		//移动
		$newname=date('YmdG').rand(10,99);//随机生成的名字
		if($_GET['sname']=='isteacher'){//老师传文件
			move_uploaded_file($_FILES['myfile']['tmp_name'], 'coursefiles/'.$newname.'.'.$arr['extension']);
			$newaddr='coursefiles/'.$newname.'.'.$arr['extension'];
			$q1="insert into Course_File(cfname,flink) values('{$_POST['sfname']}','{$newaddr}')";//按fno分组取出每组最大的
			$result1=execute($link,$q1);
			if(mysqli_affected_rows($link)==1){
				skip_message('file.php', '上传成功！');
			}else{
				skip_message('file.php', '上传失败1！');
			}
			


		}//下面是学生传文件
		else if(move_uploaded_file($_FILES['myfile']['tmp_name'], './students_files/'.$newname.'.'.$arr['extension'])){
		//如果移动成功
			$newaddr='students_files/'.$newname.'.'.$arr['extension'];			
			$q2="insert into Student_File(flink,sfname,sname,ftime) values( '{$newaddr}' ,'{$_POST['sfname']}','{$_GET['sname']}',now())";//按fno分组取出每组最大的
			$result2=execute($link,$q2);
			if(mysqli_affected_rows($link)==1){
				skip_message('file.php', '上传成功！');
			}else{
				skip_message('file.php', '上传失败1！');
			}
			
		}
		else{
            echo $member_id;
            exit();
			skip_message('file.php', '上传失败2！');
		}
	}
	else{
		skip_message('file.php', "可能有攻击,请你做合法的事");
		}
	
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>

    <title>网络安全课程学习系统</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!-- 上传 -->
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
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
    <link rel="stylesheet" href="a.css">
</head>
<body class="blog-page">
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
                                     <?php echo $html ?>
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
                                   <li style="font-size:20px"><a href="index.php">首页</a></li>
                                    <li style="font-size:20px"><a href="introduce.php">介绍</a></li>
                                    <li style="font-size:20px"><a href="course_info.php">课程</a></li>
                                    <li style="font-size:20px"><a href="./discuss/discuss.php">讨论</a></li>
                                    <li  class="current-menu-item"  style="font-size:20px"><a href="file.php">下载</a></li>
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
                            <h1>资源分享区</h1>
                      
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
                        <li><a href="index.php"><i class="fa fa-home"></i> 首页</a></li>
                        <li>资源分享</li>
                    </ul>
                </div><!-- .breadcrumbs -->
            </div><!-- .col -->
           
        </div><!-- .row -->
        <?php 
        
        	echo $htmlupload;
        
        ?>
       
       
        <div class="row">
        
       <br/><br/><br/>
            <div class="col-12 col-lg-8">
                <div class="blog-posts">
                    <div class="row mx-m-25">
                   
                    	<?php 
                    	$query1="select * from Course_File order by fno ";//找出老师的内容
                    	$result1=execute($link,$query1);
                    	while($data1=mysqli_fetch_assoc($result1)){
                    		$data1['flink'];
                    		$xianshi_link=substr($data1['flink'],12);
							$htmlfile_info_teacher=<<<ttt
							 <div class="col-12 col-md-6 px-25">
                            <div class="blog-post-content">
                                <figure class="blog-post-thumbnail position-relative m-0">
<!--                                     <a href="#"><img src="images/b-1.jpg" alt=""></a> -->

                                    <div class="posted-date position-absolute">
<!--                                     <放序号> -->
                                        <div class="day">{$data1['fno']}</div>
                                        <div class="month"></div>
                                    </div>
                                </figure><!-- .blog-post-thumbnail -->

                                <div class="blog-post-content-wrap">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="file.php?flink={$data1['flink']}">{$xianshi_link}</a></h2>

                                        <div class="entry-meta flex align-items-center">
                                            <div class="post-author"><a href="#">老师 </a></div>

                                            <div class="post-comments"><a href="#">课件</a></div>
                                        </div><!-- .entry-meta -->
                                    </header><!-- .entry-header -->

                                    <div class="entry-content">
                                        <p>{$data1['cfname']}</p><p><br/></p><p><br/></p>
                                    </div><!-- .entry-content -->
                                </div><!-- .blog-post-content-wrap -->
                            </div><!-- .blog-post-content -->
                        </div><!-- .col -->
ttt;
						echo $htmlfile_info_teacher;

                    	}
                    	
                    	
                    	
                    	
                    	
                    	?>
                    	
                    	<?php 
                    	$query1="select * from Student_File order by fno desc";//找出学生分享的内容
                    	$result1=execute($link,$query1);
                    	$count=0;//倒序排列
                    	while($data1=mysqli_fetch_assoc($result1)){
                    		$data1['flink'];
							$count++;
							$xianshi_link=substr($data1['flink'],15);
							$htmlfile_info_stu=<<<ttt
							 <div class="col-12 col-md-6 px-25">
                            <div class="blog-post-content">
                                <figure class="blog-post-thumbnail position-relative m-0">
<!--                                     <a href="#"><img src="images/b-1.jpg" alt=""></a> -->

                                    <div class="posted-date position-absolute">
<!--                                     <放序号> -->
                                       
                                        <div class="month">学生分享（{$count}）{$data1['ftime']} </div>
                                    </div>
                                </figure><!-- .blog-post-thumbnail -->

                                <div class="blog-post-content-wrap">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="file.php?flink={$data1['flink']}">{$xianshi_link}</a></h2>

                                        <div class="entry-meta flex align-items-center">
                                            <div class="post-author"><a href="#">学生 </a></div>

                                            <div class="post-comments"><a href="#">{$data1['sname']}&nbsp;分享的文件 </a></div>
                                        </div><!-- .entry-meta -->
                                    </header><!-- .entry-header -->

                                    <div class="entry-content">
                                        <p>{$data1['sfname']}</p>
                     			<p><br/></p><p><br/></p>
                                    </div><!-- .entry-content -->
                                </div><!-- .blog-post-content-wrap -->
                            </div><!-- .blog-post-content -->
                        </div><!-- .col -->
ttt;
						echo $htmlfile_info_stu;

                    	}
                    	?>
                    	
                    	
                    	
                        

                        <div class="col-12 col-md-6 px-25">
                            <div class="blog-post-content">
                                <figure class="blog-post-thumbnail position-relative m-0">
<!--                                     <a href="#"><img src="images/b-6.jpg" alt=""></a> -->

                                  
                                </figure><!-- .blog-post-thumbnail -->

                                <div class="blog-post-content-wrap">
                                    

                                    <div class="entry-content">
                                        <p>欢迎师生们互相分享资料！<br/>  点击文件名即可下载（非用户无法下载）</p>
                                    </div><!-- .entry-content -->
                                </div><!-- .blog-post-content-wrap -->
                            </div><!-- .blog-post-content -->
                        </div><!-- .col -->
                    </div><!-- .blog-posts -->
                </div><!-- .col -->

            

            
        </div><!-- .row -->
    </div><!-- .container -->

    

    <script type='text/javascript' src='js/jquery.js'></script>
    <script type='text/javascript' src='js/swiper.min.js'></script>
    <script type='text/javascript' src='js/masonry.pkgd.min.js'></script>
    <script type='text/javascript' src='js/jquery.collapsible.min.js'></script>
    <script type='text/javascript' src='js/custom.js'></script>

</body>
</html>