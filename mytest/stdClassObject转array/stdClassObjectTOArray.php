<?php

// 有时前端发送的JSON数据，单纯通过json_decode方法解析获得得数值一般并非数组，
// 而是带有stdClass Objec的对象字符串，这时如果我们想获取相应的PHP数组时，需通过以下几种方法来获取。


//PHP stdClass Object转array  
function object_array($array)
{
    if (is_object($array)) {
        $array = (array)$array;
    } else if(is_array($array)) {
        foreach ($array as $key => $value) {
        	$array[$key] = object_array($value);
        }
    }
    return $array;
}


// 因为json_decode()函数可以接受两个参数：

// 当 $data= json_decode($object);  //得到的是 object 上面数据类型。
// 当 $data= json_decode($object, ture);  //得到的则是数组。

// $data = json_decode($json, ture);   
