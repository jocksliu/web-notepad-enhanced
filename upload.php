<?php
/* Minimalist Web Notepad | https://github.com/pereorga/minimalist-web-notepad */
/* 网络笔记本增强版! Web Notepad web-notepad-enhanced */
/* https://github.com/jocksliu/web-notepad-enhanced  */
/* 本项目源于原作者pereorga 的项目Minimalist Web Notepad上二次开发而来  本项目作者：jocksliu */
/* 原仓库地址 https://github.com/pereorga/minimalist-web-notepad */
$target_dir = "_png/";
$imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));


$date = date('Ymd');
$random = sprintf('%04d', rand(0, 9999));
$target_file = $target_dir . $date . '-' . $random . '.' . $imageFileType;


if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    http_response_code(400); 
    echo "只允许上传 JPG, JPEG, PNG & GIF 格式的文件。";
    exit;
}

if (file_exists($target_file)) {
    http_response_code(400);
    echo "文件已存在。";
    exit;
}

if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    http_response_code(500); 
    echo "上传文件时出现错误。";
    exit;
}


$thumbWidth = 200; 
$thumbnail_file = $target_dir . 'thumbnails/' . $date . '-' . $random . '.' . $imageFileType;

list($width, $height) = getimagesize($target_file);


$thumbHeight = $height * ($thumbWidth / $width);

$newImg = imagecreatetruecolor($thumbWidth, $thumbHeight);

if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
    $sourceImg = imagecreatefromjpeg($target_file);
} else if ($imageFileType == "png") {
    $sourceImg = imagecreatefrompng($target_file);
} else {
    $sourceImg = imagecreatefromgif($target_file);
}

imagecopyresized($newImg, $sourceImg, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);

if ($imageFileType == "jpg" || $imageFileType == "jpeg") {
    imagejpeg($newImg, $thumbnail_file);
} else if ($imageFileType == "png") {
    imagepng($newImg, $thumbnail_file);
} else {
    imagegif($newImg, $thumbnail_file);
}

imagedestroy($newImg);
imagedestroy($sourceImg);

echo "文件成功上传。";

if (isset($_POST["submit"])) {
    $targetDir = "sharefile/";
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        echo "文件上传成功。";
    } else {
        echo "文件上传失败。";
    }
}
?>
