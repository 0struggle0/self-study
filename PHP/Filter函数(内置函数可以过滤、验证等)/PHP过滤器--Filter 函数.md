## 什么是 PHP 过滤器？

PHP 过滤器就是用于验证和过滤接收数据的一组系统函数，即filter函数。

## 为什么要使用过滤器？

我们编写的程序几乎都有依赖外部输入的数据，这些数据包括：

- 来自用户表单的输入数据
- Cookies缓存的数据
- 其他应用程序（比如 web 服务）的数据
- 定义的服务器变量
- 数据库查询结果

这些非安全来源的数据是未知的，存在风险的。

**我们应该始终对外部数据进行过滤，不要相信任何外部数据！**

风险包括接收的数据格式不符合我们的预期，数据类型不符合我们的预期等；如果不对这些数据进行验证和过滤，那么不仅给我们的程序留有很大的安全漏洞，而且会对后续的功能流程的数据使用会带来很大困扰，比如会出现数据提交错乱、数据展示等问题。

基本操作就是我们需要N多个判断，就像这样：

```php
function validate()
{
    if (is_numeric($_POST['id'])) {
        $id = intval($_POST['id']);
    } else {
        throw new Exception('错误的id');
    }

    if (!empty($_POST['name']) && is_string($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        throw new Exception('错误的name');
    }
    
    // 或许还有N多类似的判断
    .
    .
    .
    
    return ['id' => $id, 'name' => $name];
}
```

如果传过来的数据有很多参数，就要写很多对应的判断，是不是感觉有点麻烦？

麻烦就对了，所有就有了验证器的类库，比如webmozart/assert

```php
function validate()
{
    try {
        Assert::keyExists($_POST, 'name', 'The key not exists. Got: %s');
        Assert::string($_POST['name'], 'The path is expected to be a string. Got: %s');
        Assert::numeric($_POST['id'], 'The value is not numeric. Got: %s');
    } catch (InvalidArgumentException $th) {
       return $th->getMessage();
    }
}
```

但是这种验证器类库只有验证的功能，并没有过滤的功能。

PHP 的过滤器扩展的设计目的是使数据过滤更轻松快捷，不仅可以验证，还可以过滤数据，所以我们要通过使用过滤器，确保应用程序获得正确的输入类型和符合格式的数据。



## Filter 函数的使用

### 1. filter_has_var -- 函数检查是否存在指定输入类型的变量

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

### 2. filter_var() - 通过一个指定的过滤器来过滤单一的变量

```php
<?php
$email_a = 'joe@example.com';
$email_b = 'bogus';
$int = 123;

if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
    echo "Email address '$email_a' is considered valid.\n";
}

if (filter_var($email_b, FILTER_VALIDATE_EMAIL)) {
    echo "Email address '$email_b' is considered valid.\n";
} else {
    echo "Email address '$email_b' is considered invalid.\n";
}

if (!filter_var($int, FILTER_VALIDATE_INT)) {
    echo ("不是一个合法的整数");
} else {
    echo ("是个合法的整数");
}
```

以上程序会输出：

```php
Email address 'joe@example.com' is considered valid.
Email address 'bogus' is considered invalid.
是个合法的整数
```



#### Validating 和 Sanitizing 两种过滤器：

Validating 过滤器：

- 用于验证用户输入
- 严格的格式规则（比如 URL 或 E-Mail 验证）
- 如果成功则返回预期的类型，如果失败则返回 FALSE

Sanitizing 过滤器：

- 用于允许或禁止字符串中指定的字符
- 无数据格式规则
- 始终返回字符串



#### 选项和标志

选项和标志用于向指定的过滤器添加额外的过滤选项。

不同的过滤器有不同的选项和标志。

在下面的实例中，我们用 filter_var() 和 "min_range" 以及 "max_range" 选项验证了一个整数：

```php
$var = 300;
$int_options = array(
    "options" => array(
        "min_range" => 0,
        "max_range" => 256
    )
);

if (!filter_var($var, FILTER_VALIDATE_INT, $int_options)) {
    echo ("不是一个合法的整数");
} else {
    echo ("是个合法的整数");
}
```

由于整数是 "300"，它不在指定的范围内，以上代码的输出将是：

```php
不是一个合法的整数
```



#### 净化输入

```php
$email = '(bogus@example.org)';
$sanitized_email = filter_var($email, FILTER_SANITIZE_EMAIL);
if (filter_var($sanitized_email, FILTER_VALIDATE_EMAIL)) {
    echo "This (email) sanitized email address is considered valid.\n";
    echo "Before: $email\n";
    echo "After:  $sanitized_email\n";    
}
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



### 6. filter_id() 函数 -- 返回指定过滤器的 ID 号

```php
#如果获取成功则返回过滤器id，如果过滤器不存在则返回 FALSE
int filter_id( string $filtername)

#filtername 必须是过滤器名称（不是过滤器 ID 名）
#如果不清楚过滤器名称, 使用 filter_list() 函数来获取所有被支持的过滤器的名称

echo(filter_id("validate_email")); // 返回过滤器ID 274
```



### 使用 Filter Callback

通过使用 FILTER_CALLBACK 过滤器，可以调用自定义的函数，把它作为一个过滤器来使用。这样，我们就拥有了数据过滤的完全控制权，也同时解决了filter函数只能处理部分类型的数据的问题。

您可以创建自己的自定义函数，也可以使用已存在的 PHP 函数。

将您准备用到的过滤器的函数，按指定选项的规定方法进行规定。在关联数组中，带有名称 "options"。

在下面的实例中，我们使用了一个自定义的函数把所有 "_" 转换为 "."：

```php
function convertSpace($string)
{
    return str_replace("_", ".", $string);
}
 
$string = "www_runoob_com!";
 
echo filter_var($string, FILTER_CALLBACK, array("options"=>"convertSpace"));
```

