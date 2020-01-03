# NetSec_web

#### 介绍
计网实训要求写的一个网络安全课程网站

#### 软件架构
基于Apache+php+MySQL（可以直接安装wamp）开发。        
搭建网络安全课程专门的学习网站方便学生在线学习和老师完成教学任务。      
网站功能包括登录注册（分学生和老师，老师注册必须输入正确口令（密码）：100100，才可以注册成功，后期可以改密码）、学生看视频网课、提交作业、同学们讨论发帖、分享资源，老师在线批改作业、上传课件与视频、发布公告、为学生答疑……

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

#### 参与贡献

1.  Fork 本仓库
2.  新建 Feat_xxx 分支
3.  提交代码
4.  新建 Pull Request


#### 码云特技

1.  使用 Readme\_XXX.md 来支持不同的语言，例如 Readme\_en.md, Readme\_zh.md
2.  码云官方博客 [blog.gitee.com](https://blog.gitee.com)
3.  你可以 [https://gitee.com/explore](https://gitee.com/explore) 这个地址来了解码云上的优秀开源项目
4.  [GVP](https://gitee.com/gvp) 全称是码云最有价值开源项目，是码云综合评定出的优秀开源项目
5.  码云官方提供的使用手册 [https://gitee.com/help](https://gitee.com/help)
6.  码云封面人物是一档用来展示码云会员风采的栏目 [https://gitee.com/gitee-stars/](https://gitee.com/gitee-stars/)
