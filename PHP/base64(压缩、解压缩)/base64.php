<?php

class zipAndUnzipBase64
{
	//字符串gzip压缩
    public static function stringCompress($string)
    {
    	if (empty($string)) {
    		return "";
    	}

    	$compress = base64_encode(gzencode($string));
    	return $compress;
    }

    //字符串gzip解压
    public static function stringUnCompress($string)
    {
    	if (empty($string)) {
    		return "";
    	} else if (self::isBase64($string) === false) {
    		return $string;
    	}

    	$uncompress = gzdecode(base64_decode($string));
    	return $uncompress;
    }

    // 判断字符串是否经过base64压缩过
    public static function isBase64($string)
    {  
      return $string == base64_encode(base64_decode($string)) ? true : false;  
    }
}