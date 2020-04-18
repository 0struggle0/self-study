# Filter 函数的使用

为什么要使用filter函数？平时写后端代码的时候总需要去验证前端传过来的参数格式、长度等等是否合适，有时还需要使用正则匹配。使用PHP内置的filter函数，主需要指定参数名称，要使用的过滤器，就可以进行验证，非常方便。



## 1. filter_has_var -- 函数检查是否存在指定输入类型的变量

```php
#成功时返回 TRUE， 或者在失败时返回 FALSE。
bool filter_has_var( int $type, string $variable_name)

#type 可选类型INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, INPUT_ENV. 
#variable_name 要检查的变量的名称 
    
#示例1：
#地址栏输入链接：http://127.0.0.1/test.php?name=test
<?php
if (!filter_has_var(INPUT_GET, "name")) {
    echo ("Input type does not exist");
} else {
    echo ("Input type exists");
}

#输出结果：
Input type exists
    
使用此函数可以用来检查是否是GET、POST、COOKIE、SERVER、ENV等全局变量里是否有指定变量存在。
    
当然，也可以使用 isset($_GET["name"]) 、isset($_POST["name"])、isset($_SERVER["name"])等方式来判断全局变量里的参数是否存在
```



##2. filter_id() 函数 -- 返回指定过滤器的 ID 号

```php
#如果获取成功则返回过滤器id，如果过滤器不存在则返回 FALSE
int filter_id( string $filtername)

#filtername 必须是过滤器名称（不是过滤器 ID 名）
#如果不清楚过滤器名称, 使用 filter_list() 函数来获取所有被支持的过滤器的名称

echo(filter_id("validate_email")); // 返回过滤器ID 274
```



## 3.filter_input -- 通过名称获取特定的外部变量，并且可以通过过滤器处理它

```php
#如果成功的话返回所请求的变量。如果过滤失败则返回 FALSE ，如果variable_name 不存在的话则返回 NULL. 如果标示 FILTER_NULL_ON_FAILURE 被使用了，那么当变量不存在时返回 FALSE ，当过滤失败时返回 NULL 
mixed filter_input( int $type, string $variable_name[, int $filter = FILTER_DEFAULT[, mixed $options]] )
    
#type 可选类型INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, INPUT_ENV. 
#variable_name 参数名称
#filter 过滤规则，可以在过滤规则页面找到想要用的过滤规则；如果不指定，将使用FILTER_DEFAULT，它相当于FILTER_UNSAFE_RAW。这将导致在默认情况下不进行过滤。
#options 一个选项的关联数组，或者按位区分的标示。如果过滤器接受选项，可以通过数组的 "flags" 位去提供这些标示。 

#示例1()：
<?php
$search_html = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
$search_url = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_ENCODED);
echo "You have searched for $search_html.\n";
echo "<a href='?search=$search_url'>Search again.</a>";
#输出结果：
You have searched for Me &#38; son.
<a href='?search=Me%20%26%20son'>Search again.</a>

#示例2(验证该值是否是有效的电子邮件地址)：
<?php
if (!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
    echo "E-Mail is not valid";
} else {
    echo "E-Mail is valid";
}

#示例3(验证ip是否是内网ip)
#如果是内网IP则返回false，否则返回原IP
// $ip = '192.168.1.197';
// $ip = '39.104.162.134';
// $ip = '47.110.85.106';
// $ip = '219.143.3.146';
$result = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
var_dump($result);
```



## 4. filter_input_array -- 获取一系列外部变量，并且可以通过过滤器处理它们

```php
#这个函数当需要获取很多变量却不想重复调用filter_input()时很有用。 
#如果成功的话返回一个所请求的变量的数组，如果失败的话返回 FALSE 。对于数组的值，如果过滤失败则返回 FALSE ，如果variable_name 不存在的话则返回 NULL 。如果标示 FILTER_NULL_ON_FAILURE 被使用了，那么当变量不存在时返回 FALSE ，当过滤失败时返回 NULL 。 
mixed filter_input_array( int $type[, mixed $definition[, bool $add_empty = true]] )
    
#type 可选类型INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, INPUT_ENV
#definition 一个定义参数的数组。一个有效的键必须是一个包含变量名的string，一个有效的值要么是一个filter type，或者是一个array 指明了过滤器、标示和选项。如果值是一个数组，那么它的有效的键可以是 filter，用于指明 filter type，flags 用于指明任何想要用于过滤器的标示，或者 options 用于指明任何想要用于过滤器的选项。
#这个参数也可以是一个filter constant的整数。那么数组中的所有变量都会被这个过滤器所过滤。 
    
#示例1：
<?php
error_reporting(E_ALL | E_STRICT);
/* data actually came from POST
$_POST = array(
    'product_id'    => 'libgd<script>',
    'component'     => '10',
    'versions'      => '2.0.33',
    'testscalar'    => array('2', '23', '10', '12'),
    'testarray'     => '2',
);
*/

$args = array(
    'product_id'   => FILTER_SANITIZE_ENCODED,
    'component'    => array('filter'    => FILTER_VALIDATE_INT,
                            'flags'     => FILTER_REQUIRE_ARRAY, 
                            'options'   => array('min_range' => 1, 'max_range' => 10)
                           ),
    'versions'     => FILTER_SANITIZE_ENCODED,
    'doesnotexist' => FILTER_VALIDATE_INT,
    'testscalar'   => array(
                            'filter' => FILTER_VALIDATE_INT,
                            'flags'  => FILTER_REQUIRE_SCALAR,
                           ),
    'testarray'    => array(
                            'filter' => FILTER_VALIDATE_INT,
                            'flags'  => FILTER_REQUIRE_ARRAY,
                           )

);

$myinputs = filter_input_array(INPUT_POST, $args);
var_dump($myinputs);
echo "\n";
 
输出结果：
array(6) {
  ["product_id"]=>
  array(1) {
    [0]=>
    string(17) "libgd%3Cscript%3E"
  }
  ["component"]=>
  array(1) {
    [0]=>
    int(10)
  }
  ["versions"]=>
  array(1) {
    [0]=>
    string(6) "2.0.33"
  }
  ["doesnotexist"]=>
  NULL
  ["testscalar"]=>
  bool(false)
  ["testarray"]=>
  array(1) {
    [0]=>
    int(2)
  }
}

```

> **注意**:     
>
> 在 **INPUT_SERVER** 数组中并没有 *REQUEST_TIME* ，因为它是被稍后插入到[$_SERVER](mk:@MSITStore:C:\Users\zzh\Desktop\xinphp_manual_zh.chm::/res/reserved.variables.server.html) 中的。 



## 5. filter_list -- 返回所支持的过滤器列表

```php
#返回一个所支持的过滤器的名称的列表，如果没有这样子的过滤器的话则返回空数组。这个数组的索引不是过滤器id，你可以通过 filter_id() 去根据名称获取它们
array filter_list( void)
    
#示例1(输出所有支持的过滤器)：
<?php
print_r(filter_list());

输出结果：
Array
(
    [0] => int
    [1] => boolean
    [2] => float
    [3] => validate_regexp
    [4] => validate_url
    [5] => validate_email
    [6] => validate_ip
    [7] => string
    [8] => stripped
    [9] => encoded
    [10] => special_chars
    [11] => unsafe_raw
    [12] => email
    [13] => url
    [14] => number_int
    [15] => number_float
    [16] => magic_quotes
    [17] => callback
)
```