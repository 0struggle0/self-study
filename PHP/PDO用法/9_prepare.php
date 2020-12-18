<?php
try {
	$pdo = new PDO('mysql:host=localhost;dbname=php1712;charset=utf8','root','');
} catch (PDOException $e) {
	var_dump($e->getMessage());
}

try {
	$stmt = $pdo->prepare("select name,money from php_banlance where name = ?");
	if ($stmt) {
		$stmt->execute(['野琨']);

		//获取结果集
		//将结果集中记录的列和变量绑定
		 $stmt->bindColumn(1, $name);
		 $stmt->bindColumn(2, $money);

		 while($rec = $stmt->fetch(PDO::FETCH_NUM)) {
		 	var_dump($name,$money);
		 }


	}
} catch (PDOException $e) {
	var_dump($e);
}