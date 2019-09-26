<?php

$path = str_replace('\\', '/', dirname(__FILE__));

if (file_exists($path . '/confing.php')){
    if (!include($path . '/confing.php')) exit('confing.php isn\'t exists!');
}

if (file_exists($path . '/confing2.php')){
    if (!include($path . '/confing2.php')) exit('confing2.php isn\'t exists!');
}

// global $config;

var_dump($config);