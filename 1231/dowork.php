<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);//是否登录
if(!$member_id){
	skip_message('./index.php', '您未登录！');
}
// $_GET['message']=htmlspecialchars($_GET['message']);
if(!isset($_GET['wno']) || !isset($_GET['sno'])){
	exit();
}
$thistime=(new \DateTime())->format('Y-m-d H:i:s');
$sno=(int)$_GET['sno'];
$wno=(int)$_GET['wno'];
$query="select * from SeleWork where wno={$wno} and sno={$sno}";
$result=execute($link, $query);
while($select=mysqli_fetch_assoc($result)){
	if($select['grade']==404){//已经提交过了
		skip_message('self-center.php', '你已经答过题了！');
	}
	//未提交或者已经截止
	$query2="select * from Work where wno={$wno}";
	$result2=execute($link, $query2);
	while($work2=mysqli_fetch_assoc($result2)){
		if($work2['ddl']<$thistime){
			skip_message('self-center.php', '已经截止了！');
		}
	}
}
?>

<?php 
$have_select=0;//用于判断是否有选择、简答题  有=1
$have_jianda=0;
 //判断
$query="select * from question where wno={$wno}";//查找我所有的问题
$result=execute($link,$query);
while($quest=mysqli_fetch_assoc($result)){
	if(!(int)$quest['is_select']){//不是选择（简答）
		$have_jianda=1;
		break;
	}
	else{//是选择
		$have_select=1;
		break;
	}
}
 

if($_GET['grade'] == 404){//完成提交作业

	$query="select * from question where wno={$wno}";//查找我所有的问题
	$result=execute($link,$query);
	$countok=1;//表示所有提交成功
	while($question=mysqli_fetch_assoc($result)){
		$qno=(int)$question['qno'];
		$query="INSERT INTO Answer(sno,qno,wno,atext,ascore) VALUES ({$member_id},{$qno},{$wno},'{$_POST[$qno]}',404)";
		execute($link,$query);
		if(mysqli_affected_rows($link)==1){
		}else{
			$countok=0;
			skip_message('self-center/pixel-html/homework.php', '提交失败！error1');
		}
	}
	//提交完多条以后
	if($countok==1){
		$query2="update SeleWork set grade=404 where sno={$member_id} and wno={$wno}";
		execute($link,$query2);
		if(mysqli_affected_rows($link)==1){
			skip_message('self-center/pixel-html/homework.php', '提交成功！');
		}
		else{
			skip_message('self-center/pixel-html/homework.php', '提交失败！error2');
		}
	
	}else{
		skip_message('self-center/pixel-html/homework.php', '提交失败！error3');
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
    <link rel="icon" type="image/png" sizes="16x16" href="self-center/plugins/images/favicon.png">
    <title>个人信息</title>
    <!-- Bootstrap Core CSS -->
    <link href="self-center/pixel-html/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="self-center/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="self-center/pixel-html/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="self-center/pixel-html/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="self-center/pixel-html/css/colors/blue-dark.css" id="theme" rel="stylesheet">
    <link href="self-center/pixel-html/css/publish.css" rel="stylesheet">
<!--  <link rel="stylesheet" href="css/bootstrap.min.css"> -->

 
    <!-- Styles -->
    <link rel="stylesheet" href="a.css">
    <style type="text/css">
input[type="radio"] {
    display: none;
}
input[type="radio"]+span {
    display: inline-block;
    width: 18px;
    height: 18px;
    vertical-align: middle;
    border-radius: 50%;
    border: 6px solid #C0C0C0;
    background-color: #ddd;
}
input[type="radio"]:checked+span {
    border: 6px solid #2F4F4F;
    background-color: #F0FFF0;
}
</style>
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
                <div class="top-left-part"><a class="logo" href="self-center/pixel-html/self-center.php"><b><img src="self-center/plugins/images/pixeladmin-logo.png" alt="home" /></b><fond style="font-size:25px">个人中心</fond></a></div>
<!--                 <ul class="nav navbar-top-links navbar-left m-l-20 hidden-xs"> -->
<!--                     <li> -->
<!--                         <form role="search" class="app-search hidden-xs"> -->
<!--                             <input type="text" placeholder="个人中心" class="form-control"> <a href="self-center/pixel-html/self-center.php"><i class="fa fa-search"></i></a> -->
<!--                         </form> -->
<!--                     </li> -->
<!--                 </ul> -->
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <a class="profile-pic" href="#"> <img src="self-center/plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">
                        <?php 
                        $query="select * from Student where sno='{$member_id}'";
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
                        <a href="self-center/pixel-html/self-center.php" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i><span class="hide-menu">消息</span></a>
                    </li>
                    <li>
                        <a href="self-center/pixel-html/information.php" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i><span class="hide-menu">个人信息</span></a>
                    </li>
                    <li>
                        <a href="self-center/pixel-html/homework.php" class="waves-effect"><i class="fa fa-table fa-fw" aria-hidden="true"></i><span class="hide-menu">作业与答疑</span></a>
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
                        <h4 class="page-title">在线完成作业：
                        <?php 
	                        $query="select * from work where wno={$wno}";
	                        $result=execute($link, $query);
	                        while($select=mysqli_fetch_assoc($result)){	                      	  
								$html=<<<A
								作业：[{$select['wname']}]
								<br/><h5>对应&nbsp;&nbsp;{$select['wcourse']}&nbsp;|&nbsp;{$select['wchapter']}<h5>
								<h5>截止时间：&nbsp;&nbsp;{$select['ddl']}</h5>						
A;
								echo $html;												
							}
                      	  ?>
                      	  </h4>
					</div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                    <?php //完成提交按钮
	                    $html=<<<A
	            	                    
	                    <a href="javascript:void(0);" class="submit_btn">
		                    <div class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm waves-effect waves-light">完成提交</div>
	                    </a>
A;
						echo $html;                    
                    ?>
                        <ol class="breadcrumb"><li><a href="self-center/pixel-html/self-center.php"> 退出作答</a></li></ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            
                <!-- row -->
                
                <?php 
	                $sno=(int)$_GET['sno'];
	                $wno=(int)$_GET['wno'];
//所有问题做成一个表单
					$htmlform=<<<htmlf
					<form id="all" action="dowork.php?sno={$sno}&wno={$wno}&grade=404" method='post'>
htmlf;
echo $htmlform;

//题目输出
$query="select * from Question where wno={$wno}";//查找我所有的问题
//$query="select * from SeleWork where sno=2017300000";//查找我的所有作业
$result=execute($link,$query);
$count=0;
$handbutnograde=404;//未提交时为NULL，提交后立即更新为404，表示还未评分
while($question=mysqli_fetch_assoc($result)){
$count++;
$qno=$question['qno'];
	if(!(int)$question['is_select']){//不是选择
	
	$ques=<<<QUES
		<div class="row">
	                    <div class="col-sm-12">
	                        <div class="white-box">
	                            <section id="spinner">   
	                           
	                                <h4><b>第{$count}题：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$question['qscore']}分</b></h4>                
	<!--                                 <div class="alert alert-success"> These icons work great with the <code>fa-spin</code> class. Check out the <a href="" class="alert-link">spinning icons example</a>. </div> -->
	                                	<div class="alert alert-success">{$question['qtitle']} </div>
	                                <div class="row icon-list-demo">
	                             <!-- 这里开始 -->
		                                <div class="col-12 col-lg-12">
			 								<div class="contact-form">								
						                        <textarea name={$qno} placeholder="作答区" rows="3"></textarea>
				      	  	
			                				</div><!-- .contact-form -->
		           				 		</div><!-- .col -->      
	                           		</div>
								
	                            </section>
	                        </div>
	                    </div>
	                </div>
QUES;
			
	echo $ques;
	// <form method="post">
	// <textarea name="content" placeholder="Your Message" rows="4"></textarea>
	// <input type="submit" name="submit" value="发送">
	// </form>
	}else{//选择 需查找具体选项
		$querys="select * from Q_Choose where wno={$wno} and qno={$qno}";//查找我所有的问题
		$results=execute($link,$querys);
		$qchoose=mysqli_fetch_assoc($results);

	$ques=<<<QUES
	<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <section id="spinner">                           
                                 <h4><b>第{$count}题：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$question['qscore']}分</b></h4>
                                <div class="alert alert-success">{$question['qtitle']} </div>
                                <div class="row icon-list-demo">
                                  <div class="col-12 col-lg-12">
                                    <div class="contact-form">	
										<label><input type="radio" name={$qno} value="A" checked="checked" /><span></span>&emsp;A:&ensp;{$qchoose['A']}</label><br/>
    									<label><input type="radio" name={$qno} value="B"/><span></span>&emsp;B:&ensp;{$qchoose['B']}</label><br/>
    									<label><input type="radio" name={$qno} value="C"/><span></span>&emsp;C:&ensp;{$qchoose['C']}</label><br/>
										<label><input type="radio" name={$qno} value="D"/><span></span>&emsp;D:&ensp;{$qchoose['D']}</label><br/>
									</div>							
								</div>
                                </div>
    		
                            </section>
                        </div>
                    </div>
                </div>
QUES;
	echo $ques;
	}
	
}

?>
             </form> 
            </div>
            <!-- /.container-fluid -->
<!--             <footer class="footer text-center"> 2019 &copy; Pixel Admin brought to you by wrappixel - More Templates <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a> </footer> -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="self-center/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="self-center/pixel-html/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="self-center/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="self-center/pixel-html/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="self-center/pixel-html/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="self-center/pixel-html/js/custom.min.js"></script>
    
     <script type="text/javascript">
    $(function(){
        //页面加载完毕后开始执行的事件
        $(".submit_btn").click(function(){
        	$("#all").submit();
        	
    	});
    });
    </script>
    
</body>

</html>
