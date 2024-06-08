# 网页记事本增强版（web-notepad-enhanced）
  [English introduction](https://github.com/jocksliu/web-notepad-enhanced/blob/main/README-English.md)（English）|   中文说明（Chinese）<br />
    -------------------------------------------------------------<br />
  本项目是基于minimalist-web-notepad项目的代码进行二次开发,包含简单txt笔记本、共享文件、图片共享几个功能，你可以将它作为跨设备数据交换的解决方案<br />

## **功能特性（functional characteristics）**

**本项目地址：**[https://github.com/jocksliu/web-notepad-enhanced](https://github.com/jocksliu/web-notepad-enhanced)<br />**在线Demo：**[https://itdog.in](https://itdog.in)

**【主要功能】**<br />**网络笔记本**：基于web互联网的记事本，默认无需登录，网络正常的情况下可以实时保存，集成伪富文本功能，丰富内容表现。<br /><br />**图册**：用于上传共享一些图片。源代码设置为5M一张图<br />**文件**：用于上传共享一些文件。<br />
<br />
URL：<br />每个URL都代表一个笔记，并且是固定的，比如你在https://itdog.in/123 这个地址中回车，会默认创建一个空白文档，你输入内容后，文档自动保存，下次你想访问这个文档的内容直接输入这个地址就可以。<br />
笔记本列表：<br />左侧栏为笔记列表，这里记录本站所有的笔记，你可以点击打开查看，这个也算区分与原基础项目的主要功能<br />当面左侧菜单的命名规则为：笔记本地址+截取首行22个字符为标题<br />
随机建一个：<br />随机建个文档，文档地址规则为XXX，其中XXX是三位随机数.<br />
刷新/保存：<br />该按钮主要用于刷新文档，由于笔记本实时保存，其实没有主动保存的功能，只有刷新，为了作者的一些保存习惯，特地加了该功能，你也可以使用CTRL+S进行触发。<br />
双击复制当前行：<br />当你双击某一行的时候，网站自动将这一行所有内容都复制到剪切板，这一点非常使用用来记录命令或者代码。<br />
Ctrl+点击：<br />当你按下ctrl键点击某一行，如果该行存在URL地址，则会以新窗口打开这个URL。方便快速访问网址。<br />
伪富文本：<br />由于纯文本的内容过于单调，而系统开发的设计初衷就只记录纯文本，为了方便阅读，从V1.1.0开始加入伪富文本功能，实际上就是加入了特定的标识符号来区分不同的文本类型，比如标题、序列、分隔符等。<br />
只读文档：<br />关于本文档变灰只读，您只需要在后台_TMP文件中将该文本设置成只读即可。该功能设计的初衷是为了防止公共读写导致一些说明性的文本丢失。<br />
高级用法：<br />使用curl获取在线文本内容，比如 curl <br />
<br />
图册/文件这两个功能目前并不重点维护，功能略简单。<br />
<br />

## 本项目截图
![image](https://github.com/jocksliu/web-notepad-enhanced/assets/94985963/a3861aee-77b3-4236-86e1-8a3f87588d25)

## ---------------------------安装-（Installation） 
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
```
**Apache：**<br />如果你使用的是Apache，默认配置即可。


**【安全性】**<br />请注意，该系统默认的密码是关闭的，极其不安全，设计的初衷是为了方便快速保存和夸设备共享文本/图片和文件等，目前属于小众软件，不建议用来存储重要信息，如有安全需求可以开放代码中被注释的密码访问功能。但整体系统的安全性较差，未来考虑加入安全性代码设计。<br />
<br />
题外话：作者是一名IT运维人员，在开源这个软件的时候其实也是自用为出发点，目前该系统主要对作者的帮助包括：<br />
1、存储Linux的一些命令，快速复制和粘贴命令。<br />
2、传输一些日志文本，经常需要跨机器排错的网友可能知道，当在Linux排查到一些日志，但需要网上检索或者GPT提问的时候，日志不方便传输到自己的设备上，利用这个网络记事本就非常方便。它除了通过浏览器外，还可以通过curl命令获取到内容和上传文本。<br />
3、启用加密后，存储一些作者的关键信息。比如不重要的密码、机场订阅链接、向日葵等远程软件ID、经常需要访问的域名和下载页面等。<br />
4、配合curl，可以实现在线脚本，终端只需要一条crul我的域名就可以每次都做到获取新脚本来执行，不需要每次都在客户端更新脚本内容。<br />
你们可以参考作者的这些用法，发散自己的思维，看看具体怎么玩。<br />
![image](https://github.com/jocksliu/web-notepad-enhanced/assets/94985963/5268e360-3898-4e22-9b17-c3968016c843)

## 许可证（licence）
```
版权所有者：Jocksliu
Apache许可证 2.0（Apache License, Version 2.0）
除非另有明确说明，否则 [web-notepad-enhanced] 的源代码和文档使用 Apache License, Version 2.0 许可证授权。
有关详细信息，请访问 http://www.apache.org/licenses/LICENSE-2.0。
```

## 谢鸣（Acknowledgements）:
原作者： pereorga<br />原项目：https://github.com/pereorga/minimalist-web-notepad
