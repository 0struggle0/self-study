<?php

require('Validate.php');

$data = array( 
    "username" => 'ningofaura@gmail.com', 
    "nickname" => '张海宁', 
); 

$validateRule = array( 
    'username' => array( 
        'requird' => true, 
        'email' => true,
    ), 
    'nickname' => array( 
        'requird' => true, 
    ), 
); 
 
$validateErrorMessage = array( 
    'username' => array( 
        'requird' => "用户名不能为空", 
        'email' => "邮箱格式不正确", 
    ), 
    'nickname' => array( 
        'requird' => "昵称不能为空", 
    ), 
); 

$Validate = new Validate(); 
$result = $Validate->verify($data, $validateRule, $validateErrorMessage);

if ($result !== true){ 
    echo $result; 
    exit; 
}