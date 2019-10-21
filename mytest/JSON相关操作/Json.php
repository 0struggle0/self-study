<?php

$array = array(
	'0' => '测试1',
	'1' => '测试2'
);

var_dump(json_encode($array));
var_dump(json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)); //不转换汉字的编码
var_dump(json_decode(json_encode($array)));

