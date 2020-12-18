<?php

try {
	// 实例化pdo对象
	/**
	 * [$pdo description]
	 * 第一个参数：dsn 数据源名称，不同数据库数据源名称写法不同
	 * 例如mysql的dsn：   mysql:host=localhost;dbname=php1712
	 * 第二个参数：用户名
	 * 第三个参数：密码
	 */
	$pdo = new PDO('mysql:host=localhost;dbname=php1712','root','');
} catch (PDOException $e) {
	var_dump('数据库连接失败：'.$e->getMessage());
}

var_dump($pdo);