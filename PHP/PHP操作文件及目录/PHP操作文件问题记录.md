# fopen()函数的问题

```php
fopen — 打开文件或者 URL
resource fopen( string filename, string mode[, bool use_include_path = false[, resource context]] )
fopen() 将 filename 指定的名字资源绑定到一个流上。 

<?php
$handle = fopen("/home/rasmus/file.txt", "r");
$handle = fopen("/home/rasmus/file.gif", "wb");
$handle = fopen("http://www.example.com/", "r");
$handle = fopen("ftp://user:password@example.com/somefile.txt", "w");

```

如果 filename 是 "scheme://..." 的格式，则被当成一个 URL，PHP 将搜索协议处理器（也被称为封装协议）来处理此模式。如果该协议尚未注册封装协议，PHP 将发出一条消息来帮助检查脚本中潜在的问题并将 filename 当成一个普通的文件名继续执行下去。 

如果 PHP 认为 filename 指定的是一个本地文件，将尝试在该文件上打开一个流。该文件必须是 PHP 可以访问的，因此需要确认文件访问权限允许该访问。

**如果激活了安全模式或者 open_basedir 则会应用进一步的限制。**

**如果 PHP 认为 filename 指定的是一个已注册的协议，而该协议被注册为一个网络 URL，PHP 将检查并确认 allow_url_fopen 已被激活。如果关闭了，PHP 将发出一个警告，而 fopen 的调用则失败。** 

**注意：**

不同的操作系统家族具有不同的行结束习惯。当写入一个文本文件并想插入一个新行时，需要使用符合操作系统的行结束符号。基于 Unix 的系统使用 \n 作为行结束字符，基于 Windows 的系统使用 \r\n 作为行结束字符，基于 Macintosh 的系统使用 \r 作为行结束字符。 

如果写入文件时使用了错误的行结束符号，则其它应用程序打开这些文件时可能会表现得很怪异。 

Windows 下提供了一个文本转换标记（'t'）可以透明地将 \n 转换为 \r\n。与此对应还可以使用 'b' 来强制使用二进制模式，这样就不会转换数据。要使用这些标记，要么用 'b' 或者用 't' 作为 mode 参数的最后一个字符。 

默认的转换模式依赖于 SAPI 和所使用的 PHP 版本，因此为了便于移植鼓励总是指定恰当的标记。如果是操作纯文本文件并在脚本中使用了 \n 作为行结束符，但还要期望这些文件可以被其它应用程序例如 Notepad 读取，则在 mode 中使用 't'。在所有其它情况下使用 'b'。 

在操作二进制文件时如果没有指定 'b' 标记，可能会碰到一些奇怪的问题，包括坏掉的图片文件以及关于 \r\n 字符的奇怪问题。 

**为移植性考虑，强烈建议在用 fopen() 打开文件时总是使用 'b' 标记。** 

**返回值**

成功时返回文件指针资源，如果打开失败，本函数返回 FALSE。 

**错误／异常** 
如果打开失败，会产生一个 E_WARNING 错误。可以通过 @ 来屏蔽错误。 



 ## 判断文件或者目录是否可写

1. 可用系统函数 bool is_writable ( string $filename )

   如果文件存在并且可写则返回 TRUE。filename 参数可以是一个允许进行是否可写检查的目录名。 

```php
<?php
$filename = 'test.txt';
if (is_writable($filename)) {
    echo 'The file is writable';
} else {
    echo 'The file is not writable';
}
```

但是这个系统函数有个Bug, 尤其是在Windows服务器下判断不准，官方相关bug报告链接如下：

http://bugs.php.net/bug.php?id=27609

为了兼容各个操作系统，可自定义一个判断可写函数，代码如下(CI中的一个方法)：

```php
/**
 * 判断 文件/目录 是否可写
 *
 * @param string $file 文件/目录
 * @return boolean
 */
function is_really_writable($file)
{
    // If we're on a Unix server with safe_mode off we call is_writable
    if (DIRECTORY_SEPARATOR === '/' && (is_php('5.4') or !ini_get('safe_mode'))) {
        return is_writable($file);
    }

    /* For Windows servers and safe_mode "on" installations we'll actually
        * write a file then read it. Bah...
        */
    if (is_dir($file)) {
        $file = rtrim($file, '/') . '/' . md5(mt_rand());
        if (($fp = @fopen($file, 'ab')) === FALSE) {
            return FALSE;
        }

        fclose($fp);
        @chmod($file, 0777);
        @unlink($file);
        return TRUE;
    } elseif (!is_file($file) or ($fp = @fopen($file, 'ab')) === FALSE) {
        return FALSE;
    }

    fclose($fp);
    return TRUE;
}
```

