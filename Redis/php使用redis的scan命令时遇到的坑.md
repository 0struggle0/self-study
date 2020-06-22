# php使用redis的scan命令时遇到的坑

以前的项目中有用到redis的**keys**命令来获取某些key，这个命令在数据库特别大的情况会block很长一段时间，所以有很大的安全隐患，所以这次打算优化一下。

官网建议使用scan命令来代替。于是就用了……



以下是使用scan命令来匹配相应模式的key的代码：

```php

$redis = new Redis();
$redis->connect('localhost', 6379);
 
$iterator = null;
while ($keys = $redis->scan($iterator, 'test*')) {
    foreach ($keys as $key) {
        echo $key . PHP_EOL;
    }
}
```

这代码应该没问题吧？这是从jetbrains 公司旗下软件phpstorm的代码提示库中摘出来的，只加了pattern参数，但是运行结果却是有问题的。

使用keys命令可以得到设置的”test1″,”test2″,…..,”test5″这5个key，但是使用scan却什么也没有输出。

……

…………

………………

经过多方分析，最终发现，是scan命令的返回值有问题。

其实redis的官方文档也明确说了，scan命令每次迭代的时候，有可能返回空，但这并不是结束的标志，而是当返回的迭代的值为”0″时才算结束。

因此，上面的代码在迭代的时候，若没有key返回，$keys是个空数组，所以while循环自然就中断了，所以没有任何输出。

这种情况在redis中key特别多的时候尤其明显，当key只有几十个上百个的时候，很少会出现这种情况，但是当key达到上千万，这种情况几乎必现。

要减少这种情况的出现，可以通过将scan函数的第三个参数count设定为一个较大的数。但这不是解决此问题的根本办法，根本办法有以下两种：

1.setOption

通过setOption函数来设定迭代时的行为。以下是示例代码：

```php

$redis = new Redis();
$redis->connect('localhost', 6379);
$redis->setOption(Redis::OPT_SCAN,Redis::SCAN_RETRY);
 
$iterator = null;
while ($keys = $redis->scan($iterator, 'test*')) {
    foreach ($keys as $key) {
        echo $key . PHP_EOL;
    }
}
```

和上面的代码相比，只是多了个setOption的操作，这个操作的作用是啥呢？这个操作就是告诉redis扩展，当执行scan命令后，返回的结果集为空的话，函数不返回，而是直接继续执行scan命令，当然，这些步骤都是由扩展自动完成，当scan函数返回的时候，要么返回false，即迭代结束，未发现匹配模式pattern的key，要么就返回匹配的key，而不再会返回空数组了。

 

2.while(true)

上面那种方式是由php的扩展自动完成的，那么我们也可以换一种写法来达到相同的效果。

```php
$redis = new Redis();
$redis->connect('localhost', 6379);
 
$iterator = null;
while (true) {
    $keys = $redis->scan($iterator, 'test*');
    if ($keys === false) {//迭代结束，未找到匹配pattern的key
        return;
    }
    foreach ($keys as $key) {
        echo $key . PHP_EOL;
    }
}
```





SCAN 

- `SCAN cursor [MATCH pattern] [COUNT count]`
- 作用：迭代当前数据库中的数据库键
- SCAN 使用 demo



```php
<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
/* Options for the SCAN family of commands, indicating whether to abstract
   empty results from the user.  If set to SCAN_NORETRY (the default), phpredis
   will just issue one SCAN command at a time, sometimes returning an empty
   array of results.  If set to SCAN_RETRY, phpredis will retry the scan command
   until keys come back OR Redis returns an iterator of zero */
$redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
$iterator = null;
$count = 1000; // 测试时redis中大概有20w个key，用时约2s，当count为500时用时约4s，count越大时扫描用时越短（当然需要根据你的业务需要来定）
$prefix = date('Ymd');
$time1 = msectime();
$total = [];
while ($arrKeys = $redis->scan($iterator, $prefix . '*', $count)) {
    $arrValues = $redis->mget($arrKeys);
    $ret = array_combine($arrKeys, $arrValues);
    $total = array_merge($total, $ret);
}
$time2 = msectime();
$time = $time2 - $time1;
echo 'time : ' . $time  . ' ms; total keys : ' . count($total) . PHP_EOL;
// time : 2009 ms; total keys : 129798  （用时2009 ms，20w中共有129798个前缀为$prefix的key）
function msectime() {
    list($msec, $sec) = explode(' ', microtime());
    $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    return $msectime;
}
```



SSCAN 

- `SCAN cursor [MATCH pattern] [COUNT count]`
- 作用：用于迭代集合键中的元素
- SSCAN使用demo



```php
<?php
$iterator = null;
$count = 1000;
$mainKey = date('Ymd');
$prefix = $mainKey;
$total = [];
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
$time1 = msectime();
while ($arrKeys = $redis->sscan($mainKey, $iterator, $prefix . '*', $count)) { // 匹配前缀为当前日期的key
    $total += $arrKeys;
}
$time2 = msectime();
$time = $time2 - $time1;
echo 'use time : ' . $time  . ' ms; total keys : ' . count($total) . PHP_EOL;
// use time : 649 ms; total keys : 90010 （这个集合中有20w个元素）
....... other code ......
```



ZSCAN 

- `ZSCAN cursor [MATCH pattern] [COUNT count]`
- 作用：用于迭代有序集合中的元素
- ZSCAN使用demo



```php
<?php
$iterator = null;
$count = 1000;
$mainKey = 'test';
$prefix = '10';
$total = [];
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
$time1 = msectime();
while ($arrKeys = $redis->zscan($mainKey, $iterator, $prefix . '*', $count)) { // 匹配key前缀是 10 的所有key
    var_dump($arrKeys);
    $total += $arrKeys;
}
$time2 = msectime();
$time = $time2 - $time1;
echo 'use time : ' . $time  . ' ms; total keys : ' . count($total) . PHP_EOL;
// use time : 317 ms; total keys : 1111 （这个集合中有10w个元素）
...... other code ......
```



HSCAN 

- `HSCAN cursor [MATCH pattern] [COUNT count]`
- 作用：用于迭代哈希中的元素
- HSACN 使用demo



```php
<?php
$iterator = null;
$count = 1000;
$mainKey = 'my_hash_key';
$match = "*key*";
$total = [];
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->setOption(Redis::OPT_SCAN, Redis::SCAN_RETRY);
$time1 = msectime();
while ($arrKeys = $redis->hscan($mainKey, $iterator, $match, $count)) { // 匹配含有'key'的键
    var_dump($arrKeys);
    $total += $arrKeys;
}
$time2 = msectime();
$time = $time2 - $time1;
echo 'use time : ' . $time  . ' ms; total keys : ' . count($total) . PHP_EOL;
// use time : 1484 ms; total keys : 100000
...... other code ......
```



redis pipe 代码demo (快速向有序集合添加100000个key， 其他操作类似， 只要修改for中的操作即可) 



```php
$pipe = $redis->multi(Redis::PIPELINE);
for ($i = 0; $i < 100000; $i++) {
    $redis->zAdd($key, $i, $i);
}
$curValues = $pipe->exec();
$val = $redis->zRange($key, 0, -1, true);
var_dump($val);
```

