### PHP 利用json_decode解析json为null问题

1. json字符串中反斜杠被转 

```php
#反斜杠被转义，需要用htmlspecialchars_decode()函数处理一下$content ，然后再json_decode()即可。
{
	"key":"value\/M00\/00\/0D\/rBAK31"  
} 

$content = htmlspecialchars_decode($content);  

#或者，在保存 json 数据时使用 urlencode() 函数：
$content = urlencode(json_encode($content));  

#解析时使用urldecode()函数：
$content = json_decode(urldecode($content));  
#即可避免反斜杠转义造成的无法解析。
```



2. json数据不合法问题

```PHP
#示例json代码：
{q:"风语",p:false,s:["风语者","风语战士"]}  

#虽然在工具里可以正常格式化，但是需要补充完善如下：
{"q":"风语","p":false,"s":["风语者","风语战士"]} 

json_last_error()比较常见的是整数4, 是json字符串在json_decode之前已不完整，所以语法错误。
```

​																					**JSON错误码**

| 常量                            | 含义                                                         | 可用性    |
| ------------------------------- | ------------------------------------------------------------ | --------- |
| **JSON_ERROR_NONE**             | 没有错误发生                                                 |           |
| **JSON_ERROR_DEPTH**            | 到达了最大堆栈深度                                           |           |
| **JSON_ERROR_STATE_MISMATCH**   | 无效或异常的 JSON                                            |           |
| **JSON_ERROR_CTRL_CHAR**        | 控制字符错误，可能是编码不对                                 |           |
| **JSON_ERROR_SYNTAX**           | 语法错误                                                     |           |
| **JSON_ERROR_UTF8**             | 异常的 UTF-8 字符，也许是因为不正确的编码。                  | PHP 5.3.3 |
| **JSON_ERROR_RECURSION**        | One or more recursive references in the value to be encoded  | PHP 5.5.0 |
| **JSON_ERROR_INF_OR_NAN**       | One or more        [**NAN**](mk:@MSITStore:C:\Users\zzh\Desktop\xinphp_manual_zh.chm::/res/language.types.float.html#language.types.float.nan)       or [**INF**](mk:@MSITStore:C:\Users\zzh\Desktop\xinphp_manual_zh.chm::/res/function.is-infinite.html)       values in the value to be encoded | PHP 5.5.0 |
| **JSON_ERROR_UNSUPPORTED_TYPE** | A value of a type that cannot be encoded was given           |           |

另，其它的json_decode($str)返回NULL的一些原因：

​    1). $str只能UTF-8编码

​    2). 元素最后不能有逗号（与php的array不同）

​    3). 元素不能使用单引号

​    4). 元素值中间不能有空格和n，必须替换。

