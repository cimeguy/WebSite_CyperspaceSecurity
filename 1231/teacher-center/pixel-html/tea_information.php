<?php 
include_once (dirname(__FILE__)."/../../inc/config.inc.php");
include_once '../../inc/mysql.inc.php';
include_once '../../inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);//是否登录
if(!$member_id){
	skip('./../../sign-in.php','error','您未登录！');
}

if(isset($_POST['submit'])){
// 	if(!defined('IN_NETSEC')){
// 		exit(':((');
// 	}
	if(empty($_POST['name'])){
		skip_message('tea_information.php', '姓名不得为空');
	}
	if(mb_strlen($_POST['name'],"utf-8")>32){
		
		skip_message('tea_information.php', '用户名长度不要超过32个字符！');
	}
	
	if(mb_strlen($_POST['pw'])<6&&mb_strlen($_POST['pw'])>0){
		skip_message('tea_information.php', '密码不得少于6位！');
	}
	if(mb_strlen($_POST['college'],"utf-8")>32){
		skip_message('tea_information.php',  '学院长度不要超过32个字符！');
	}
	
	$_POST=escape($link,$_POST);
// 	$query="select * from Student where sno='{$_POST['sno']}' and sno!={$me}";
// 	$result=execute($link, $query);
// 	if(mysqli_num_rows($result)){
// 		skip('information.php', 'error', '该学号用户已存在！');
// 	}

    if(mb_strlen($_POST['pw'])>0){
        $query="update Teacher set name='{$_POST['name']}',pw=md5('{$_POST['pw']}'),college='{$_POST['college']}' where teano='{$member_id}'";
        execute($link,$query);
        if(mysqli_affected_rows($link)==1){
    // 		setcookie('netsec[sno]',$_POST['sno']);
            setcookie('netsec[pw]',sha1(md5($_POST['pw'])));
            
            skip_message('tea_information.php', '更改信息成功！');
        }else{
            skip_message('tea_information.php', '未更改任何信息！');
        }
    }
    else{
        $query="update Teacher set name='{$_POST['name']}',college='{$_POST['college']}' where teano='{$member_id}'";
        execute($link,$query);
        if(mysqli_affected_rows($link)==1){
            
            skip_message('tea_information.php', '更改信息成功！');
        }else{
            skip_message('tea_information.php', '未更改任何信息！');
        }
    }
	
	
}

?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>个人信息</title>
    <!-- Bootstrap Core CSS -->
    <link href="./bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="./css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="./css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="./css/colors/blue-dark.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars"></i></a>
                <div class="top-left-part"><a class="logo" href="self-center.php"><b><img src="../plugins/images/pixeladmin-logo.png" alt="home" /></b><fond style="font-size:25px">个人中心</fond></a></div>
<!--                 <ul class="nav navbar-top-links navbar-left m-l-20 hidden-xs"> -->
<!--                     <li> -->
<!--                         <form role="search" class="app-search hidden-xs"> -->
<!--                             <input type="text" placeholder="个人中心" class="form-control"> <a href="self-center.php"><i class="fa fa-search"></i></a> -->
<!--                         </form> -->
<!--                     </li> -->
<!--                 </ul> -->
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <a class="profile-pic" href="#"> <img src="../plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">
                        <?php 
                        $query="select * from Teacher where teano='{$member_id}'";
                        $result=execute($link, $query);
                        
                        if(mysqli_num_rows($result)==1){
								$row = $result->fetch_assoc();
								echo $row['name'];
                        	}                        	           
?>
						</b> </a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">
                    <li style="padding: 10px 0 0;">
                        <a href="tea_self-center.php" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i><span class="hide-menu">消息</span></a>
                    </li>
                    <li>
                        <a href="tea_information.php" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i><span class="hide-menu">个人信息</span></a>
                    </li>
                    <li>
                        <a href="tea_homework.php" class="waves-effect"><i class="fa fa-table fa-fw" aria-hidden="true"></i><span class="hide-menu">作业详情</span></a>
                    </li>
                    <li>
                        <a href="course_detail.php" class="waves-effect"><i class="fa fa-table fa-fw" aria-hidden="true"></i><span class="hide-menu">课程详情</span></a>
                    </li>
                   
                </ul>
                <div class="center p-20">
                </div>
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">个人信息</h4> </div>
                        <ol class="breadcrumb">
                            <li><a href="../../index.php">首页</a></li>
                            <li><a href="../../sign-out.php">退出</a></li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-md-4 col-xs-12">
                        <div class="white-box">
                            <div class="user-bg"> <img width="100%" alt="user" src="../plugins/images/large/img1.jpg">
                                <div class="overlay-box">
                                    <div class="user-content">
                                        <a href="javascript:void(0)"><img src="../plugins/images/users/genu.jpg" class="thumb-lg img-circle" alt="img"></a>
                                        <h4 class="text-white">
                                        	<?php 
                        $query="select * from Teacher where teano='{$member_id}'";
                        $result=execute($link, $query);
                        
                        if(mysqli_num_rows($result)==1){
								$row = $result->fetch_assoc();
								echo $row['name'];
                        	}                        	           
?>
                                        </h4>
                                        <h5 class="text-white">
                                        <?php 
                        $query="select * from Teacher where teano='{$member_id}'";
                        $result=execute($link, $query);
                        
                        if(mysqli_num_rows($result)==1){
								$row = $result->fetch_assoc();
								echo $row['college'];
                        	}                        	           
?>
                                        
                                        </h5> </div>
                                        <!--todo-->>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="col-md-8 col-xs-12">
                        <div class="white-box">
                            <form method="post" class="form-horizontal form-material">
                            <?php 
                        $query="select * from Teacher where teano='{$member_id}'";
                        $result=execute($link, $query);
                        
                        if(mysqli_num_rows($result)==1){
								$row = $result->fetch_assoc();
								
                        	}                        	           
?>
								<div class="form-group">
                                    <label class="col-md-12">工号（一经注册，不得修改！）</label>
                                    
                                    	<p class="col-md-12"><?php echo $row['teano']?></p>              
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">姓名</label>
                                    <div class="col-md-12">
                                        <input type="text" name="name" value="<?php echo $row['name']?>" class="form-control form-control-line"> </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-12">密码</label>
                                    <div class="col-md-12">
                                        <input type="password"  name="pw"  class="form-control form-control-line" > </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-12">学院</label>
                                    <div class="col-md-12">
                                        <input type="text" name="college" value="<?php echo $row['college']?>" class="form-control form-control-line"> </div>
                                </div>

                                
                                <div class="form-group">
                                    <div class="col-sm-12">
                                    	<input type="submit" name="submit" value="更新个人信息"  class="btn btn-success">
<!--                                         <button name="submit" class="btn btn-success">更新个人信息</button> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="./bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="./js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="./js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="./js/custom.min.js"></script>
</body>

</html>
