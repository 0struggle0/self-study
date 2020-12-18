# PDO使用

## 一、pdo概述

php连接不同数据库使用不同的扩展，每种数据库访问方式都不同

PDO是对不同数据库访问方式的抽象，可以以一种统一的方式访问不同类型的数据库

![pdo](C:\wamp64\www\1712\high\high\13\pdo.png)



## 二、 PDO使用

三种基本类型： PDO类、PDOStatment类、PDOException类

### 1.PDO的实例化

- 数据库的链接是通过PDO类的实例化实现的

~~~
$pdo = new PDO('mysql:host=localhost;dbname=php1712','root','');
~~~

- dsn（data source name）写法

  - 字符串   

  - 文件    

    ~~~
    $uri = "uri:file:///C:/wamp64/www/1712/high/high/13/dsn.txt";
    $pdo = new PDO($uri,'root','');
    ~~~

    ​


### 2.属性设置

- 错误报告 PDO::ATTR_ERRMODE
  - PDO::ERRMODE_SILENT： 仅设置错误代码。
  - PDO::ERRMODE_WARNING: 引发 E_WARNING 错误
  - PDO::ERRMODE_EXCEPTION: 抛出 exceptions 异常
- 错误报告设置方式
  - 可以通过构造函数的第四个参数
  - 通过setAttribute设置

### 3.PDO执行sql语句

- exec  没有结果集，返回受影响的行数，一般用于insert、delete、update
- query  返回查询的结果集，对应select查询
- lastInsertId 返回插入记录的主键值
- quote给字符串变量添加引号

### 4.事务

- 表的引擎  必须为innodb

- 使用事务的场景：

  - 第一如果希望一系列操作要么同时成功，要么同时失败
  - 第二 批量增删改需要使用事务

- 事务相关方法

  - beginTansAction()  开启事务
  - commit    提交 将操作结果写入数据库
  - rollback   回滚，所有操作回复到开启事务之前

### 5.sql语句的预处理

- 优点：安全（防止sql注入）、高效

- 数据绑定方式：

  - 使用？做占位符

    ~~~php
    $stmt = $pdo->prepare("insert into php_banlance(name,money) values(?,?)");
    	/**
    	 * 第一个参数代表？占位符的索引号（从1，从左向右数）
    	 * 第二个参数：？占位符绑定的变量或值
    	 * 第三个参数：变量或值得类型，默认是字符串
    	 */
    	$stmt->bindvalue(1,'鹿晗');
    	$stmt->bindvalue(2,3000,PDO::PARAM_INT);
    	$res = $stmt->execute();
    ~~~

  - 使用：做占位符

    ~~~php
    $stmt = $pdo->prepare("update php_banlance set name= :name,money = :money where id=1");
    	$name = '脑残粉';

    	/**
    	 * 第一个参数：是命名占位符字符串：':name'
    	 * 第二个参数：绑定的变量，必须是变量
    	 * 第三个参数：是变量的类型
    	 */
    	$stmt->bindParam(':name',$name);
    	$money = 0.6;
    	$stmt->bindParam(':money',$money,PDO::PARAM_INT);
    	$stmt->execute();

    ~~~

  - 简便方式

    ~~~php
    //?号占位符需要传递一个索引数组，数组中的值对应问号
    $res = $stmt->execute(['闰杰',9000]);

    $name = '6个女朋友';
    $money = 1000;
    //命名占位符的简便写法
    $stmt->execute([
    			':name'=>$name,
    			':money'=>$money
    		]);
    ~~~

- 获取影响的记录数需要使用$stmt->rowCount();

- 查询结果集 

  - PDO::FETCH_CLASS 结果集是对象
  - PDO::FETCH_ASSOC  关联数组
  - PDO::FETCH_NUM 索引数组
  - PDO::FETCH_BOTH 混合数组（默认）

- 关闭pdo

  - 只需要将$pdo赋为空值 

## 作业：

1. 代码两遍
2. 使用PDO写一个文章列表，完成增、删、改、查，分页