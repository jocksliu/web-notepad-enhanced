<?php
include('qr.php'); 
$file = $_GET['file'];
$url = 'http://' . $_SERVER['HTTP_HOST'] . '/sharefile/' . $file;
QRcode::png($url);
?>
