<?php
$imageName = $_POST['imageName'];
$image_directory = '_png/'; // 图片存储目录，根据实际情况修改
$thumb_directory = '_png/thumbnails/'; // 缩略图存储目录，根据实际情况修改
$file_to_delete = $image_directory . $imageName;
$thumb_to_delete = $thumb_directory . $imageName;

$original_file_deleted = false;
$thumb_file_deleted = false;

if (file_exists($file_to_delete)) {
    unlink($file_to_delete);
    $original_file_deleted = true;
}

if (file_exists($thumb_to_delete)) {
    unlink($thumb_to_delete);
    $thumb_file_deleted = true;
}

if ($original_file_deleted && $thumb_file_deleted) {
    echo "原图和缩略图删除成功。";
} elseif ($original_file_deleted) {
    echo "原图删除成功，但缩略图不存在。";
} elseif ($thumb_file_deleted) {
    echo "缩略图删除成功，但原图不存在。";
} else {
    echo "原图和缩略图均不存在，删除失败。";
}
?>
