<?php

try {
	// 实例化pdo对象
	// 错误处理模式：
	// 通过第四个参数设置
	// $pdo = new PDO('mysql:host=localhost;dbname=php1712','root','',[PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING  ]);
	$pdo = new PDO('mysql:host=localhost;dbname=php1712','root','');
	//也可以通过setAttribute设置错误模式
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

} catch (PDOException $e) {
	var_dump('数据库连接失败：'.$e->getMessage());
}

try {
	var_dump($pdo->query('select * from php_user1'));
} catch (Exception $e) {
	//如果错误模式是ERRMODE_EXCEPTION会触发这里
	var_dump($e);
}

echo '后续代码<br/>';