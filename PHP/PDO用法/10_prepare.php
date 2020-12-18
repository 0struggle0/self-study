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
		 while($rec = $stmt->fetch(PDO::FETCH_NUM)) {
		 	var_dump($rec);
		 }

		 $stmt->execute(['6个女朋友']);
		 var_dump($stmt->fetchAll(PDO::FETCH_CLASS));


	}
} catch (PDOException $e) {
	var_dump($e);
}