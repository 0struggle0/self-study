# PHP并发写入同一个文件

```php
<?php
/**
 * Created by PhpStorm.
 * User: Jiangliang
 * Date: 2020/7/3
 * Time: 11:35
 * Email: jiangliangscau@163.com
 * Desc: 文件排他锁.
 */
function lockWrite($path, $content, $mode = "w+")
{
    $fp = fopen($path, $mode);
    if(flock($fp, LOCK_EX)) {
        fwrite($fp, $content);
        flock($fp, LOCK_UN);
    } else {
        echo "this {$path} file is writing...";
    }
    fclose($fp);
}
```

- **LOCK_SH 共享锁，读取的时候采用**
- **LOCK_EX 排他锁，写入的时候采用**
- **LOCK_UN 释放锁（也就是说要释放一个文件的锁定状态需要将flock再调用一次，传入文件句柄和LOCK_UN）**
- **LOCK_NB 文件不会在锁定的时候阻塞**