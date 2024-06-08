<?php
$target_dir = "_png/";
$imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

// 修改文件名为 [日期]-[随机4位数串码] 的格式
$date = date('Ymd');
$random = sprintf('%04d', rand(0, 9999));
$target_file = $target_dir . $date . '-' . $random . '.' . $imageFileType;

// 允许特定文件格式
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    http_response_code(400); // 返回错误状态码
    echo "只允许上传 JPG, JPEG, PNG & GIF 格式的文件。";
    exit;
}

// 检查文件是否已经存在
if (file_exists($target_file)) {
    http_response_code(400);
    echo "文件已存在。";
    exit;
}

// 尝试将文件移动到目标目录
if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    http_response_code(500); // 返回错误状态码
    echo "上传文件时出现错误。";
    exit;
}

// 创建并保存缩略图
$thumbWidth = 200; // 定义缩略图的宽度
$thumbnail_file = $target_dir . 'thumbnails/' . $date . '-' . $random . '.' . $imageFileType;

list($width, $height) = getimagesize($target_file);

// 计算缩略图的高度
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
