<?php 
include_once (dirname(__FILE__)."/../../inc/config.inc.php");
include_once '../../inc/mysql.inc.php';
include_once '../../inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);//是否登录
if(!$member_id){
	skip("../../sign-in.php",'error','您未登录！');
}
$me=(int)$_COOKIE['netsec']['sno'];
$myname="select * from Student where sno={$me}";
$myname=execute($link,$myname);
$myname=mysqli_fetch_assoc($myname);
$myname=$myname['name'];

$isteacher=isteacher($link);
if(!$member_id){//未登录
	skip("../../sign-in.php","你没有登录，无法查看！");
	
}else if($isteacher){
	skip("tea_self-center.php","您是老师，将跳转管理页面！");
}
else{//学生
	
}


?>

<?php 

if(isset($_POST['ask'])){
//提交问题
	if($_POST['qatext']==NULL){
		skip_message("homework.php", "问题不得为空！");
	}
	
	 $sno=(int)$_GET['sno'];
// 	 var_dump($_POST['qatext']);
// 	 var_dump($_POST['qaarea']);
// 	 exit();
	 $query="insert into Q_A (sno,qatext,qaarea,qatime)values({$sno},'{$_POST['qatext']}','{$_POST['qaarea']}',now())";
		execute($link,$query);
		if(mysqli_affected_rows($link)==1){
 			skip_message("homework.php", "提交成功，等待老师答疑");
		}
		else{
			
			skip_message("homework.php", "提交失败");
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
    <title>作业页</title>
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
    <!-- 答疑 -->
    <link rel="stylesheet" href="a.css">
    <style type="text/css">
        .talk_con{
             width:98%; 
            height:500px;
            border:1px solid #b0b0b0;
            margin:50px auto 0;
            background:#f9f9f9;
        }
        .talk_show{
            width:98%; 
            height:95%;
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
            background:#a5e6ab;
            border-radius:10px;
            color:#130f0f;
            padding:5px 10px;
        }
        .btalk{
            margin:10px;
            text-align:right;
        }
        .btalk span{
            display:inline-block;
            background:#f7de80;
            border-radius:10px;
            color:#6a4c1e;
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
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="fa fa-bars
"></i></a>
            <div class="top-left-part"><a class="logo" href="self-center.php"><b><img src="../plugins/images/pixeladmin-logo.png" alt="home" /></b><fond style="font-size:25px">个人中心</fond></a></div>
<!--             <ul class="nav navbar-top-links navbar-left m-l-20 hidden-xs"> -->
<!--                     <li> -->
<!--                         <form role="search" class="app-search hidden-xs"> -->
<!--                             <input type="text" placeholder="个人中心" class="form-control"> <a href="self-center.php"><i class="fa fa-search"></i></a> -->
<!--                         </form> -->
<!--                     </li> -->
<!--                 </ul> -->
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <a class="profile-pic" href="#"> <img src="../plugins/images/users/varun.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo $myname?></b> </a>
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
                        <a href="homework.php" class="waves-effect"><i class="fa fa-table fa-fw" aria-hidden="true"></i><span class="hide-menu">作业与答疑</span></a>
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
                        <h4 class="page-title">作业与答疑</h4> </div>
                        <ol class="breadcrumb">
                            <li><a href="../../index.php">首页</a></li>
                            <li><a href="../../sign-out.php">退出</a></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">作业情况</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>NO</th>                                       
                                            <th>章节序号</th>                                            
                                            <th>作业序号</th>
                                            <th>作业名称</th>
                                            <th>对应课程</th>
                                            <th>提交情况</th>
                                            <th>截止时间</th>
                                            <th>老师评分</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                
                                   <?php 
                                    $query="select * from SeleWork where sno={$me}";//查找我的所有作业
                                    $query="select * from SeleWork where sno=2017300000";//查找我的所有作业
                                    $result=execute($link,$query);
                                    $count=0;
                                   
                                    $nograde=404;//未提交时为NULL，提交后立即更新为404，表示还未评分
                                    while($data=mysqli_fetch_assoc($result)){
                                    	$count++;    
                                    	$thistime=(new \DateTime())->format('Y-m-d H:i:s');
                                    
                                    	$sql_count2="select * from work where wno={$data['wno']}";//查找这些作业的具体信息
                                    	
                                    	$result2=execute($link,$sql_count2);
                                    	while($data2=mysqli_fetch_assoc($result2)){
                                    		//grade=NULL表示没有提交  404表示提交了但还没有评分   0-100表示已经评分  -1表示要去做
                                    		 if($data['grade']==$nograde){//提交但没有成绩 -过了ddl不能改，没过可以改
                                    			if($data2['ddl']<$thistime){//不能更改
		                                    		$html=<<<Attt
													<tr>
													<td>{$count}</td>
													<td>{$data2['wchapter']}</td>
													<td>{$data2['wno']}</td>
													<td>{$data2['wname']}</td>
													<td>{$data2['wcourse']}</td>
													<td>已提交&emsp;|&emsp;<a href="../../seework.php?wno={$data['wno']}&sno={$member_id}">查看</a></td>
	    											<td>{$data2['ddl']}(已截止)</td>
													<td>等待老师批阅</td>
													</tr>
Attt;
		                                    	}
		                                    	else{//可以更改
$html=<<<Attt
													<tr>
													<td>{$count}</td>
													<td>{$data2['wchapter']}</td>
													<td>{$data2['wno']}</td>
													<td>{$data2['wname']}</td>
													<td>{$data2['wcourse']}</td>
													<td>已提交&emsp;|&emsp;
													<a href="../../seework.php?wno={$data['wno']}&sno={$member_id}">查看或更改</a>
													</td>
	    											<td>{$data2['ddl']}</td>
													<td>等待老师批阅</td>
													</tr>
Attt;
												}

		                                    		
                                    		}else if($data['grade']){//提交且有成绩  只能查看
                     
                                    			$html=<<<Aqqq
												<tr>
												<td>{$count}</td>
												<td>{$data2['wchapter']}</td>
												<td>{$data2['wno']}</td>
												<td>{$data2['wname']}</td>
												<td>{$data2['wcourse']}</td>
												<td>已提交&emsp;|&emsp;<a href="../../seework.php?wno={$data['wno']}&sno={$member_id}">查看</a></td>
												<td>{$data2['ddl']}(已截止)</td>
												<td>{$data['grade']}</td>
												</tr>
Aqqq;
                              	                                    			
                                    		}
                                    		else{//未提交 GET方法
                 								if($data2['ddl']<$thistime){//如果时间截至
													
													

	$html=<<<Attt
													<tr>
													<td>{$count}</td>
													<td>{$data2['wchapter']}</td>
													<td>{$data2['wno']}</td>
													<td>{$data2['wname']}</td>
													<td>{$data2['wcourse']}</td>
													<td>未完成</td>
													<td>{$data2['ddl']}(已截止)</td>            									
	            									<td>{$data['grade']}</td>
													</tr>
Attt;
												}else{//时间没有截止
													//grade为-1表示正在做的状态
	                                    			$html=<<<Aeee
													<tr>
													<td>{$count}</td>
													<td>{$data2['wchapter']}</td>
													<td>{$data2['wno']}</td>
													<td>{$data2['wname']}</td>
													<td>{$data2['wcourse']}</td>
													<!--改固定内容-->
													<td><a href="../../dowork.php?wno={$data['wno']}&sno={$member_id}&grade=-1">点击去完成</a></td>
													<td>{$data2['ddl']}</td>
	            									<td>还未提交</td>
													</tr>
Aeee;
                                    			}
                                    		}
                                    		echo $html;
                                    	}
                                    	
                                    	
                                    }
                                  
                                    
                                    
                                    
                                    ?>
                                    
                                    
                                    
                                    
                                    
<!--                                         <tr> -->
<!--                                             <td>1</td> -->
<!--                                             <td>Deshmukh</td> -->
<!--                                             <td>Prohaska</td> -->
<!--                                             <td>@Genelia</td> -->
<!--                                             <td>admin</td> -->
<!--                                         </tr> -->
<!--                                         <tr> -->
<!--                                             <td>2</td> -->
<!--                                             <td>Deshmukh</td> -->
<!--                                             <td>Gaylord</td> -->
<!--                                             <td>@Ritesh</td> -->
<!--                                             <td>member</td> -->
<!--                                         </tr> -->
<!--                                         <tr> -->
<!--                                             <td>3</td> -->
<!--                                             <td>Sanghani</td> -->
<!--                                             <td>Gusikowski</td> -->
<!--                                             <td>@Govinda</td> -->
<!--                                             <td>developer</td> -->
<!--                                         </tr> -->
<!--                                         <tr> -->
<!--                                             <td>4</td> -->
<!--                                             <td>Roshan</td> -->
<!--                                             <td>Rogahn</td> -->
<!--                                             <td>@Hritik</td> -->
<!--                                             <td>supporter</td> -->
<!--                                         </tr> -->
<!--                                         <tr> -->
<!--                                             <td>5</td> -->
<!--                                             <td>Joshi</td> -->
<!--                                             <td>Hickle</td> -->
<!--                                             <td>@Maruti</td> -->
<!--                                             <td>member</td> -->
<!--                                         </tr> -->
<!--                                         <tr> -->
<!--                                             <td>6</td> -->
<!--                                             <td>Nigam</td> -->
<!--                                             <td>Eichmann</td> -->
<!--                                             <td>@Sonu</td> -->
<!--                                             <td>supporter</td> -->
<!--                                         </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">老师答疑</h3>
                            <div class="table-responsive">
                            
                            
                             <div class="talk_con">
        						<div class="talk_show" id="words">
        						<?php 
        						$q1="select * from Q_A where sno={$member_id} order by qatime";
        						$result1=execute($link,$q1);
        						while($data1=mysqli_fetch_assoc($result1)){
        							
									if(!$data1['qateacher']){//没有回答  右边
										$htmlask=<<<ask
										<div class="btalk"><span id="bsay">问[{$data1['qaarea']}][#{$data1['qano']}]：{$data1['qatext']}</span></div>
										
ask;
										echo $htmlask;
									}
									else{//已经回答了 出现在左边
										$htmljieda=<<<jieda
										<div class="btalk"><span id="bsay">问[{$data1['qaarea']}][#{$data1['qano']}]：{$data1['qatext']}</span></div>
										<div class="atalk"><span id="asay">{$data1['qateacher']}老师回答[{$data1['qaarea']}][#{$data1['qano']}]：{$data1['qanswer']}</span></div>		
jieda;
										echo $htmljieda;
									}
        						}
        						?>
        						

        						</div>
        						<div class="talk_input">
<!--             						<select class="whotalk" id="who"> -->
<!-- 					                	<option value="0">A说：</option> -->
<!-- 					                	<option value="1">B说：</option> -->
<!-- 					           		</select> -->
        						
<!--             						<input type="text" class="talk_word" id="talkwords"> -->
<!--             						<input type="button" value="发送" class="talk_sub" id="talksub"> -->
       							 </div>
    						</div>
    							<div class='comment-center'><div class='col-lg-12 col-md-12 col-sm-12'><div class='contact-form'>
        						<form action="homework.php?sno=<?php echo $member_id;?>" method='post'>
        							<div class='update_textarea'>
        								<textarea name='qatext' cols='105' rows='5'></textarea><br/><br/><br/>
        								&emsp;&emsp;<label><input type="radio" name="qaarea" value="理论" checked="checked" /><span></span>&emsp;A:&ensp;理论</label>
    									<label><input type="radio" name="qaarea" value="实验"/><span></span>&emsp;B:&ensp;实验</label><br/>
        								<input type='submit' name='ask' value='发送问题' />
        							</div>
        						</form>
        						</div></div></div>
    							
    							
                            </div>
                        </div>
                    </div>
                </div>
                            
                
                
                
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
    
    
    
    
</body>

</html>
