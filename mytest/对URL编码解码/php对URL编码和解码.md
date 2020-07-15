## 为什么要对URL编码

当我们使用GET方式传递参数时，参数内容就直接会在URL地址显示出来，安全系数较低。

> login.php?name=test&password=123456

而且如果在参数中带有空格，则用 URL 传递参数时就会发生错误，而用 URL编码后，空格转换成%20等。

这样错误就不会发生了。对中文进行编码也是同样的情况，因此，我们需要对 URL 传递的参数进行编码，把传递的参数内容隐藏起来。

URL 编码是指针对网页url中的中文字符的一种编码转化方式，最常见的就是Baidu等搜索引擎中输入中文查询时候，生成经过Encode过的网页URL。

![1594697347256](C:\Users\zzh\AppData\Roaming\Typora\typora-user-images\1594697347256.png)

## PHP怎么对URL编码

```php
3 echo urlencode("中文-_. ")."\n"; //%D6%D0%CE%C4-_.+
4 echo urldecode("%D6%D0%CE%C4-_. ")."\n"; //中文-_.
5 echo rawurlencode("中文-_. ")."\n"; //%D6%D0%CE%C4-_.%20
6 echo rawurldecode("%D6%D0%CE%C4-_. ")."\n"; //中文-_.
# 除了“-_.”之外的所有非字母数字字符都将被替换成百分号“%”后跟两位十六进制数。
# urlencode和rawurlencode的区别：urlencode将空格编码为加号“+”，rawurlencode将空格编码为加号“%20”。
```

还有一种方式比较常用，就是对数据进行base_64编码

```php
$str = 'This is an encoded string';
echo base64_encode($str);

$str = 'VGhpcyBpcyBhbiBlbmNvZGVkIHN0cmluZw==';
echo base64_decode($str);
```

又或者通过http_build_query() 生成 URL-encode 之后的请求字符串

```php
<?php
$data = array('foo'=>'bar',
              'baz'=>'boom',
              'cow'=>'milk',
              'php'=>'hypertext processor');

echo http_build_query($data) . "\n";
echo http_build_query($data, '', '&amp;');

# 以上例程会输出：
foo=bar&baz=boom&cow=milk&php=hypertext+processor
foo=bar&amp;baz=boom&amp;cow=milk&amp;php=hypertext+processor
```

parse_url()还可以解析 URL，返回其组成部分

```php
$url = 'http://username:password@hostname/path?arg=value#anchor';
print_r(parse_url($url));
echo parse_url($url, PHP_URL_PATH);

# 以上会输出：
Array
(
    [scheme] => http
    [host] => hostname
    [user] => username
    [pass] => password
    [path] => /path
    [query] => arg=value
    [fragment] => anchor
)
/path
```

