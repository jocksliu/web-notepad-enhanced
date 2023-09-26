# web-notepad-enhanced
英文说明（English）|   [中文说明](https://github.com/jocksliu/web-notepad-enhanced/blob/main/README.md)（Chinese）<br />（This project is based on the code of the minimalist-web-notepad project for secondary enhancement development.）<br />Original project address：<br />https://github.com/pereorga/minimalist-web-notepad |  Original project author： pereorga

According to the author README, the minimalist-web-notepad project is also based on another now-defunct project notepad.cc clone development.

## Screenshot of this project
![ocr_20230925235125.png](https://cdn.nlark.com/yuque/0/2023/png/27433930/1695657090507-3913b736-5167-4108-845c-91c63042e575.png#averageHue=%23f3f3f3&clientId=ueeba5647-94c9-4&from=paste&height=955&id=BKGJ0&originHeight=955&originWidth=1040&originalType=binary&ratio=1&rotation=0&showTitle=false&size=65833&status=done&style=none&taskId=uab89d637-9aef-41fc-9f50-131d8e71f04&title=&width=1040)

## **functional characteristics**

**Address of this item：**[https://github.com/jocksliu/web-notepad-enhanced](https://github.com/jocksliu/web-notepad-enhanced)<br />**Dome：**[https://itdog.in](https://itdog.in)

**【Interface function】**<br />**Basic functions: **Your Internet notepad, which can transfer text, pictures, and files between different devices without application, only requires a browser.

**笔记（Notes）:** As the name suggests, it is simply a notepad, without features such as rich text, just a note for written records, and what you type here will be saved in real time (unless your network is terrible).

**图册（Image book）: **Used to upload and share some pictures, demo password Admin, the current Dome space is limited, the current policy is a maximum of 200K a picture.

**文件（File）:** Used to upload and share some files, demo password Admin, the current Dome space is limited, the current policy is a maximum of 1MB file.

**Browser URL：**<br />At the URL, type any text and it will automatically create a text note you know, such as [http://itdog.in/README.](http://itdog.in/README.) The README here is what I manually wrote in the address bar. You can write “123” or whatever notebook address ID you want

**Notebook list：**<br />Left column for the list of notes, here to record all the notes of the site, you can click to open to view, this is also the main function of distinguishing from the original basic project

The naming rule of the menu on the left side of the face is: notebook address + cut the first line 10 characters as the title

**随机建一个（Randomly build one）：**<br />Create a document randomly. The document address rule is SJ-XXX, where XXX is a three-digit random number

**刷新/保存（Refresh/save）：**<br />This button is mainly used to refresh the document, because the notebook is saved in real time, in fact, there is no active save function, only refresh, in order to comfort some of the author's saving system, specially added this function, you can also use CTRL+S to trigger.

**收起/展开（Collapse/unfold）：**<br />This function is mainly developed for the mobile version. Due to the small screen of the mobile phone, the left menu will squeeze the main input area by default. When the mobile phone is opened, it will be folded by default.

**【other functions】**<br />1, in the note page, double-click the change line will automatically start the page Copy to the clipboard JS script, you double-click in any line, the content of the line has been automatically copied to the clipboard, you can directly CTRL+V paste. (Note: This takes effect only after SSL is deployed)

2. The "paste board" function of the album upload can be a picture or a temporary wechat QQ screenshot, which can be pasted directly to the paste board.

3, the file page display two-dimensional code function, can help you quickly generate two-dimensional code for mobile download.

4. For this document to become read-only, you only need to set the text to read-only in the background _TMP file.

**特别注意 （attention）**<br />**1. In the picture and file sharing of this project, the code logic of the uploaded encryption password is relatively simple. Please pay attention to the space capacity of the idle server and do not store important files.**

**2. In the code of this project, the reading and writing of notes are public, so please do not store important content. The original intention of the note design is only to temporarily transfer text and files to solve cross-device problems.**

## 安装（Installation）
This project depends on Apache or Nginx+PHP environment, please deploy the corresponding environment on the server, the default host space, the basic environment of the pagoda and the common website environment can meet the requirements.

**步骤大纲（outline）：**<br />1. Download the project code on Github<br />2. Modify the project code and change the domain name in the code to your own domain name<br />3. Upload the code to your own host space or server website directory<br />4. Simple configuration of website environment variables, such as pseudo-static nginx or mod_rewrite module of Apache<br />5, [Optional] For your domain website to apply for an SSL, when only using http directly deployed, may be missing some features, such as double click copy

### detailed steps
**1、Clone or download the project code to your local location**
```
git clone https://github.com/jocksliu/web-notepad-enhanced.git
```
OR<br />Directly on the Github project page, click the Code button and select Download ZIP to download the source code.

**2、Modify the project code (fill in your domain name or IP）**<br />Unzip the project code, find the following three files, open with Notepad or code editor to modify the file content.
```bash
index.php
png.php
file.php
```
The following variables are in the first few lines of code in the file, open to see. Change the variables after the $base_url of the three files to your own domain name.<br />Domain name resolution is not within the scope of this project tutorial, you need to configure yourself. If no domain name is available, you can configure it as [http://IP address] for deployment.
```bash
$base_url = 'http://itdog.in';
改成
$base_url = 'https://你的域名';
//默认http，如果使用了SSL，则需要使用https
```

**3、Upload the code to the site root directory to ensure configuration.**<br />Upload all the modified code to your website directory, and then make sure that the configuration is correct, it is recommended to package into zip and then upload and decompress.<br />Most of the host space and server environments do not need to be configured. You only need to check them. If any exception occurs, modify it yourself.

- Make sure your home page file is set to index.php
- Make sure the _tmp, _png, sharefile folders in this project are readable and writable

**4、Environmental variables for the site**<br />**Nginx：**<br />If your website uses nginx, please write in the pseudo-static configuration
```
location / {
    rewrite ^/([a-zA-Z0-9_-]+)$ /index.php?note=$1;
}
```
If your site is not in the root directory, the pseudo-static content should be changed according to your own situation, for example
```
location ~* ^/notes/([a-zA-Z0-9_-]+)$ {
    try_files $uri /notes/index.php?note=$1;
}
```

**Apache：**<br />If you are using Apache, the default configuration is fine.<br />If an exception occurs, ensure that mod_rewrite is enabled in the site configuration and the.htaccess file is configured. See How Do I Set up for Apachemod_rewrite。[How To Set Up mod_rewrite for Apache](https://www.digitalocean.com/community/tutorials/how-to-set-up-mod_rewrite-for-apache-on-ubuntu-14-04).

## 许可证（licence）
```
Copyright holder: Jocksliu

Apache License 2.0 (Apache License, Version 2.0)
Unless explicitly stated otherwise, the source code and documentation for [web-notepad-enhanced] is licensed under the Apache License, Version 2.0 license.
For more information, please visit http://www.apache.org/licenses/LICENSE-2.0.

Author blog：https://jocksliu.com
```

## 谢鸣（Acknowledgements）:
Original author: pereorga<br />The original project: [https://github.com/pereorga/minimalist-web-notepad](https://github.com/pereorga/minimalist-web-notepad)
