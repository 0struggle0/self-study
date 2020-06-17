<?php
/*
 * @Description: 
 * @Date: 2020-06-02 22:30:13
 * @LastEditTime: 2020-06-02 22:54:41
 */ 

function imgToBase64($imageDir)
{
    $base64Image = '';
    if (file_exists($imageDir)) {
        // $imageInfomation = getimagesize($imageDir); // 取得图片的大小，类型等
        $fp = fopen($imageDir, "r"); // 图片是否可读权限
        if ($fp) {
            $content = fread($fp, filesize($imageDir));
            $base64Image = chunk_split(base64_encode($content)); // base64编码 chunk_split 使用 RFC 2045 语义格式化 data
        }
        fclose($fp);
    }

    var_dump($base64Image) ; //返回图片的base64
}

imgToBase64('./tupian.png');