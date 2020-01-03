 <?php 
define('IN_NETSEC',true);
include_once './inc/config.inc.php';
include_once './inc/mysql.inc.php';
include_once './inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);
if($member_id){

	skip_message('./index.php', '你已经登录，请不要重复注册！');
}
if(isset($_POST['submit'])){
	include './sign-in-out/inc/check_signup.inc.php';
	if($_POST['category']==0){//老师
		if($_POST['pw']==100100){
			
			$query="insert into Teacher(teano,name,pw,register_time,last_time) values('{$_POST['sno']}','{$_POST['name']}',md5('{$_POST['pw']}'),now(),now())";
			
		}
		else{
			
			skip_message('sign-up.php', '口令失败！');
		}
	}
	else{//学生
		$query="insert into Student(name,sno,pw,class,college,regis_time,last_time) values('{$_POST['name']}','{$_POST['sno']}',md5('{$_POST['pw']}'),'','',now(),now())";	
	}
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		setcookie('netsec[sno]',$_POST['sno']);
		setcookie('netsec[pw]',sha1(md5($_POST['pw'])));//MD5  SHA-1双重加密

		skip_message('./index.php', '注册成功！');
	}else{
		
		skip_message('./index.php', '注册失败,请重试！');
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
	<title>注册页</title>
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
						<h2>注册</h2>
						
						
						
						<div class="form-group">
							<label for="name" class="sr-only">姓名</label>
							<input type="text" class="form-control" name="name" placeholder="姓名" autocomplete="off" required oninvalid="setCustomValidity('此字段未填写')" oninput="setCustomValidity('')">
						</div>
						<div class="form-group">
							<label for="sno" class="sr-only">学号</label>
							<input type="text" class="form-control" name="sno" placeholder="学号/工号" autocomplete="off"  required>
						</div>
						<div class="form-group">
							<label for="password" class="sr-only">密码</label>
							<input type="password" class="form-control" name="pw" placeholder="密码" autocomplete="off" required>
						</div>
						<div class="form-group">
							<label for="re-password" class="sr-only">重新输入密码</label>
							<input type="password" class="form-control" name="confirm_pw" placeholder="重新输入密码" autocomplete="off" required>
						</div>
						<div class="form-group">
						
							我是&nbsp;&nbsp;<input type="radio" name="category" value="1" checked="checked"/>&nbsp;学生&nbsp;&nbsp;<!--name一样-->
							<input type="radio" name="category" value="0"/>&nbsp;老师&nbsp;&nbsp;
						</div>
						
						<div class="form-group">
							<p>已经注册？ <a href="sign-in.php">登录</a></p>
			
						</div>
						<div class="form-group">
						
							<input type="submit" name="submit" value="注册" class="btn btn-primary">
						<!--todo-->
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

