<?php

// 通过在其它文件中定义数组，然后引用过来可以做配置文件
$path = str_replace('\\', '/', dirname(__FILE__));

if (file_exists($path . '/confing.php')){
    if (!include($path . '/confing.php')) exit('confing.php isn\'t exists!');
}

if (file_exists($path . '/confing2.php')){
    if (!include($path . '/confing2.php')) exit('confing2.php isn\'t exists!');
}

// global $config;

var_dump($config);