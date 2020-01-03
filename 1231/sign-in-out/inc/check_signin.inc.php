<?php 
if(empty($_POST['sno'])){
	skip('../sign-in.php', 'error', '学号不得为空！');
}
if(mb_strlen($_POST['sno'])>10){
	skip('../sign-in.php', 'error', '学号长度不要超过10个数字！');
}
if(empty($_POST['pw'])){
	skip('../sign-in.php', 'error', '密码不得为空！');
}
// if(strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){
// 	skip('login.php', 'error','验证码输入错误！');
// }
if(empty($_POST['time']) || is_numeric($_POST['time']) || $_POST['time']>2592000){
	$_POST['time']=2592000;
}
?>