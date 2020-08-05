最近工作中频繁和其他部门甚至公司进行接口上的对接，不免接触到林林总总的签名验权算法。

其中属HMAC-SHA1签名算法最多，刚开始接触的时候我也觉得有一点懵，慢慢搞清楚了原理，所以在这里跟大家如何理解这种签名算法中涉及到的各种各样的东西。

扫盲：
首先做个简单的扫盲
1、md5（md家族）
Message Digest Algorithm 缩写为MD，消息摘要算法，一种被广泛使用的密码散列函数。

2、sha1（sha家族）
secure hash algorithm 缩写为SHA，密码散列函数。能计算出一个数字消息所对应到的，长度固定的字符串（又称消息摘要）的算法，其实也就是我们常说的加密串长度固定。
上述这些算法（md,sha）之所以称作安全算法基于以下两点：
（1）由消息摘要反推原输入消息，从计算理论上来说是很困难的。说白了就是不可逆。
（2）想要找到两组不同的消息对应到相同的消息摘要，从计算理论上来说是很困难的。任何对输入消息的变动，都会很高概率导致其产生的消息摘要迥异。说白了，就是加密串碰撞度较低，并且内容有微调，秘钥串生成差异化也很大。

3、hamc
HMAC：散列消息身份验证码 Hashed Message Authentication Code 。它不是散列函数，而是采用了将MD5或SHA1散列函数与共享机密秘钥（与公钥/秘钥对不同）一起使用的消息身份验证机制。消息与秘钥组合并运行散列函数（md5或sha1），然后运行结果与秘钥组合并再次运行散列函数。
目前hmac主要应用在身份验证中，在用户登录传递密码的过程中可以利用，签名来防止密码明文传递。
可参看该文：http://blog.csdn.net/yasi_xi/article/details/19968449
讲到这里大家应该就能明白了，HMAC-SHA1简要来说，就是采用sha1算法，与HMAC机制相结合，制造出更加难以破解的加密串。
hash_hmac
在php中hash_hmac函数就能将HMAC和一部分哈希加密算法相结合起来实现HMAC-SHA1  HMAC-SHA256 HMAC-MD5等等算法。函数介绍如下：
string hash_hmac(string $algo, string $data, string $key, bool $raw_output = false)
algo：要使用的哈希算法名称，可以是上述提到的md5,sha1等
data：要进行哈希运算的消息，也就是需要加密的明文。
key：使用HMAC生成信息摘要是所使用的密钥。
raw_output：该参数为可选参数，默认为false，如果设为true，则返回原始二进制数据表示的信息摘要，否则返回16进制小写字符串格式表示的信息摘要（注意是16进制数，而非简单的字母加数字）。
另外：如果algo参数指定的不是受支持的算法，将返回false。

应用：
一般来讲，目前最流行的接口签名方式，是采用hash_hamc('sha1')方法；
1、将 Accesskey（公钥）和Secretkey（私钥）简称ak,sk，告知客户端（或接口调用者）
2、按照接口提供方的要求，提取出需要加密的消息串。比如uri;
3、通过hash_hamc('sha1',uri,Secretkey);得到签名；
3'、一般而言接口提供方，都会要求对加密串进行base64urlencode，防止签名串被特殊字符分割，导致验证无法通过。
4、将签名注入http协议头中；$headerArr[] = 'accessToken:'.$akey.":".$ret;
5、发送请求即可。

以下是完整的php demo代码：

```php

$akey = "66a66666da6666666d66aa6a6aa6a6a66a666aa6";
$url = "http://api.xxx.com/web/api/xxx/xxx?u=".$u;
$uri = "/web/api/xxx/xxx?u=".$u."\n";
$SecretKey = '999999999999999999999999999999aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
$str  = hash_hmac("sha1", $uri, $SecretKey);
$signature = base64UrlEncode($hex);
$headerArr = array();
$headerArr[] = 'accessToken:'.$akey.":".$ret;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$return = curl_exec($ch);
curl_close($ch);
 
function base64UrlEncode($str)
{
     $find = array('+', '/');
     $replace = array('-', '_');
     return str_replace($find, $replace, base64_encode($str));
}
```

总结：
HMAC-SHA1是我在工作中接触到的最流行的一种加密算法，这里讲了如何一步步去理解这种加密算法，以及如何正确的使用hash_hmac函数来得到正确的加密串。



问题：

1. 接口规范文档的编写，接口的调用
2. header函数的使用
3. POST、GET传参的格式（REST FUL API）
4. 各种加密算法