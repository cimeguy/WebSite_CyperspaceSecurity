<?php 
function skip($url,$pic,$message){
$html=<<<A
	<!DOCTYPE html>
	<html lang="zh-CN">
	<head>
	<meta charset="utf-8" />
	<meta http-equiv="refresh" content="2;URL={$url}" />
	<title>正在跳转中</title>
	<link rel="stylesheet" type="text/css" href="style/remind.css" />
	</head>
	<body>
	<div class="notice"><span class="pic {$pic}"></span> {$message} <a href="{$url}">2秒后自动跳转中!</a></div>
	</body>
	</html>
A;
	echo $html;
	exit();
}
function skip_message($url,$message){
	$html=<<<A
	<!DOCTYPE html>
	<html lang="zh-CN">
	<head>
	<meta charset="utf-8" />
	<script>
		alert("{$message}");
	</script>
	<meta http-equiv="refresh" content="0.001;URL={$url}" />
	</body>
	</html>
A;
	echo $html;
	exit();
}
function skip_discuss($url){
$html=<<<A
	<!DOCTYPE html>
	<html lang="zh-CN">
	<head>
	<meta charset="utf-8" />
	<script>
		alert("你的评论已发布！");
	</script>
	<meta http-equiv="refresh" content="0.001;URL={$url}" />
	</body>
	</html>
A;
echo $html;
exit();
}
function skip_empty($url){
$html=<<<A
	<!DOCTYPE html>
	<html lang="zh-CN">
	<head>
	<meta charset="utf-8" />
	<script>
		alert("内容不得为空！");
	</script>
	<meta http-equiv="refresh" content="0.001;URL={$url}" />
	</body>
	</html>
A;
echo $html;
exit();
}
	
//缓存列表名netsec，判断是否登录
function is_login($link){
	if(isset($_COOKIE['netsec']['sno']) && isset($_COOKIE['netsec']['pw'])){
		$query="select * from Student where sno='{$_COOKIE['netsec']['sno']}' and sha1(pw)='{$_COOKIE['netsec']['pw']}'";
		$result=execute($link,$query);
		if(mysqli_num_rows($result)==1){
			return (int)$_COOKIE['netsec']['sno'];//返回int型方便查找
		}
		//老师
		$querytea="select * from Teacher where teano='{$_COOKIE['netsec']['sno']}' and sha1(pw)='{$_COOKIE['netsec']['pw']}'";
		$resulttea=execute($link,$querytea);
		if(mysqli_num_rows($resulttea)==1){
			return (int)$_COOKIE['netsec']['sno'];
		}
		else{
			return false;
		}
	}
	
}
function isteacher($link){
	if(isset($_COOKIE['netsec']['sno']) && isset($_COOKIE['netsec']['pw'])){
		$query="select * from Teacher where teano='{$_COOKIE['netsec']['sno']}' and sha1(pw)='{$_COOKIE['netsec']['pw']}'";
		$result=execute($link,$query);
		if(mysqli_num_rows($result)==1){
			return true;
		}else{
			return false;
		}
	}
	else{
		return false;
	}
}

function check_user($member_id,$content_member_id,$is_manage_login){
	if($member_id==$content_member_id || $is_manage_login){
		return true;
	}else{
		return false;
	}
}
?>

