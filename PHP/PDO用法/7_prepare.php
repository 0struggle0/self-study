<?php
try {
	$pdo = new PDO('mysql:host=localhost;dbname=php1712;charset=utf8','root','');
} catch (PDOException $e) {
	var_dump($e->getMessage());
}

try {
	$stmt = $pdo->prepare("insert into php_banlance(name,money) values(?,?)");
	/**
	 * 第一个参数代表？占位符的索引号（从1，从左向右数）
	 * 第二个参数：？占位符绑定的变量或值
	 * 第三个参数：变量或值得类型，默认是字符串
	 */
	$stmt->bindvalue(1,'鹿晗');
	$stmt->bindvalue(2,3000,PDO::PARAM_INT);
	$res = $stmt->execute();
    var_dump($res);

    //执行时不再编译sql语句
    //$stmt->bindvalue(1,'小龙女');
	//$stmt->bindvalue(2,6000,PDO::PARAM_INT);
	//这种简便方式
	//需要传递一个索引数组，数组中的值对应问号
	$res = $stmt->execute(['闰杰',9000]);

} catch (PDOException $e) {
	echo $e->getMessage();
}