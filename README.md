# 网页记事本增强版（web-notepad-enhanced）
  [English introduction](https://github.com/jocksliu/web-notepad-enhanced/blob/main/README-English.md)（English）|   中文说明（Chinese）<br />
    -------------------------------------------------------------<br />
  本项目是基于minimalist-web-notepad项目的代码进行二次开发,包含简单txt笔记本、共享文件、图片共享几个功能，你可以将它作为跨设备数据交换的解决方案<br />（This project is based on the code of the minimalist-web-notepad project for secondary enhancement development.） 

原项目地址（Original project address）：<br />https://github.com/pereorga/minimalist-web-notepad 原项目作者 pereorga<br />据作者README介绍，minimalist-web-notepad项目也是基于另外一个目前已不存在的项目 notepad.cc进行克隆开发。

## 本项目截图
![image](https://github.com/jocksliu/web-notepad-enhanced/assets/94985963/a3861aee-77b3-4236-86e1-8a3f87588d25)

## **功能特性（functional characteristics）**

**本项目地址：**[https://github.com/jocksliu/web-notepad-enhanced](https://github.com/jocksliu/web-notepad-enhanced)<br />**在线Demo：**[https://itdog.in](https://itdog.in)

**【界面功能】**<br />基本功能：你的互联网记事本，可以在不同设备中免应用进行文本、图片、文件传输，只需要一个浏览器。<br />笔记：顾名思义，就是单纯的记事本，没有富文本等功能，只是文字记录的一个笔记，您在这里输入的内容将实时保存（除非你的网络十分卡顿或者不可用）。<br />图册：用于上传共享一些图片。源代码设置为5M一张图<br />文件：用于上传共享一些文件。

**浏览器URL：**<br />在URL上，输入任意文本，将自动创建一个你知道的文本笔记，如 [http://itdog.in/README](http://itdog.in/README)，这里的README是我手动在地址栏里写入的，你可以写入123或者其他想要起的笔记本地址ID

**笔记本列表：**<br />左侧栏为笔记列表，这里记录本站所有的笔记，你可以点击打开查看，这个也算区分与原基础项目的主要功能<br />当面左侧菜单的命名规则为：笔记本地址+截取首行10个字符为标题

**随机建一个：**<br />随机建个文档，文档地址规则为XXX，其中XXX是三位随机数

**刷新/保存：**<br />该按钮主要用于刷新文档，由于笔记本实时保存，其实没有主动保存的功能，只有刷新，为了安慰作者的一些保存系统，特地加了该功能，你也可以使用CTRL+S进行触发。

**【其他功能】**<br />1、在笔记页面,双击改行会自动出发网页Copy到剪切板的JS脚本，你在任意行双击，该行内容就已经自动复制到剪切板了，可以直接CTRL+V进行粘贴。(注释：必须SSL部署后才生效)<br />2、图册上传的“粘贴板”功能，可以是一张图片，或者临时的微信QQ截图，直接粘贴到粘贴板即可。<br />3、文件页面的显示二维码功能，可以帮助你快速生成二维码进行手机下载。<br />4、关于本文档变灰只读，您只需要在后台_TMP文件中将该文本设置成只读即可。

**================【特别注意 （attention）】================**<br />1、本项目的图片、文件共享中，上传的加密密码的代码逻辑比较简单，请注意限制服务器的空间容量，并且不要存储重要机密文件。 <br />2、本项目代码中，笔记的读写是公共可读写，请不要存放重要敏感内容，该笔记设计的初衷是只是为了临时传输文本和文件，解决跨设备的问题。 <br />====================================================

## 安装（Installation） 
本项目依赖Apache或者Nginx+PHP环境，请自行在服务器上部署对应的环境，默认主机空间和宝塔基本环境以及常用的网站环境都能满足要求。
为避免可能的错误，建议PHP7.2

**步骤一：下载代码**
使用以下命令下载，或者直接网页都可以下载。

```
git clone https://github.com/jocksliu/web-notepad-enhanced.git
```

**步骤二：修改域名或IP**<br />
解压下载好的代码
找到index.php文件，编辑该文件，在第14行把$base_url后面的值改成你自己部署的域名，或者直接写IP地址
比如：$base_url = 'http://itdog.in';  或者 $base_url = 'http://192.168.1.1';

找到file.php文件，编辑该文件，在第8行把$base_url后面的值改成你自己部署的域名，或者直接写IP地址
比如：$base_url = 'http://itdog.in';  或者 $base_url = 'http://192.168.1.1';

**步骤三：上传代码到空间或者服务器**<br />
将代码上传到你需要部署的空间或者服务器

**步骤四：修改Nginx伪静态**<br />
在网站的Nginx伪静态中写入规则
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

**Apache：**<br />如果你使用的是Apache，默认配置即可。

## 许可证（licence）
```
版权所有者：Jocksliu
Apache许可证 2.0（Apache License, Version 2.0）
除非另有明确说明，否则 [web-notepad-enhanced] 的源代码和文档使用 Apache License, Version 2.0 许可证授权。
有关详细信息，请访问 http://www.apache.org/licenses/LICENSE-2.0。
```

## 谢鸣（Acknowledgements）:
原作者： pereorga<br />原项目：https://github.com/pereorga/minimalist-web-notepad
