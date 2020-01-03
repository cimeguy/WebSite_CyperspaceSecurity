<?php 
include_once (dirname(__FILE__)."/../../inc/config.inc.php");
include_once '../../inc/mysql.inc.php';
include_once '../../inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);//是否登录

if(!$member_id){
	skip_message('../../index.php', '您未登录！');
}


//caozuo变量2表示删除 1表示更改
$me=(int)$_COOKIE['netsec']['sno'];
$sql_count="select count(*) from Talk where sno={$me}";//评论数 
$comment=num($link, $sql_count);
$sql_count="select count(*) from Talk ";//所有评论数 
$commentall=num($link, $sql_count);
if($commentall!=0){
$commentpercent=round(($comment/$commentall)*100).'%';//评论率
}
else{
	$commentpercent='0%';
}
$sql_count="select count(*) from SeleWork where sno={$me}";//作业总数
$selework=num($link, $sql_count);
$nograde=404;//未提交时为NULL，提交后立即更新为404，表示还未评分
$sql_count="select count(*) from SeleWork where sno={$me} and grade!=''";//提交作业数
$donework=num($link, $sql_count);
if($selework!=0){
	$workdonepercent=round(($donework/$selework)*100).'%';
}
else{
	$workdonepercent='0%';
}
?>
<?php //删除操作
if(isset($_GET['caozuo']) &&isset($_GET['tno'])&& isset($_GET['cno'])){
    if($_GET['caozuo']=='2'){
        $tno=(int)$_GET['tno'];
        $cno=(int)$_GET['cno'];

        $query="DELETE from Talk WHERE tno={$tno} and cno={$cno}";
        $result=execute($link, $query);
        if(mysqli_affected_rows($link)==1){
            skip_message('self-center.php', '删除成功！');
        }
        else{
            skip_message('self-center.php', '删除失败！');
        }
    }
    else{
	}
}
?>
<?php 

if(isset($_POST['update'])){//更改内容操作
	$tno=(int)$_GET['tno'];
	$cno=(int)$_GET['cno'];
	$thistime=(new \DateTime())->format('Y-m-d H:i:s');//无用 sql用now()函数更好
	$query="update Talk set text='{$_POST['updatetext']}',ttime=now() where tno={$tno} and cno={$cno}";
	$result=execute($link, $query);
	if(mysqli_affected_rows($link)==1){
	skip_message('self-center.php', '更改成功！');
	}
	else{
	skip_message('self-center.php', '更改失败！');
	}
}

?>
<?php 
//答疑情况
$qaok=0;
$qanotok=0;
$qa="select * from Q_A where sno={$member_id} order by qatime";
$resultqa=execute($link,$qa);
while($dataqa=mysqli_fetch_assoc($resultqa)){
	 
	if(!$dataqa['qateacher']){//没有回答
		$qanotok++;
	}
	else{//已经回答了
		$qaok++;
	}
}
$qaall=$qaok+$qanotok;
if($qaall!=0){
	$qapercent=round(($qaok/$qaall)*100).'%';//评论率
}
else{
	$qapercent='0%';
}

?>

<?php 

if(isset($_POST['submit'])){//回复
	
	$q1="select * from Talk where tno={$_GET['tno']} order by cno desc";//按tno分组取出每组最大的
	$result1=execute($link,$q1);
	//有问题
	
	if($data1=mysqli_fetch_assoc($result1)){//取一条
		
			$count=$data1['cno']+1;//记录现在多少层了
			
			//$query="insert into talk(tno,cno,sno,text,tarea,ttime，reno)values({$_GET['tno']},{$count},{$me},'{$_POST['replytext']}','{$_GET['tarea']}',now(),{$_GET['cno']})";
			$query="insert into talk(tno,cno,sno,text,tarea,ttime,reno)values({$_GET['tno']},{$count},{$me},'{$_POST['replytext']}','{$_GET['tarea']}',now(),{$_GET['cno']})";
			execute($link,$query);
			if(mysqli_affected_rows($link)==1){
				skip_message('self-center.php', '回复成功！');
			}else{
				skip_message('self-center.php', '回复失败！');
			}
	}
	else{
		skip_message('self-center.php', '该回复已不存在');

	}

}

?>
<?php
//寻找回复我的人
$numreply=0;
$query1="select * from Talk where sno='{$member_id}'";//找出我的talk
$result1=execute($link,$query1);
if(num($link,$query1)==0){//没有发言
	$numreply=0;
}else{//我有发帖
	while ($data1=mysqli_fetch_assoc($result1)){
		$query2="select count(*) from Talk where reno='{$data1['cno']}' and tno='{$data1['tno']}'";//找出回复我的层
		$numreply+=num($link,$query2);

	}
}

$htmltitle=<<<A
                        <h3 class="box-title">你有{$numreply}条消息，单击回复、双击跳转查看详情页：</h3>
                         <div class="message-center">
A;
if($commentall!=0){
	$numreplypercent=round(($numreply/$commentall)*100).'%';//回复率
}
else{
	$numreplypercent='0%';
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
    <title>个人中心</title>
    <!-- Bootstrap Core CSS -->
    <link href="./bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="../plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="../plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="./css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="./css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="./css/colors/blue-dark.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" href="a.css">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.js"></script>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    
    <style type="text/css">
        .talk_con{
            width:600px;
            height:500px;
            border:1px solid #ddd;
            margin:50px auto 0;
            background:#f7f7f7;
        }
        .talk_show{
            width:580px;
            height:420px;
            border:1px solid #ddd;
            background:#fff;
            margin:10px auto 0;
            overflow:auto;
        }
        .talk_input{
            width:580px;
            margin:10px auto 0;
        }
        .whotalk{
            width:80px;
            height:30px;
            float:left;
            outline:none;
        }
        .talk_word{
            width:420px;
            height:26px;
            padding:0px;
            float:left;
            margin-left:10px;
            outline:none;
            text-indent:10px;
        }        
        .talk_sub{
            width:56px;
            height:30px;
            float:left;
            margin-left:10px;
        }
        .atalk{
           margin:10px; 
        }
        .atalk span{
            display:inline-block;
            background:#0181cc;
            border-radius:10px;
            color:#fff;
            padding:5px 10px;
        }
        .btalk{
            margin:10px;
            text-align:right;
        }
        .btalk span{
            display:inline-block;
            background:#ef8201;
            border-radius:10px;
            color:#fff;
            padding:5px 10px;
        }
    </style>
    
    
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
<!--                             <input type="text" placeholder="搜索" class="form-control"> <a href="self-center.php"><i class="fa fa-search"></i></a> -->
<!--                         </form> -->
<!--                     </li> -->
<!--                 </ul> -->
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <a class="profile-pic" href="#"> <img src="../plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">
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
                        <a href="self-center.php" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i><span class="hide-menu">消息</span></a>
                    </li>
                    <li>
                        <a href="information.php" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i><span class="hide-menu">个人信息</span></a>
                    </li>
                    <li>
                        <a href="homework.php" class="waves-effect"><i class="fa fa-table fa-fw" aria-hidden="true"></i><span class="hide-menu">作业情况</span></a>
                    </li>
   
                </ul>
                
            </div>
        </div>
        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">消息</h4> </div>
                        <ol class="breadcrumb">
                            <li><a href="../../index.php">首页</a></li>
                            <li><a href="../../sign-out.php">退出</a></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- row -->
               
                <div class="row">
                    <!--col -->
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <div class="col-in row">
                                <div class="col-md-6 col-sm-6 col-xs-6"> <i data-icon="E" class="linea-icon linea-basic"></i>
                                    <h5 class="text-muted vb">发言数</h5> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                
                                    <h3 class="counter text-right m-t-15 text-danger">
                                    <?php echo  $comment ?>
                                    </h3> </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="progress">
                                       <?php 
                                       $html=<<<START
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{$commentpercent}"> <span class="sr-only">40% Complete (success)</span> </div>
START;
                                       echo $html;
                                       ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <!--col -->
                    
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <div class="col-in row">
                                <div class="col-md-6 col-sm-6 col-xs-6"> <i class="linea-icon linea-basic" data-icon="&#xe01b;"></i>
                                    <h5 class="text-muted vb">答疑情况</h5> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h3 class="counter text-right m-t-15 text-megna"><?php echo $qaok ?>/<?php echo $qaall ?></h3> </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="progress">
                                    <?php 
                                       $html=<<<START
                                        <div class="progress-bar progress-bar-megna" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {$qapercent}"> <span class="sr-only">40% Complete (success)</span> </div>
                                    </div>
START;
                                       echo $html;
                                       ?>
                                        
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <!--col -->
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="white-box">
                            <div class="col-in row">
                                <div class="col-md-6 col-sm-6 col-xs-6"> <i class="linea-icon linea-basic" data-icon="&#xe00b;"></i>
                                    <h5 class="text-muted vb">提交作业数/总数</h5> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h3 class="counter text-right m-t-15 text-primary"><?php echo $donework;echo"/";echo $selework?></h3> </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="progress">
                                    <?php 
                                    $html=<<<START
                                     <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:{$workdonepercent}"> <span class="sr-only">40% Complete (success)</span> </div>
                                    </div>
START;
                                    echo $html;
                                    ?>
                                       
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!--row -->
  
                <!--row -->

                <!-- /.row -->
          
                <!-- row -->
                <div class="row">
                    <div class="col-md-12 col-lg-6 col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">最近发言，单击更改，双击跳转查看详情</h3>  
                           	<div class="comment-center">
                            <?php //寻找所有我回复的人和消息 我的发帖
                                $query1="select * from Talk where sno='{$_COOKIE['netsec']['sno']}'order by ttime desc";//找出我的所有talk
                                $result1=execute($link,$query1);
                                if(num($link,$query1)==0){//我没有发帖，也没有评论
                                    $html=<<<A
                                    <div class="comment-body">
                                        <div class="mail-contnet">
                                        <h5>你没有发言……</h5> <span class="mail-desc"></span><a href="javacript:void(0)" class="action"><i class="ti-close text-danger"></i></a> <a href="javacript:void(0)" class="action"><i class="ti-check text-success"></i></a><span class="time pull-left"></span></div>
                                    </div>
A;

	                                echo $html;
                                }else{
                                    while ($data1=mysqli_fetch_assoc($result1)){
                                        $query2="select * from Talk where cno='{$data1['reno']}' and tno='{$data1['tno']}'";//找出我talk回复的层
                                        $result2=execute($link,$query2);
                                        if(num($link, $query2)==0){//如果我没有回复别人，但是发帖了或者别人的评论已经删除
                                            
                                            $cno1=(int)$data1['cno'];
											$tno1=(int)$data1['tno'];
                                            if($data1['reno']==0){//我的发言	                                           
	                                            $html=<<<A
	                                            <div class="comment-body">
	                                                <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"></div>
	                                                <div class="mail-contnet">
	                                                 <a href="javascript:void(0);" class="update_btn" v1='{$data1['tno']}' v2='{$data1['cno']}' v3='{$data1['tarea']}'>
	                                                <h5>我发布了：</h5> <span class="mail-desc">{$data1['text']}</span><a href="javacript:void(0)" class="action"><i class="ti-close text-danger"></i></a> <a href="javacript:void(0)" class="action"><i class="ti-check text-success"></i></a>
	                                                </a>
	                                                <span class="time pull-left">{$data1['ttime']}&emsp;<a href="self-center.php?tno={$tno1}&cno={$cno1}&caozuo=2">删除</a></span></div>
	                                            </div>
A;
                                           		 echo $html;
                                            }
                                            else{											
												$html=<<<A
	                                            <div class="comment-body">
	                                                <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"></div>
	                                                <div class="mail-contnet">
	                                               
	                                                <h5>我的回复&nbsp;&nbsp;：</h5><span class="mail-desc">&nbsp;&nbsp;{$data1['text']}</span><span class="mail-desc"><h5>to&nbsp;&nbsp;：</h5>&nbsp;&nbsp;该讨论已删除！回复已删除内容的讨论不得更改。</span><a href="javacript:void(0)" class="action"><i class="ti-close text-danger"></i></a> <a href="javacript:void(0)" class="action"><i class="ti-check text-success"></i></a><span class="time pull-left">{$data1['ttime']}&emsp;<a href="self-center.php?tno={$tno1}&cno={$cno1}&caozuo=2">删除</a></span></div>
	                                            </div>
A;
												echo $html;
											}
                                        }else{//我回复了别人

                                            while ($data2=mysqli_fetch_assoc($result2)){//得到我回复的人的学号$data2['sno']
                                                $query3="select * from Student where sno='{$data2['sno']}'";//找出我回复的人的名字
                                                $result3=execute($link,$query3);
                                                
                                                
                                                while ($data3=mysqli_fetch_assoc($result3)){
                                                    //我的评论、回复
                                                    $cno1=(int)$data1['cno'];
													$tno1=(int)$data1['tno'];
                                                    $html=<<<A
                                                    <div class="comment-body">
                                                        <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"></div>
                                                        <div class="mail-contnet">
                                                        
                                                        
 					
                                                        <a href="javascript:void(0);" class="update_btn" v1='{$data1['tno']}' v2='{$data1['cno']}' v3='{$data1['tarea']}'>
	                                                        <h5>我的回复&nbsp;&nbsp;：</h5>                                            
	                                                        <span class="mail-desc">&nbsp;&nbsp;{$data1['text']}</span>
	                                                        <span class="mail-desc"><h5>to{$data3['name']}：</h5>&nbsp;&nbsp;{$data2['text']}</span>
	                                                        <a href="javacript:void(0)" class="action"><i class="ti-close text-danger"></i></a>
	                                                        <a href="javacript:void(0)" class="action"><i class="ti-check text-success"></i></a>
                                                        </a>
                                                        
                                                        <span class="time pull-left">{$data1['ttime']}&emsp;<a href="self-center.php?tno={$tno1}&cno={$cno1}&caozuo=2">删除</a></span>
            											</div>
                                                    </div>
A;
                                           
                                                    echo $html;
                                                }
                                            }
                                        }
                                    }
                                }

		
?>                          
							</div>                                                        	                    
                        </div>
                    </div>
                    
                    
                    
                    
                    
                   <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="white-box">
<!--                         <h3 class="box-title">你有<?php echo 5;?>条消息，点击回复：</h3>-->
<!--                             <div class="message-center"> -->
                        <?php 
                       
                        echo $htmltitle;
                       

//寻找回复我的人
	$query1="select * from Talk where sno='{$member_id}'";//找出我的talk
	$result1=execute($link,$query1);
	if(num($link,$query1)==0){//没有发言
		$html=<<<A
		<a href="#">	
			<span class="profile-status online pull-right"></span> </div>
			<div class="mail-contnet">
			<h5></h5> <span class="mail-desc"></span> <span class="time"></span> </div>
 		</a>
A;
	echo $html;
	}else{//我有发帖
		while ($data1=mysqli_fetch_assoc($result1)){
			$query2="select * from Talk where reno='{$data1['cno']}' and tno='{$data1['tno']}'";//找出回复我的层
			$result2=execute($link,$query2);
			if(num($link,$query2)==0){//如果没有回复我的人
				//没有回复我的层/人			
				$html=<<<A
		<a href="#">
			<span class="profile-status online pull-right"></span> </div>
			<div class="mail-contnet">
			<h5></h5> <span class="mail-desc"></span> <span class="time"></span> </div>
 		</a>
A;
// 				echo $html;
			}else{//如果有回复我的层
				
				while ($data2=mysqli_fetch_assoc($result2)){//得到回复我的人的学号$data2['sno']
					$query3="select * from Student where sno='{$data2['sno']}'";//找出回复我的人的名字
					$result3=execute($link,$query3);
					while ($data3=mysqli_fetch_assoc($result3)){
		//回复我的人发的内容、回复
		//链接提交回复我的人所在层数和板块数用js
			
			$html=<<<A
			
			<div class="row justify-content-between">
			 <div class=col-lg-12 col-md-12 col-sm-12">
				 <a href="javascript:void(0);" class="reply_btn" myvalue1='{$data2['tno']}' myvalue2='{$data2['cno']}' myvalue3='{$data2['tarea']}'>
 					<div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle"><span class="profile-status online pull-right"></span> </div>
					<div class="mail-contnet">
						<h5>{$data3['name']} &nbsp：</h5><span class="mail-desc">{$data2['text']}</span><span class="time">{$data2['ttime']}</span> 
						
					</div>
 				</a>
			
             </div>
			</div>
			
A;
			 
// 			$html=<<<A
// 			<script>
// 			$(this).parent().append("<div class='comment-center'><div class=col-lg-12 col-md-12 col-sm-12'><div class='contact-form'><form action='information.php?tno={$data['tno']}' method='get'><div class='reply_textarea'><textarea name='replytext' cols='105' rows='5'></textarea><br/><input type='submit' value='回复' /></form></div></div></div></div>");
//  			<script>
// A;
						echo $html;
						
					}
						
				}
			}
		}
	}




?>

                            </div>
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
    <!--Counter js -->
    <script src="../plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="../plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--Morris JavaScript -->
    <script src="../plugins/bower_components/raphael/raphael-min.js"></script>
    <script src="../plugins/bower_components/morrisjs/morris.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="./js/custom.min.js"></script>
    <script src="./js/dashboard1.js"></script>
    <script src="../plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $.toast({
            heading: '欢迎来到个人中心',
            text: '这里你可以他人的评论、作业详情、个人信息',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'info',
            hideAfter: 3500,
            stack: 6
        })
    });
    </script>
    
    
    
    <script type="text/javascript">      
    // 
        window.onload = function(){
            var Words = document.getElementById("words");
            var Who = document.getElementById("who");
            var TalkWords = document.getElementById("talkwords");
            var TalkSub = document.getElementById("talksub");
            

            TalkSub.onclick = function(){
	            //定义空字符串
                var str = "";
                if(TalkWords.value == ""){
	                 // 消息为空时弹窗
                    alert("消息不能为空");
                    return;
                }
                if(Who.value == 0){
	                //如果Who.value为0n那么是 A说
                    str = '<div class="atalk"><span>A说 :' + TalkWords.value +'</span></div>';
                }
                else{
                    str = '<div class="btalk"><span>B说 :' + TalkWords.value +'</span></div>' ;  
                }
                Words.innerHTML = Words.innerHTML + str;
            }
            
        }


        </script>
   <script type="text/javascript">




   
    $(function(){
        //页面加载完毕后开始执行的事件
        $(".reply_btn").click(function(){
        	var n1 = $(this).attr("myvalue1");
        	var n2 = $(this).attr("myvalue2");
        	var n3 = $(this).attr("myvalue3");
            $(".reply_textarea").remove();
            var strend1="<div class='comment-center'><div class=col-lg-12 col-md-12 col-sm-12'><div class='contact-form'><form action='self-center.php?tno="
			var strend1 =strend1.concat(n1);
			var str0="&cno=";
			var strend1=strend1.concat(str0);
			strend1=strend1.concat(n2);
			var str1="&tarea=";
			strend1=strend1.concat(str1);
			strend1=strend1.concat(n3);
			var strend2="' method='post'><div class='reply_textarea'><textarea name='replytext' cols='105' rows='5'></textarea><br/><input type='submit' name='submit' value='回复' /></div></form></div></div></div>";
			var strend =strend1.concat(strend2);
		
            $(this).parent().append(strend);
        });
        $(".reply_btn").dblclick(function(){
            var n1 = $(this).attr("myvalue1");
            html='';
            html+="../../discuss/discuss_detail.php?talk_tno=";
            html+=n1
            window.location.href=html;
        });
        $(".update_btn").click(function(){
        	var n1 = $(this).attr("v1");
        	var n2 = $(this).attr("v2");
        	var n3 = $(this).attr("v3");
        	$(".update_textarea").remove();
            var strend1="<div class='comment-center'><div class=col-lg-12 col-md-12 col-sm-12'><div class='contact-form'><form action='self-center.php?tno="
			var strend1 =strend1.concat(n1);
			var str0="&cno=";
			var strend1=strend1.concat(str0);
			strend1=strend1.concat(n2);
			var str1="&tarea=";
			strend1=strend1.concat(str1);
			strend1=strend1.concat(n3);
			var strend2="' method='post'><div class='update_textarea'><textarea name='updatetext' cols='105' rows='5'></textarea><br/><input type='submit' name='update' value='修改' /></div></form></div></div></div>";
			var strend =strend1.concat(strend2);
            $(this).parent().append(strend);
        });
        $(".update_btn").dblclick(function(){
            var n1 = $(this).attr("v1");
            html='';
            html+="../../discuss/discuss_detail.php?talk_tno=";
            html+=n1
            window.location.href=html;
        });
    });

    </script>
    
</body>

</html>
