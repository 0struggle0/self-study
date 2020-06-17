<?php

$errorHtmlUrl = 'error.html';
$filename = "error.zip";
file_put_contents($errorHtmlUrl, '<p>法律的框架给人</p>');

$zip = new ZipArchive();
$zip->open($filename, ZipArchive::CREATE);   //打开压缩包
$zip->addFile($errorHtmlUrl, basename($errorHtmlUrl)); //向压缩包中添加文件
$zip->close();  //关闭压缩包