# 网页记事本增强版（web-notepad-enhanced）
  [English introduction](https://github.com/jocksliu/web-notepad-enhanced/blob/main/README-English.md)（English）|   中文说明（Chinese）<br />本项目是基于minimalist-web-notepad项目的代码进行二次增强开发。<br />（This project is based on the code of the minimalist-web-notepad project for secondary enhancement development.） 
**原项目地址（Original project address）：**<br />https://github.com/pereorga/minimalist-web-notepad 原项目作者 pereorga<br />据作者README介绍，minimalist-web-notepad项目也是基于另外一个目前已不存在的项目 notepad.cc进行克隆开发。

## 本项目截图
![ocr_20230925235125.png](https://cdn.nlark.com/yuque/0/2023/png/27433930/1695657090507-3913b736-5167-4108-845c-91c63042e575.png#averageHue=%23f3f3f3&clientId=ueeba5647-94c9-4&from=paste&height=955&id=BKGJ0&originHeight=955&originWidth=1040&originalType=binary&ratio=1&rotation=0&showTitle=false&size=65833&status=done&style=none&taskId=uab89d637-9aef-41fc-9f50-131d8e71f04&title=&width=1040) 

## **功能特性（functional characteristics）**

**本项目地址：**[https://github.com/jocksliu/web-notepad-enhanced](https://github.com/jocksliu/web-notepad-enhanced)<br />**在线Dome：**[https://itdog.in](https://itdog.in)

**【界面功能】**<br />基本功能：你的互联网记事本，可以在不同设备中免应用进行文本、图片、文件传输，只需要一个浏览器。<br />笔记：顾名思义，就是单纯的记事本，没有富文本等功能，只是文字记录的一个笔记，您在这里输入的内容将实时保存（除非你的wangl）。<br />图册：用于上传共享一些图片，演示密码 Admin，当前Dome空间有限，目前策略为最大200K一张图。<br />文件：用于上传共享一些文件，演示密码 Admin，当前Dome空间有限，目前策略为最大1MB一个文件。

**浏览器URL：**<br />在URL上，输入任意文本，将自动创建一个你知道的文本笔记，如 [http://itdog.in/README](http://itdog.in/README)，这里的README是我手动在地址栏里写入的，你可以写入123或者其他想要起的笔记本地址ID

**笔记本列表：**<br />左侧栏为笔记列表，这里记录本站所有的笔记，你可以点击打开查看，这个也算区分与原基础项目的主要功能<br />当面左侧菜单的命名规则为：笔记本地址+截取首行10个字符为标题

**随机建一个：**<br />随机建个文档，文档地址规则为SJ-XXX，其中XXX是三位随机数

**刷新/保存：**<br />该按钮主要用于刷新文档，由于笔记本实时保存，其实没有主动保存的功能，只有刷新，为了安慰作者的一些保存系统，特地加了该功能，你也可以使用CTRL+S进行触发。

**收起/展开：**<br />这个功能主要为手机版而开发，由于手机的屏幕太小，默认左侧菜单会挤压主要输入区，当手机打开的时候默认收起，可以点击展开进行选择笔记。

**【其他功能】**<br />1、在笔记页面,双击改行会自动出发网页Copy到剪切板的JS脚本，你在任意行双击，该行内容就已经自动复制到剪切板了，可以直接CTRL+V进行粘贴。(注释：必须SSL部署后才生效)<br />2、图册上传的“粘贴板”功能，可以是一张图片，或者临时的微信QQ截图，直接粘贴到粘贴板即可。<br />3、文件页面的显示二维码功能，可以帮助你快速生成二维码进行手机下载。<br />4、关于本文档变灰只读，您只需要在后台_TMP文件中将该文本设置成只读即可。

**================【特别注意 （attention）】================**<br />1、本项目的图片、文件共享中，上传的加密密码的代码逻辑比较简单，请注意闲置服务器的空间容量，不要存储重要文件。 <br />2、本项目代码中，笔记的读写是公共可读写，请不要存放重要内容，该笔记设计的初衷是只是为了临时传输文本和文件，解决跨设备的问题。 <br />====================================================

## 安装（Installation） 
本项目依赖Apache或者Nginx+PHP环境，请自行在服务器上部署对应的环境，默认主机空间和宝塔基本环境以及常用的网站环境都能满足要求。

**步骤大纲（outline）：**<br />1、在Github上下载本项目代码<br />2、修改项目代码，把代码中的域名改成自己的域名<br />3、将代码上传到自己的主机空间或者服务器网站目录<br />4、简单配置网站环境变量，如nginx的伪静态或者Apache的mod_rewrite模块等<br />5、[可选]为你的域名网站申请一个SSL，当仅使用http直接部署的时候，可能会缺失部分功能，比如双击复制

### 详细部署教程（detailed steps）
**1、克隆或者下载项目代码到你的本地**
```
git clone https://github.com/jocksliu/web-notepad-enhanced.git
```
或者<br />直接在Github项目页面中点击Code按钮，选择Download ZIP进行源代码下载。

**2、修改项目代码（填写您的域名或者IP）**<br />将项目代码解压，找到以下三个文件，用记事本或者代码编辑器打开修改文件内容。<br />index.php<br />png.php<br />file.php<br />以下变量都在文件最开始的几行代码中，打开即可看到。将三个文件的$base_url后面的变量改成你自己的域名。<br />域名的解析不在本项目教程范围内，需要自己配置。如果无域名，可以直接配置成【http://IP地址】进行部署。
```bash
$base_url = 'http://itdog.in';
改成
$base_url = 'https://你的域名';
//默认http，如果使用了SSL，则需要使用https
```

**3、上传代码到网站根目录，确保配置。**<br />将修改好的代码全部上传到你的网站目录，然后确保一下配置正确，建议打包成zip后再上传解压。<br />以下配置大部分的主机空间和服务器环境都不需要专门配置，只需要检查即可。如有异常，请自行修改。

- 确保你的主页文件设置为index.php
- 确保本项目中的_tmp、_png、sharefile这三个文件夹可读可写

**4、网站的环境变量**<br />**Nginx：**<br />如果你的网站使用的是nginx，请在伪静态配置里写入
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

**Apache：**<br />如果你使用的是Apache，默认配置即可，<br />如有异常，需要确保在站点配置中启用mod_rewrite并设置.htaccess文件。参见如何为Apache设置mod_rewrite。[How To Set Up mod_rewrite for Apache](https://www.digitalocean.com/community/tutorials/how-to-set-up-mod_rewrite-for-apache-on-ubuntu-14-04).

## 许可证（licence）
```
版权所有者：Jocksliu
Apache许可证 2.0（Apache License, Version 2.0）
除非另有明确说明，否则 [web-notepad-enhanced] 的源代码和文档使用 Apache License, Version 2.0 许可证授权。
有关详细信息，请访问 http://www.apache.org/licenses/LICENSE-2.0。
```

## 谢鸣（Acknowledgements）:
原作者： pereorga<br />原项目：https://github.com/pereorga/minimalist-web-notepad
