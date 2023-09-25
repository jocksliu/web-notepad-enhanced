# 网页记事本增强版（web-notepad-enhanced）

本项目是基于minimalist-web-notepad项目的代码进行二次增强开发。
（This project is based on the code of the minimalist-web-notepad project for secondary enhancement development.）

原项目地址（Original project address）：
https://github.com/pereorga/minimalist-web-notepad 原项目作者 pereorga
据作者README介绍，minimalist-web-notepad项目也是基于另外一个目前已不存在的项目 notepad.cc进行克隆开发。
在线Dome体验：


## 安装（Installation）
本项目依赖Apache或者Nginx+PHP环境
部署安装步骤：
**1、修改项目代码（适配您的域名）**
index.php
png.php
file.php
找到这三个文件，用记事本或者代码编辑器打开，最开始有个变量为 
```bash
$base_url = 'http://itdog.in';
```
将三个文件的$base_url后面的变量改成你自己的域名或者IP

**2、把index.php设为默认主页文件。**
默认空间或者服务已经由此设置，但建议检查是否正确。另外确保本项目中的_tmp、_png、sharefile这三个文件夹可读可写

**3、网站的环境变量**
如果你的网站使用的是nginx，请在伪静态配置里写入
```
location / {
    rewrite ^/([a-zA-Z0-9_-]+)$ /index.php?note=$1;
}
```

如果你的网站不在根目录，则伪静态的内容请根据自己的情况自行更改，例如
```
location ~* ^/notes/([a-zA-Z0-9_-]+)$ {
    try_files $uri /notes/index.php?note=$1;
}
```



如果你使用的是Apache，则确保在站点配置中启用mod_rewrite并设置.htaccess文件。参见如何为Apache设置mod_rewrite。[How To Set Up mod_rewrite for Apache](https://www.digitalocean.com/community/tutorials/how-to-set-up-mod_rewrite-for-apache-on-ubuntu-14-04).



## 许可证
```
版权所有者：Jocksliu
Apache许可证 2.0（Apache License, Version 2.0）
除非另有明确说明，否则 [web-notepad-enhanced] 的源代码和文档使用 Apache License, Version 2.0 许可证授权。
有关详细信息，请访问 http://www.apache.org/licenses/LICENSE-2.0。
```

## 谢鸣:
原作者： pereorga
原项目：https://github.com/pereorga/minimalist-web-notepad
