<?php session_start(); 
$correct_password = 'Admin'; 
if (isset($_POST['password'])) {
    if ($_POST['password'] === $correct_password) {
        $_SESSION['authenticated'] = true;
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit; 
    }
}
$base_url = 'https://www.muv.cc';
/* Minimalist Web Notepad | https://github.com/pereorga/minimalist-web-notepad */
/* 网络笔记本增强版! Web Notepad web-notepad-enhanced */
/* https://github.com/jocksliu/web-notepad-enhanced  */
/* 本项目源于原作者pereorga 的项目Minimalist Web Notepad上二次开发而来  本项目作者：jocksliu */
/* 原仓库地址 https://github.com/pereorga/minimalist-web-notepad */
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jocks临时图片</title>
<style>
    img {
        width: 150px; 
        height: auto;
        box-shadow: 5px 5px 15px 0 rgba(0,0,0,0.3); 
    }
    .image-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: center;
        gap: 10px;
    }
   
    body {
        font-family: Arial, sans-serif;
    }


    .button {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button-primary {
        background-color: #4CAF50;
        color: #fff;
        border: none;
    }

    .button-primary:hover {
        background-color: #45a049;
    }

    .button-secondary {
        background-color: #f0f0f0;
        color: #333;
        border: 1px solid #ccc;
    }

    .button-secondary:hover {
        background-color: #e0e0e0;
    }

    .button-block {
        display: block;
        width: 100%;
    }

    @media (max-width: 480px) {
        .button {
            font-size: 14px;
        }
    }
    @media (max-width: 480px) { 
        button {
            font-size: 18px; 
        }
    }

    .lightbox {
  display: none;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0,0,0,0.9);
  text-align: center;
}

.lightbox-image {
  position: absolute;
  top: 50%;
  left: 50%;
  max-width: 90%;
  max-height: 80%;
  transform: translate(-50%, -50%);
}

#close {
  color: #f1f1f1;
  position: absolute;
  top: 50px;
  right: 60px;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
  cursor: pointer;
}

#close:hover, #close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
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
            justify-content: center; 
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





<h1>图册上传</h1>
<?php if (!isset($_SESSION['authenticated'])): ?>
    <div class="alert alert-warning" role="alert">
        请输入密码以解锁上传功能
    </div>
    <form action="" method="post">
        <div class="form-group">
            <label for="password" style="font-weight: bold;">密码:</label>
            <input type="password" name="password" id="password" class="form-control" style="width: 200px;">
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">解锁上传功能</button>
    </form>
<?php else: ?>
    <input type="file" accept="image/*" id="fileInput" style="display: none;">
    <button onclick="openFilePicker()" class="button button-primary">选择文件</button>
    <input type="file" accept="image/*" capture="camera" id="cameraInput" style="display: none;">
    <button onclick="openCamera()" class="button button-primary" >手机拍照</button>
    <button onclick="showPasteModal()" class="button button-primary">粘贴板</button>
    <button onclick="uploadImage()" class="button button-primary">确认并上传</button>
    <button onclick="uploadImage()" class="button button-primary" style="display: none;">确认并上传</button>
    <span id="file-name"></span>
    <div id="message"></div>
<?php endif; ?>

    <script>
        var imageFile;
       var selectedFile;

var cameraInput = document.getElementById('cameraInput');
cameraInput.addEventListener('change', function () {
    imageFile = cameraInput.files[0];
    if (imageFile) {  
        var fileName = imageFile.name;
        var message = document.getElementById('message');
        message.innerHTML = '已选择文件: ' + fileName;
        uploadImage();
    }
});

function openCamera() {
    cameraInput.click();
}
        function uploadImage() {
            var message = document.getElementById('message');
            if (!imageFile) {
                message.innerHTML = '请先拍照或者选择文件';
                return;
            }

            if (imageFile.size > 5*1024*1024) {
                message.innerHTML = '文件过大，必须小于5MB';
                return;
            }

            if (!['jpeg', 'jpg', 'gif', 'bmp','ico','svg','webp','tiff', 'png'].includes(imageFile.type.split('/')[1])) {
                message.innerHTML = '文件类型必须为 .jpeg, .jpg, .gif 或 .png';
                return;
            }

            var formData = new FormData();
            formData.append('image', imageFile);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload.php');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    message.innerHTML = '图片上传成功';
                    location.reload(); 
                } else {
                    message.innerHTML = '图片上传失败：' + xhr.responseText;
                }
            };
            xhr.send(formData);
        }

function openFilePicker() {
    var fileInput = document.getElementById('fileInput');
    fileInput.click();

    fileInput.addEventListener('change', function () {
        selectedFile = fileInput.files[0];
        var fileName = selectedFile.name;
        var message = document.getElementById('message');
        message.innerHTML = '已选择文件: ' + fileName;

        if (selectedFile) {
            uploadFile();
        }
    });
}
function uploadFile() {
    var message = document.getElementById('message');
    if (!selectedFile) {
        message.innerHTML = '请先选择文件';
        return;
    }

    var formData = new FormData();
    formData.append('image', selectedFile);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'upload.php');
    xhr.onload = function () {
        if (xhr.status === 200) {
            message.innerHTML = '文件上传成功';
            location.reload(); 
        } else {
            message.innerHTML = '文件上传失败：' + xhr.responseText;
        }
    };
    xhr.send(formData);
}

function openLightbox(imageSrc) {
  var img = new Image();
  img.src = imageSrc;
  img.onload = function() {
    var aspectRatio = this.width / this.height;
    var boxWidth = window.innerWidth * 0.9;
    var boxHeight = window.innerHeight * 0.8;
    var imgWidth, imgHeight;

    if (boxWidth / boxHeight > aspectRatio) {
      imgHeight = boxHeight;
      imgWidth = imgHeight * aspectRatio;
    } else {
      imgWidth = boxWidth;
      imgHeight = imgWidth / aspectRatio;
    }

    document.getElementById('lightbox-img').style.width = imgWidth + 'px';
    document.getElementById('lightbox-img').style.height = imgHeight + 'px';
  }

  document.getElementById('lightbox').style.display = 'block';
  document.getElementById('lightbox-img').src = imageSrc;
}

function closeLightbox() {
  document.getElementById('lightbox').style.display = 'none';
}

document.getElementById('file-upload').addEventListener('change', function(e) {
  var fileName = e.target.files[0].name;
  document.getElementById('file-name').textContent = fileName;
});

    function copyImageLink(e) {
        e.stopPropagation(); 
        var imageSrc = document.getElementById('lightbox-img').src;
        navigator.clipboard.writeText(imageSrc).then(function() {
            alert("复制成功！");
        }, function() {
            alert("复制失败，请手动复制！");
        });
    }

    function deleteImage(e) {
        e.stopPropagation(); 
        var imageSrc = document.getElementById('lightbox-img').src;
        var imageName = imageSrc.substring(imageSrc.lastIndexOf('/') + 1);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete.php');
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.status === 200) {
                alert('图片删除成功');
                location.reload(); 
            } else {
                alert('图片删除失败：' + xhr.responseText);
            }
        };
        xhr.send('imageName=' + imageName);
    }
    </script>

<h1 style="text-align: center;">已上传的图片</h1>
<div id="lightbox" class="lightbox" onclick="closeLightbox()">
  <span id="close">&times;</span>
  <img id="lightbox-img" class="lightbox-image">
  <div id="lightbox-controls"> 
    <button class="button button-secondary" onclick="copyImageLink(event)">复制图片链接</button>
<?php if (isset($_SESSION['authenticated'])): ?>
    <button class="button button-secondary" onclick="deleteImage(event)">删除图片</button>
<?php endif; ?>
    
  </div>
</div>
    <div class="image-container">
<?php
    $image_directory = '_png/'; 
    $thumb_directory = '_png/thumbnails/'; 
    $images = glob($thumb_directory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE); 
    usort($images, function($a, $b) {
         return filemtime($a) < filemtime($b);
    });

    foreach ($images as $index => $image) {
        $original_image = str_replace("thumbnails/", "", $image); 
        echo '<div class="image-wrapper">';
        echo '<img src="' . $image . '" alt="Image" onclick="openLightbox(\'' . $original_image . '\')">'; 
        echo '</div>';
    }
?>
    </div>


<style>
.paste-modal {
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}
.paste-modal-content {
  position: relative;
  background-color: #fefefe;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 600px;
  text-align: center;
}
.paste-modal-content #paste-close {
  position: absolute;
  top: 5px;
  right: 10px;
  color: #aaa;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}
.paste-modal-content #paste-close:hover,
.paste-modal-content #paste-close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.paste-modal-content #paste-area {
  width: 100%;
  height: 200px;
  border: 1px solid #ccc;
  margin: 20px 0;
  outline: none;
  overflow: auto;
}
.paste-modal-content #paste-preview {
  max-width: 100%;
  max-height: 200px;
  margin: 10px 0;
}
</style>   
<div id="paste-modal" class="paste-modal" style="display:none;">
  <div class="paste-modal-content">
    <span id="paste-close" onclick="hidePasteModal()">&times;</span>
    <h3>请粘贴图片</h3>
    <div id="paste-area" contenteditable="true" onpaste="handlePaste(event)"></div>
    <button onclick="confirmPaste()" class="button button-primary">确定上传</button>
    <img id="paste-preview" src="" alt="预览" style="display:none;">
  </div>
</div>
<script>
    var pastedImage;

function showPasteModal() {
  document.getElementById('paste-modal').style.display = 'block';
}

function hidePasteModal() {
  document.getElementById('paste-modal').style.display = 'none';
}

function handlePaste(e) {
  var items = e.clipboardData.items;
  for (var i = 0; i < items.length; i++) {
    if (items[i].type.indexOf('image') !== -1) {
      var blob = items[i].getAsFile();
      var reader = new FileReader();
      reader.onload = function(event){
        document.getElementById('paste-preview').src = event.target.result;
        document.getElementById('paste-preview').style.display = 'block';
      };
      reader.readAsDataURL(blob);
      pastedImage = blob;
    }
  }
}

function confirmPaste() {
  if (!pastedImage) {
    alert('请先粘贴图片');
    return;
  }

  var formData = new FormData();
  formData.append('image', pastedImage);

  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'upload.php');
  xhr.onload = function () {
    if (xhr.status === 200) {
      document.getElementById('message').innerHTML = '图片上传成功';
      location.reload(); 
    } else {
      document.getElementById('message').innerHTML = '图片上传失败：' + xhr.responseText;
    }
  };
  xhr.send(formData);

  hidePasteModal();
}

</script>
  <style>
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
<div class="floating-notice">
    本网站提供公网访问，主要方便管理员和身边的人员使用，网站空间有限，当前图片单文件最大5M，网站空间超过800M管理员自动清空，请注意保存。
  </div>
</body>
</html>
