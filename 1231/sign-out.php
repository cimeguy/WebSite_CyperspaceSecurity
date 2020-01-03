<?php 
include_once './inc/config.inc.php';
include_once './inc/mysql.inc.php';
include_once './inc/tool.inc.php';
$link=connect();
$member_id=is_login($link);
if(!$member_id){
	skip('index.php','error','你没有登录，不需要退出！');
}
setcookie('netsec[sno]','',time()-3600);
setcookie('netsec[pw]','',time()-3600);
skip_message('./index.php','退出成功！');
?>