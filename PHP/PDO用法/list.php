<?php
include 'Page.php';
try {
	$pdo = new PDO('mysql:host=localhost;dbname=php1712;charset=utf8','root','');
} catch (PDOException $e) {
	var_dump($e->getMessage());
}

try {
	//总记录数
	$stmt= $pdo->query('select count(*) from php_banlance');
	// var_dump($stmt->rowCount());
	// 取指定的列,0指第一列
	$totalRec = $stmt->fetchColumn(0);
    $page = new Page($totalRec,15);
    //分页的超链接;
    $result = $page->allPage();

    //查询数据
    $stmt  = $pdo->query("select name,money from php_banlance limit ".$page->limit());
    if ($stmt) {
    	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    var_dump($data,$result);
} catch (PDOException $e) {
	
}