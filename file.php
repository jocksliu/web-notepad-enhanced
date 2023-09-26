<?php
/* Minimalist Web Notepad | https://github.com/pereorga/minimalist-web-notepad */
/* 网络笔记本增强版! Web Notepad web-notepad-enhanced */
/* https://github.com/jocksliu/web-notepad-enhanced  */
/* 本项目源于原作者pereorga 的项目Minimalist Web Notepad上二次开发而来  本项目作者：jocksliu */
/* 原仓库地址 https://github.com/pereorga/minimalist-web-notepad */
$base_url = 'https://www.muv.cc';

include('qr.php'); 

session_start();

$correct_password = 'Admin';  // 这里设置你想要的密码
$target_dir = "sharefile/";

if (isset($_POST['password']) && $_POST['password'] === $correct_password) {
    $_SESSION['authenticated'] = true;
}

if (isset($_POST['delete']) && isset($_SESSION['authenticated'])) {
    $file_to_delete = $target_dir . $_POST['delete'];
    if (file_exists($file_to_delete)) {
        unlink($file_to_delete);
    }
    exit();  
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['authenticated'])) {
    return;
}

if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["fileToUpload"])) {
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    // 检查文件大小，限制在300MB以下
    if ($_FILES["fileToUpload"]["size"] > 300 * 1024 * 1024) { 
        echo "对不起，您的文件太大。文件大小需要在300MB以下。";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        } else {
            echo "对不起，上传文件时出现错误。";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>临时文件</title>
    <style>
body {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  height: 100vh;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Arial, sans-serif;
}
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        width: 80%;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-top: 50px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
        margin-top: 0;
    }
    table {
        width: 100%;
        margin-top: 20px;
    }
    th, td {
        text-align: left;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }
    #overlay {
        position: fixed;
        display: none;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.5);
        z-index: 2;
        cursor: pointer;
    }
    #qr {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    </style>
</head>
<body>

    <style>
        .breadcrumb {
    list-style: none;
    padding: 10px;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: flex-start; 
    background-color: #f1f1f1;
    border-radius: 5px;
        }

        .breadcrumb li {
            display: inline-block;
            margin: 0 10px;
        }

        .breadcrumb li a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            padding: 5px 10px;
            border-radius: 3px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .breadcrumb li a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .breadcrumb li a:active {
            background-color: #0056b3;
            color: #fff;
        }

        .breadcrumb li a:focus {
            outline: none;
        }

        .floating-notice {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
            font-size: 18px;
            color: red;
        }
    </style>
    <ul class="breadcrumb">
        <li><a href=   <?php $base_url ?>/ >笔记</a></li>
        <li><a href= <?php $base_url ?>/png.php>图册</a></li>
        <li><a href= <?php $base_url ?>"/file.php">文件</a></li>
    </ul>
<div class="container">
    <h2>上传文件</h2>
    <?php if (!isset($_SESSION['authenticated'])): ?>
        <div class="alert alert-warning" role="alert">
            请输入密码以解锁上传功能
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="password" style="font-weight: bold;">密码:</label>
                <input type="password" name="password" id="password" class="form-control" style="width: 200px;">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">解锁上传功能</button>
        </form>
    <?php else: ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="fileToUpload" style="font-weight: bold;">选择文件:</label>
                <input type="file" name="fileToUpload" id="fileToUpload" class="form-control-file">
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">上传文件</button>
        </form>
    <?php endif; ?>
 
    <div class="progress" style="display: none;">
         <div class="progress-title">上传进度：</div>
        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">0%</div>
    </div>

    <h2>文件列表 <button onclick="location.reload()">刷新</button></h2>
<div id="dropzone" ondragover="event.preventDefault()" ondrop="dropHandler(event)">
    <table>
<thead>
    <tr>
        <th>文件名</th>
        <th>修改时间</th>
        <th>大小</th>
        <th>操作</th>
    </tr>
</thead>
        <tbody>
<?php
$files = scandir($target_dir);
foreach ($files as $file) {
    if ($file === '.' or $file === '..') continue;

    $filePath = $target_dir . $file;
    $modTime = date("Y-m-d H:i:s", filemtime($filePath));

    $size = filesize($filePath);
    $size = $size < 1048576 ? round($size / 1024, 2) . ' KB' : round($size / 1048576, 2) . ' MB';

    echo "<tr>
            <td>$file</td>
            <td>$modTime</td>
            <td>$size</td>
            <td>
    <a href='$target_dir$file' download>下载</a>
    <button onclick=\"generateQR('$file')\">二维码</button>
    <button onclick=\"copyLink('$target_dir$file')\">复制链接</button>";
if (isset($_SESSION['authenticated'])) {
    echo "<button onclick=\"confirmDelete('$file')\">删除</button>";
}
echo "</td></tr>";
}
?>
</div>

<div id="overlay" onclick="hideQR()">
    <img id="qr">
</div>

</div>

<script>
function generateQR(file) {
    var url = 'generate_qrcode.php?file=' + file;
    document.getElementById('qr').src = url;
    document.getElementById('overlay').style.display = "block";
}

function hideQR() {
    document.getElementById('overlay').style.display = "none";
}

async function dropHandler(event) {
    event.preventDefault();

    let files = event.dataTransfer.files;
    let formData = new FormData();
    formData.append('fileToUpload', files[0]);

    let response = await fetch('', {
        method: 'POST',
        body: formData
    });

    if (response.ok) {

        location.reload();
    } else {
        alert('文件上传失败');
    }
}

document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();

    var form = e.target;
    var data = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open(form.method, form.action);

    var progressBar = document.querySelector('.progress-bar');
    var progressDiv = document.querySelector('.progress');

    progressDiv.style.display = 'block';
    progressBar.style.width = '0%';
    progressBar.textContent = '0%';

    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            var percentComplete = (e.loaded / e.total) * 100;
            progressBar.style.width = percentComplete + '%';
            progressBar.textContent = percentComplete + '%';
        if (percentComplete === 100) {
            progressBar.textContent = '服务器正在处理上传文件，请耐心等待...';
         }
        }
    };

    xhr.onload = function() {

        progressDiv.style.display = 'none';

        if (xhr.status === 200) {
            location.reload();
        } else {
            alert('文件上传失败');
        }
    };

    xhr.onerror = function() {
        progressDiv.style.display = 'none';
        alert('文件上传失败');
    };

    xhr.send(data);
});

function confirmDelete(file) {
    if (confirm('确认删除该文件吗？')) {
        deleteFile(file);
    }
}

function deleteFile(file) {
    fetch('', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'delete=' + encodeURIComponent(file)
    }).then(function(response) {
        if (response.ok) {
            location.reload();
        } else {
            alert('删除文件失败');
        }
    }).catch(function(error) {
        alert('删除文件时发生错误：' + error);
    });
}
function copyLink(file) {
    var url = $base_url + file;
    navigator.clipboard.writeText(url).then(function() {
        showAlert('链接已复制到剪贴板');
    }, function(error) {
        showAlert('复制链接失败：' + error);
    });
}
</script>

  <div class="floating-notice">
    本网站提供公网访问，主要方便管理员和身边的人员使用，网站空间有限，当前限制最大单文件为1M，网站空间超过50M管理员自动清空，请注意保存。
  </div>
</body>
</html>
