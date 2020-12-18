<?php
try {
	// 实例化pdo对象
	//文件dsn
	$uri = "uri:file:///C:/wamp64/www/1712/high/high/13/dsn.txt";
	$pdo = new PDO($uri,'root','');
} catch (PDOException $e) {
	var_dump('数据库连接失败：'.$e->getMessage());
}

var_dump($pdo);