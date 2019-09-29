<?php

function getHtmlText($html)
{
	$html = preg_replace("/&#xa0;/", "", $html);
	$html = clearHtml($html);
	$html = preg_replace("/<\b[^<>]*>|<\/\b[^<>]*>/",'',$html);
	$html = preg_replace("/\s/",'',$html);
  	return $html;
}

function clearHtml($str)
{
	$str = preg_replace("/<([a-zA-Z]+)[^>]*>/",'',$str);
	$str = preg_replace("/\r\n/",'',$str); //清除换行符
	$str = preg_replace("/\n/",'',$str); //清除换行符
	$str = preg_replace("/\t/",'',$str); //清除制表符
	$str = preg_replace("/\&([a-zA-Z;])*/",'',$str); //清除html实体字符
	return trim(preg_replace("/<\/([a-zA-Z]+)[^>]*>/",'',$str));
}