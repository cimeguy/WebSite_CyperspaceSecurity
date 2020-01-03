<?php 
include_once './inc/config.inc.php';
include_once './inc/mysql.inc.php';
include_once './inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);
if($member_id){
	skip_message('index.php','你已经登录，请不要重复登录！');

}
if(isset($_POST['submit'])){
	include './sign-in-out/inc/check_signin.inc.php';
	escape($link,$_POST);
	$query="select * from Student where sno='{$_POST['sno']}' and pw=md5('{$_POST['pw']}')";//学生
	$result=execute($link, $query);
	$querytea="select * from Teacher where teano='{$_POST['sno']}' and pw=md5('{$_POST['pw']}')";//老师
	$resulttea=execute($link, $querytea);
	if(mysqli_num_rows($result)==1||mysqli_num_rows($resulttea)==1){
		setcookie('netsec[sno]',$_POST['sno'],time()+$_POST['time']);
		setcookie('netsec[pw]',sha1(md5($_POST['pw'])),time()+$_POST['time']);//第四个参数为空的话，默认只在当前目录生效，故必须不为空
		/*设置这个登录的会员对于的last_time这个字段为now()*/
		skip_message('index.php','登录成功！');
	}
	else{
	
		skip_message('sign-in.php','账号或密码填写错误！');
	}
}
?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="zh-CN"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>登录页</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Free HTML5 Template by FreeHTML5.co" />
	<meta name="keywords" content="free html5, free template, free bootstrap, html5, css3, mobile first, responsive" />
	

  

  	<!-- Facebook and Twitter integration -->
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="favicon.ico">

	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>
	
	<link rel="stylesheet" href="./sign-in-out/css/bootstrap.min.css">
	<link rel="stylesheet" href="./sign-in-out/css/animate.css">
	<link rel="stylesheet" href="./sign-in-out/css/style.css">


	<!-- Modernizr JS -->
	<script src="./sign-in-out/js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="./sign-in-out/js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body class="style-2">

		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					

					<!-- Start Sign In Form -->
					<form method="post" action="#" class="fh5co-form animate-box" data-animate-effect="fadeInLeft">
						<h2>登录</h2>
						<div class="form-group">
							<label for="username" class="sr-only">学号/工号</label>
							<input type="text" class="form-control" name="sno" placeholder="学号/工号" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="password" class="sr-only">密码</label>
							<input type="password" class="form-control" name="pw" placeholder="密码" autocomplete="off">
						</div>
						
						<div class="form-group">
							<p>没有账号？ <a href="sign-up.php">注册</a>
						</div>
						<div class="form-group">
							<label>自动登录：
								<select style="width:289px;height:25px;" name="time">
									<option value="3600">1小时内</option>
									<option value="86400">1天内</option>
									<option value="259200">3天内</option>
									<option value="2592000">30天内</option>
								</select>
							</label>
						</div>
						<br/>
						<div class="form-group">
							<a href="index.php">
								<input type="submit" name="submit" value="登录" class="btn btn-primary">
							<!--todo-->
							</a>
						</div>
					</form>
					<!-- END Sign In Form -->

				</div>
			</div>
			<div class="row" style="padding-top: 60px; clear: both;">
			</div>
		</div>
	
	<!-- jQuery -->
	<script src="./sign-in-out/js/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="./sign-in-out/js/bootstrap.min.js"></script>
	<!-- Placeholder -->
	<script src="./sign-in-out/js/jquery.placeholder.min.js"></script>
	<!-- Waypoints -->
	<script src="./sign-in-out/js/jquery.waypoints.min.js"></script>
	<!-- Main JS -->
	<script src="./sign-in-out/js/main.js"></script>

	</body>
</html>



