<?php 
date_default_timezone_set('Asia/Shanghai');//设置时区
session_start();
header('Content-type:text/html;charset=utf-8');
if(version_compare(PHP_VERSION,'5.4.0')<0){
	exit('您的PHP版本为'.PHP_VERSION.',我们的程序要求是PHP版本不低于5.4.0!');
}
header('Content-type:text/html;charset=utf-8');
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','123456');
define('DB_DATABASE','netsec');
define('DB_PORT',3306);


?>