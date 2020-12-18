<?php
try {
	$pdo = new PDO('mysql:host=localhost;dbname=php1712;charset=utf8','root','');
} catch (PDOException $e) {
	var_dump('数据库连接失败：'.$e->getMessage());
}

//数据库操作
try {
	//查询
	//结果集对象
	// $stmt = $pdo->query('select * from php_user');
	// var_dump($stmt);

	//获取所有的结果集
	//var_dump($stmt->fetchAll(PDO::FETCH_CLASS ));

	//一条数据获取
	// while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
	// 	var_dump($row);
	// }
	// 
	// foreach ($stmt as  $value) {
	// 	var_dump($value);
	// }
	// 
	//增删改
	$name = '琨琨';
	$password = md5('123');

	//给字符串添加单引号
	$name = $pdo->quote($name);
	$password = $pdo->quote($password);
	// var_dump($name);die;
	$stmt = $pdo->exec("insert into php_user(name,password) values($name,$password)");
	var_dump($stmt);

	//获取自增主键的新增记录的值
	var_dump($pdo->lastInsertId());

} catch (PDOException $e) {
   var_dump($e);	
}

//关闭连接
$pdo = null;
