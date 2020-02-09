# NetSec_web

#### 介绍
计网实训要求写的一个网络安全课程网站；    
主要课程：网络安全（包含实验和理论模块；     
面向对象：学生、老师；     
代码主体在1231文件夹中，netsec.sql为测试数据库。



#### 软件架构
基于Apache+php+MySQL（可以直接安装wamp）开发。  
搭建网络安全课程专门的学习网站方便学生在线学习和老师完成教学任务。      
网站功能包括：    
1.  登录注册（分学生和老师，老师注册必须输入正确口令（密码）：100100，才可以注册成功，后期可以改密码）    
2.  学生看视频网课、提交作业、同学们讨论发帖、分享资源    
3.  老师在线批改作业、上传课件与视频、发布公告、为学生答疑……

#### 安装教程

1.  安装wamp，注意需要设置php.ini文件，在wamp中可以直接打开：
                     	
	file_uploads = On      
	memory_limit = 128M     
	upload_max_filesize = 200M    
	post_max_size =280M  要比上面的大    
	upload_tmp_dir = "D:/soft/wamp/tmp" 有个找得到的路径就行,这是临时存放文件的路径，用于上传文件
2.  文件下载功能需要开启php_fileinfo扩展，直接wamp-php-php扩展-选中php_fileinfo即可
3.  文件需要放在wamp的安装目录里的www文件下
4.  安装wamp可能会提示打不开，这是电脑缺少了某个文件，按照提示去拷贝下来就可以了

#### 使用说明

1.  MySQL导入netsec.sql数据库
2.  浏览器输入“/localhost/NetSec/1231/index.php”打开即可
